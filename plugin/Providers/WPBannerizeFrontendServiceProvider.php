<?php

namespace WPBannerize\Providers;

use WPBannerize\WPBones\Support\ServiceProvider;

class WPBannerizeFrontendServiceProvider extends ServiceProvider
{

  public function register()
  {

    add_action( 'wp_loaded', [ $this, 'wp_loaded' ], 99 );
    add_action( 'wp_head', [ $this, 'wp_head' ] );
    add_action( 'wp_footer', [ $this, 'wp_footer' ] );

    if ( ! is_admin() ) {
      wp_enqueue_style( 'wp-bannerize',
                        WPBannerize()->css . '/wp-bannerize.min.css',
                        [],
                        WPBannerize()->Version
      );
    }
  }

  public function wp_head()
  {
    ?>
    <script>
      window.ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ) ?>";
      window.WPBannerize = <?php echo WPBannerize()->options ?>;
    </script>
    <?php
  }

  public function wp_footer()
  {
    ?>
    <script>

      jQuery( function( $ )
      {
        "use strict";

        // Add a custom event on document in order to init again the impressions and clicks.
        $( document ).on( 'wpbannerize.init.impressions', _initImpressions );
        $( document ).on( 'wpbannerize.init.clicks', _initClicks );

        function _initImpressions()
        {
          // impressions
          if( !window.WPBannerize.General.impressions_enabled ) {
            return;
          }

          window.WPBannerizeImpressions = [];

          $( 'div[data-impressions_enabled="true"]' ).each(
            function( i, e )
            {
              var banner_id, $this = $( e );

              if( $this.is( ':visible' ) ) {
                banner_id = $this.data( 'banner_id' );

                if( banner_id > 0 ) {

                  console.log( 'push', banner_id );

                  WPBannerizeImpressions.push( banner_id );
                  $this.data( 'impressions_enabled', false );
                }
              }
            }
          );

          if( window.WPBannerizeImpressions.length > 0 ) {

            console.log( 'post', WPBannerizeImpressions );

            $.post( ajaxurl,
              {
                action    : 'wp_bannerize_add_impressions',
                banner_id : WPBannerizeImpressions,
                referrer  : document.location.href
              },
              function( data )
              {

              }
            );
          }
        }

        function _initClicks()
        {
          // clicks
          if( !window.WPBannerize.General.clicks_enabled ) {
            return;
          }

          $( 'div[data-clicks_enabled="true"]' ).each(
            function( i, e )
            {
              if( $( e ).is( ':visible' ) ) {
                var banner_id = $( e ).data( 'banner_id' );

                // Remove all previous
                $( e ).find( 'a' ).off( 'click' );

                // Attach my event
                $( e ).find( 'a' ).on( 'click',
                  function()
                  {
                    // Ajax
                    $.post( ajaxurl,
                      {
                        action    : 'wp_bannerize_add_clicks',
                        banner_id : banner_id,
                        referrer  : document.location.href
                      },
                      function( data )
                      {
                        //
                      }
                    );
                  } );
              }
            } );
        }

        _initImpressions();
        _initClicks();

      } );
    </script>
    <?php
  }

  public function wp_loaded()
  {
    $requestMethod = isset( $_SERVER[ 'REQUEST_METHOD' ] ) ? $_SERVER[ 'REQUEST_METHOD' ] : '';
    $requestUri    = isset( $_SERVER[ 'REQUEST_URI' ] ) ? $_SERVER[ 'REQUEST_URI' ] : '';
    $queryString   = isset( $_SERVER[ 'QUERY_STRING' ] ) ? $_SERVER[ 'QUERY_STRING' ] : '';

    if ( strtolower( $requestMethod ) === 'get' && substr( $requestUri, 0, 18 ) === "/wp_bannerize_pro?" ) {

      $queryParams = [];
      parse_str( $queryString, $queryParams );

      if ( isset( $queryParams[ 'id' ] ) && ! empty( $queryParams[ 'id' ] ) ) {
        $post = get_post( $queryParams[ 'id' ] );

        ?>
        <!DOCTYPE html>
        <html>
          <body>
            <?php echo do_shortcode( $post->post_content ) ?>
          </body>
        </html>
        <?php

        die();

      }
    }
  }

}