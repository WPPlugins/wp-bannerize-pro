<?php

namespace WPBannerize\Providers;

use WPBannerize\WPBones\Support\ServiceProvider;

class WPBannerizeServiceProvider extends ServiceProvider
{

  public function register()
  {
    //plugin list
    add_action( 'plugin_action_links_' . WPBannerize()->pluginBasename, [ $this, 'plugin_action_links' ], 10, 4 );

    // check for old wp bannerize table
    $result = get_option( 'wp_bannerize_do_import', false );

    if ( $result ) {
      add_action( 'admin_notices', [ $this, 'admin_notices_import' ] );
    }
    else {

      // check for old wp bannerize table
      $result = get_option( 'wp_bannerize_old_table', false );

      if ( $result ) {
        add_action( 'admin_notices', [ $this, 'admin_notices_table' ] );
      }
    }
  }

  public function admin_notices_table()
  {
    $import = '<a class="button button-primary" href="' . admin_url( 'edit.php?post_type=wp_bannerize&page=wpbannerize_import', false ) . '">' . __( 'Click Here', WPBANNERIZE_TEXTDOMAIN ) . '</a>';

    ?>
    <div class="notice notice-info is-dismissible">
      <h2>WP Bannerize</h2>
      <p><?php _e( 'You still got the previous version of WP Bannerize database table! Please ' . $import . ' to remove!', WPBANNERIZE_TEXTDOMAIN ); ?></p>
    </div>
    <?php
  }

  public function admin_notices_import()
  {
    $import = '<a class="button button-primary" href="' . admin_url( 'edit.php?post_type=wp_bannerize&page=wpbannerize_import', false ) . '">' . __( 'Import', WPBANNERIZE_TEXTDOMAIN ) . '</a>';

    ?>
    <div class="notice notice-warning is-dismissible">
      <h2>WP Bannerize</h2>
      <p><?php _e( 'You still have to complete the import of the previous version of database table! Please, ' . $import . ' to complete the import', WPBANNERIZE_TEXTDOMAIN ); ?></p>
    </div>
    <?php
  }

  public function plugin_action_links( $links )
  {
    $settings = '<a href="' . admin_url( 'edit.php?post_type=wp_bannerize&page=wpbannerize_settings', false ) . '">' . __( 'Settings', WPBANNERIZE_TEXTDOMAIN ) . '</a>';
    array_unshift( $links, $settings );

    if ( get_option( 'wp_bannerize_do_import', false ) ) {
      $import = '<a href="' . admin_url( 'edit.php?post_type=wp_bannerize&page=wpbannerize_import', false ) . '">' . __( 'Import', WPBANNERIZE_TEXTDOMAIN ) . '</a>';
      array_unshift( $links, $import );
    }

    return $links;
  }

}