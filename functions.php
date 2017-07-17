<?php

use WPBannerize\Models\WPBannerizePost;
use WPBannerize\Models\WPBannersQuery;

if( ! function_exists( 'wp_bannerize_pro_sanitize_mysql_datetime' ) ) {

  function wp_bannerize_pro_sanitize_mysql_datetime( $value )
  {
    $result = '';

    if( ! empty( $value ) ) {
      if ( false !== strpos( $value, '-' ) ) {
        $time   = strtotime( $value );
        $result = date( 'Y-m-d H:i:s', $time );
        $check  = strtotime( $result );
      }

      if ( empty( $check ) ) {
        return date( 'Y-m-d H:i:s' );
      }
    }

    return $result;
  }
}

if ( ! function_exists( 'wp_bannerize_pro' ) ) {
  function wp_bannerize_pro( $args = [] )
  {
    // Backward compatibily
    $args = wp_parse_args( $args );

    // Check for single banner
    if ( isset( $args[ 'id' ] ) && ! empty( $args[ 'id' ] ) ) {

      // Check for string
      if ( is_string( $args[ 'id' ] ) ) {
        $ids = explode( ',', $args[ 'id' ] );
      }
      else {
        $ids = (array) $args[ 'id' ];
      }

      // Support random order
      if ( isset( $args[ 'orderby' ] ) && 'random' == $args[ 'orderby' ] ) {
        shuffle( $ids );
      }

      if ( ! isset( $args[ 'layout' ] ) ) {
        $args[ 'layout' ] = 'vertical';
      }

      ?>
      <div class="wp_bannerize_container wp_bannerize_layout_<?php echo $args[ 'layout' ] ?>"><?php

      // Loop into the banner id or slug
      foreach ( $ids as $id ) {

        // Create a banner instance
        $banner = WPBannerizePost::find( $id, 'wp_bannerize' );

        // If no banner found return the content
        if ( ! is_null( $banner ) ) {
          $banner->display();
        }
      }

      ?></div><?php
    }
    else {
      // For stability reason remove the id
      unset( $args[ 'id' ] );

      // Select banners
      echo WPBannersQuery::query( $args );

    }
  }
}