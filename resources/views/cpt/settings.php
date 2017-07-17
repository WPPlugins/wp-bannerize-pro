<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

WPBannerize\PureCSSTabs\PureCSSTabsProvider::openTab( __( 'Settings', WPBANNERIZE_TEXTDOMAIN ) ) ?>

  <p>
    <?php _e( 'Here you can set the link and other attributes', WPBANNERIZE_TEXTDOMAIN ) ?>
  </p>

  <div>
    <label for="wp_bannerize_banner_link">
      <?php _e( 'Link', WPBANNERIZE_TEXTDOMAIN ) ?>:
      <input type="url"
             title="<?php _e( 'This is the URL that allows you to link the banner', WPBANNERIZE_TEXTDOMAIN ) ?>"
             placeholder="<?php _e( 'http://', WPBANNERIZE_TEXTDOMAIN ) ?>"
             value="<?php echo $banner->banner_link ?>"
             name="wp_bannerize_banner_link"/>
    </label>

    <label for="wp_bannerize_banner_target">
      <?php _e( 'Target', WPBANNERIZE_TEXTDOMAIN ) ?>:
      <?php
      $target = [
        ''        => __( 'None', WPBANNERIZE_TEXTDOMAIN ),
        '_blank'  => __( '_blank', WPBANNERIZE_TEXTDOMAIN ),
        '_parent' => __( '_parent', WPBANNERIZE_TEXTDOMAIN ),
        '_self'   => __( '_self', WPBANNERIZE_TEXTDOMAIN ),
        '_top'    => __( '_top', WPBANNERIZE_TEXTDOMAIN ),
      ];
      ?>

      <select name="wp_bannerize_banner_target"
              id="wp_bannerize_banner_target">
        <?php foreach ( $target as $key => $value ) : ?>
          <option value="<?php echo $key ?>"
            <?php selected( $key, $banner->banner_target ) ?>>
            <?php echo $value ?>
          </option>
        <?php endforeach; ?>
      </select>

    </label>

    <p>
      <?php
      echo WPBannerize\PureCSSSwitch\Html\HtmlTagSwitchButton::name( 'wp_bannerize_banner_no_follow' )
                                                             ->checked( $banner->banner_no_follow )
                                                             ->right_label( __( 'Add "nofollow"', WPBANNERIZE_TEXTDOMAIN ) );
      ?>
    </p>

  </div>

  <div>
    <p>
      <?php _e( 'Use this field as alternative alt/title description for banner. If you leave this field blank the title of banner will be use instead.', WPBANNERIZE_TEXTDOMAIN ) ?>
    </p>

    <textarea id="wp_bannerize_banner_description"
              name="wp_bannerize_banner_description"><?php echo $banner->banner_description ?></textarea>

  </div>

<?php WPBannerize\PureCSSTabs\PureCSSTabsProvider::closeTab();