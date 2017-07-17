<?php if ( ! defined( 'ABSPATH' ) ) {
  exit;
} ?>

<div class="wp-bannerize-settings wrap">

  <h2><?php _e( 'WP Bannerize Settings', WPBANNERIZE_TEXTDOMAIN ) ?></h2>

  <?php if ( isset( $feedback ) ) : ?>

    <div id="message"
         class="updated notice is-dismissible"><p><?php echo $feedback ?></p></div>

  <?php endif; ?>

  <div class="wpbones-tabs">

    <?php WPBannerize\PureCSSTabs\PureCSSTabsProvider::openTab( __( 'Analytics', WPBANNERIZE_TEXTDOMAIN ), null, true ) ?>

    <form action=""
          method="post">

      <?php wp_nonce_field( 'wp_bannerize' ); ?>

      <p>
        <?php
        echo WPBannerize\PureCSSSwitch\Html\HtmlTagSwitchButton::name( 'General/impressions_enabled' )
                                                               ->checked( $plugin->options->get( 'General/impressions_enabled' ) )
                                                               ->right_label( __( 'Enable Impressions', WPBANNERIZE_TEXTDOMAIN ) );
        ?>
      </p>

      <p>
        <?php
        echo WPBannerize\PureCSSSwitch\Html\HtmlTagSwitchButton::name( 'General/clicks_enabled' )
                                                               ->checked( $plugin->options->get( 'General/clicks_enabled' ) )
                                                               ->right_label( __( 'Enable Clicks', WPBANNERIZE_TEXTDOMAIN ) );
        ?>
      </p>

      <p>
        <button class="button button-primary">Update</button>
      </p>

    </form>

    <?php WPBannerize\PureCSSTabs\PureCSSTabsProvider::closeTab() ?>

    <?php WPBannerize\PureCSSTabs\PureCSSTabsProvider::openTab( __( 'Layout', WPBANNERIZE_TEXTDOMAIN ), null ) ?>
    <div>
      <p>
        <?php _e( 'Here you can set the banner margin. The values are in pixel.', WPBANNERIZE_TEXTDOMAIN ) ?>
      </p>
      <table class="wp-bannerize-layout"
             style="border-collapse: collapse"
             width="100px">
        <tbody>
        <tr>
          <td></td>
          <td align="center"><input type="number"
                                    name="top"
                                    size="2"
                                    style="width:50px"
                                    value="<?php echo WPBannerize()->options['Layout.top'] ?>"/></td>
          <td></td>
        </tr>
        <tr>
          <td><input type="number"
                     name="left"
                     size="2"
                     style="width:50px"
                     value="<?php echo WPBannerize()->options['Layout.left'] ?>"/></td>
          <td>
            <div style="background-color: #eee;width: 50px;height: 50px;border:2px solid #ddd"></div>
          </td>
          <td><input type="number"
                     name="right"
                     size="2"
                     style="width:50px"
                     value="<?php echo WPBannerize()->options['Layout.right'] ?>"/></td>
        </tr>
        <tr>
          <td></td>
          <td align="center"><input type="number"
                                    name="bottom"
                                    size="2"
                                    style="width:50px"
                                    value="<?php echo WPBannerize()->options['Layout.bottom'] ?>"/></td>
          <td></td>
        </tr>
        </tbody>
      </table>
    </div>
    <?php WPBannerize\PureCSSTabs\PureCSSTabsProvider::closeTab() ?>
  </div>
</div>

<script>
  jQuery( document ).ready(
    function( $ )
    {
      $( document ).on( 'change', '.wp-bannerize-layout input[type="number"]',
        function( e )
        {
          console.log( e.target.name, e.target.value );

          $.post(
            ajaxurl,
            {
              action : 'wp_bannerize_layout',
              border : e.target.name,
              value  : e.target.value
            },
            function( data )
            {
              // response
            }
          );
        }
      );
    }
  );
</script>