<?php
if ( ! defined( 'ABSPATH' ) ) exit;

WPBannerize\PureCSSTabs\PureCSSTabsProvider::openTab( __( 'Rules', WPBANNERIZE_TEXTDOMAIN ) ) ?>

  <div>
    <p>
      <?php _e( 'This banner will be visible on for the folowwing date range. Of course, you can left any fields blank for no date range.', WPBANNERIZE_TEXTDOMAIN ) ?>
    </p>
    <p>
      <label for=""><?php _e( 'Date from', WPBANNERIZE_TEXTDOMAIN ) ?></label>:
      <?php echo WPBannerize\Html::datetime()->name( 'wp_bannerize_banner_date_from' )->value( $banner->banner_date_from )->now( true )->clear( true ) ?>
    </p>

    <p>
      <label for=""><?php _e( 'Date to', WPBANNERIZE_TEXTDOMAIN ) ?></label>:
      <?php echo WPBannerize\Html::datetime()->name( 'wp_bannerize_banner_date_expiry' )->value( $banner->banner_date_expiry )->now( true )->clear( true ) ?>
    </p>

  </div>

<?php WPBannerize\PureCSSTabs\PureCSSTabsProvider::closeTab();