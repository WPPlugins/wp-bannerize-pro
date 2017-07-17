<?php WPBannerize\PureCSSTabs\PureCSSTabsProvider::openTab( __( 'Choose a Banner type', WPBANNERIZE_TEXTDOMAIN ), null, true ) ?>

  <div class="wp-bannerize-editor">

    <p>
      <?php _e( 'Select the type of Banner', WPBANNERIZE_TEXTDOMAIN ) ?>
    </p>

    <div class="wp-bannerize-btn-group">

      <?php

      $banner->banner_type = empty( wpbones_value( $banner->banner_type ) ) ? 'local' : $banner->banner_type;

      $types = [
        'local'  => __( 'Local', WPBANNERIZE_TEXTDOMAIN ),
        'remote' => __( 'Remote', WPBANNERIZE_TEXTDOMAIN ),
        'text'   => __( 'Text', WPBANNERIZE_TEXTDOMAIN ),
      ];

      foreach ( $types as $type => $label ) : ?>
        <label for="<?php echo $type ?>">
          <input type="radio"
                 id="<?php echo $type ?>"
                 data-tab="#wp-bannerize-tab-<?php echo $type ?>"
            <?php checked( $type, $banner->banner_type ) ?>
                 value="<?php echo $type ?>"
                 name="wp_bannerize_banner_type"/>
          <?php echo $label ?>
        </label>
      <?php endforeach; ?>
    </div>

    <div class="wp-bannerize-tab"
      <?php echo ( 'local' !== $banner->banner_type ) ? 'style="display:none"' : '' ?>
         id="wp-bannerize-tab-local">

      <h4>
        <?php _e( 'From this panel you can upload a local media into your WordPress installation.', WPBANNERIZE_TEXTDOMAIN ) ?>
      </h4>

      <input type="hidden"
             id="wp_bannerize_banner_url"
             name="wp_bannerize_banner_url"
             value="<?php echo $banner->banner_url ?>"/>

      <button data-uploader_title="<?php _e( 'Choose a file', WPBANNERIZE_TEXTDOMAIN ) ?>"
              data-uploader_button_text="<?php _e( 'Select', WPBANNERIZE_TEXTDOMAIN ) ?>"
              class="upload_image_button button button-primary button-large">
        <?php _e( 'Choose a file', WPBANNERIZE_TEXTDOMAIN ) ?>
      </button>
    </div>

    <div class="wp-bannerize-tab"
      <?php echo ( 'remote' !== $banner->banner_type ) ? 'style="display:none"' : '' ?>
         id="wp-bannerize-tab-remote">

      <h4>
        <?php _e( 'Use this panel to insert a remote URL for your media.', WPBANNERIZE_TEXTDOMAIN ) ?>
      </h4>

      <label for="wp_bannerize_banner_external_url"
             class="">
        <?php _e( 'URL', WPBANNERIZE_TEXTDOMAIN ) ?>
      </label>:

      <input class=""
             size="64"
             placeholder="http://"
             type="url"
             name="wp_bannerize_banner_external_url"
             id="wp_bannerize_banner_external_url"
             value="<?php echo $banner->banner_external_url ?>"/>
    </div>

    <div class="wp-bannerize-tab"
      <?php echo ( 'text' !== $banner->banner_type ) ? 'style="display:none"' : '' ?>
         id="wp-bannerize-tab-text">

      <h4>
        <?php _e( 'This is an amazing feature! You can create your own banner with this free rich text editor.', WPBANNERIZE_TEXTDOMAIN ) ?>
      </h4>

      <div id="wp-bannerize-post-content-container">
        <?php wp_editor( $banner->post_content, 'post_content' ) ?>
      </div>
    </div>

  </div>

<?php WPBannerize\PureCSSTabs\PureCSSTabsProvider::closeTab();


