<?php

/*
|--------------------------------------------------------------------------
| Plugin activation
|--------------------------------------------------------------------------
|
| This file is included when the plugin is activated the first time.
| Usually you will use this file to register your custom post types or
| to perform some db delta process.
|
*/

if ( ! function_exists( 'wp_bannerize_activation' ) ) {

  function wp_bannerize_activation()
  {
    /**
     * @var wpdb $wpdb
     */
    global $wpdb;

    $wp_bannerize_table_name = "{$wpdb->prefix}bannerize";

    $sql = "SHOW TABLES LIKE '{$wp_bannerize_table_name}'";

    try {
      $result = $wpdb->get_var( $sql );
    }
    catch( \Exception $e ) {
      $result = null;
    }

    if ( ! is_null( $result ) && $wp_bannerize_table_name == $result ) {

      update_option( 'wp_bannerize_old_table', true );
      update_option( 'wp_bannerize_do_import', true );

      return true;
    }

    delete_option( 'wp_bannerize_old_table' );
    delete_option( 'wp_bannerize_do_import' );

    return false;
  }

  wp_bannerize_activation();
}