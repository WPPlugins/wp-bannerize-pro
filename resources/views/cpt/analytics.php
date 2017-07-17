<?php if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

WPBannerize\PureCSSTabs\PureCSSTabsProvider::openTab( __( 'Analytics', WPBANNERIZE_TEXTDOMAIN ) ) ?>

  <p>
    <?php _e( 'Of course, you can turn off the analytics for a single banner', WPBANNERIZE_TEXTDOMAIN ) ?>
  </p>

  <p>
    <?php
    echo WPBannerize\PureCSSSwitch\Html\HtmlTagSwitchButton::name( 'wp_bannerize_banner_impressions_enabled' )
                                                           ->checked( $banner->banner_impressions_enabled )
                                                           ->right_label( __( 'Enable Impressions', WPBANNERIZE_TEXTDOMAIN ) );
    ?>
  </p>
  <p>
    <?php
    echo WPBannerize\PureCSSSwitch\Html\HtmlTagSwitchButton::name( 'wp_bannerize_banner_clicks_enabled' )
                                                           ->checked( $banner->banner_clicks_enabled )
                                                           ->right_label( __( 'Enable Clicks', WPBANNERIZE_TEXTDOMAIN ) );
    ?>
  </p>

<?php WPBannerize\PureCSSTabs\PureCSSTabsProvider::closeTab();