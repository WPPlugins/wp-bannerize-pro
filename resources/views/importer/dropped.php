<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="wrap">

  <h2><?php _e( 'WP Bannerize Importer' ) ?></h2>

  <div style="text-align: center">
    <h3><?php _e( 'Previous table dropped!', WPBANNERIZE_TEXTDOMAIN ) ?></h3>

    <p>
      <a class="button button-primary button-hero"
         href="<?php echo admin_url( 'edit.php?post_type=wp_bannerize' ) ?>">
        <?php _e( 'Manage your new banners', WPBANNERIZE_TEXTDOMAIN ) ?>
      </a>
    </p>
  </div>

</div>