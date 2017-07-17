<?php
if ( ! defined( 'ABSPATH' ) ) exit;

WPBannerize\PureCSSTabs\PureCSSTabsProvider::openTab( __( 'Size', WPBANNERIZE_TEXTDOMAIN ) ) ?>

  <div>

    <?php if ( ! function_exists( 'getimagesize' ) ) : ?>
      <div>
        <?php _e( 'The function <code>getimagesize()</code> is not available. PHP GD Library are not installed. Please contact your administrator site to fix it.', WPBANNERIZE_TEXTDOMAIN ) ?>
      </div>
    <?php endif; ?>


    <p><?php _e( 'You now can enter your custom width and height with measure units. For example you can use <code>100px</code> or <code>100%</code> or <code>auto</code>. Leave blank to auto get the right size. Set a unit of measurement. If blank, we\'ll set pixels.', WPBANNERIZE_TEXTDOMAIN ) ?></p>

    <label for="wp_bannerize_banner_width">
      <?php _e( 'Custom width', WPBANNERIZE_TEXTDOMAIN ) ?>:
      <input name="wp_bannerize_banner_width"
             id="wp_bannerize_banner_width"
             type="text"
             value="<?php echo $banner->banner_width ?>"
             placeholder="<?php _e( 'eg: 100%', WPBANNERIZE_TEXTDOMAIN ) ?>"/>

    </label>

    <label for="wp_bannerize_banner_height">
      <?php _e( 'Custom height', WPBANNERIZE_TEXTDOMAIN ) ?>:
      <input name="wp_bannerize_banner_height"
             id="wp_bannerize_banner_height"
             type="text"
             value="<?php echo $banner->banner_height ?>"
             placeholder="<?php _e( 'eg: 100%', WPBANNERIZE_TEXTDOMAIN ) ?>"/>

    </label>

  </div>

<?php WPBannerize\PureCSSTabs\PureCSSTabsProvider::closeTab();