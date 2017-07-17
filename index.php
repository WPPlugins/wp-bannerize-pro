<?php

/**
 * Plugin Name: WP Bannerize Pro
 * Plugin URI: http://undolog.com
 * Description: WP Bannerize Pro is an easy to use adv image manager with html and free text support.
 * Version: 1.2.4
 * Author: Giovambattista Fazioli
 * Author URI: http://undolog.com
 * Text Domain: wp-bannerize
 * Domain Path: localization
 *
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/
use WPBannerize\WPBones\Foundation\Plugin;

require_once __DIR__ . '/bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Bootstrap the plugin
|--------------------------------------------------------------------------
|
| We need to bootstrap the plugin.
|
*/

// comodity define for text domain
define( 'WPBANNERIZE_TEXTDOMAIN', 'wp-bannerize' );

$GLOBALS[ 'WPBannerize' ] = require_once __DIR__ . '/bootstrap/plugin.php';

if ( ! function_exists( 'WPBannerize' ) ) {

  /**
   * Return the instance of plugin.
   *
   * @return Plugin
   */
  function WPBannerize()
  {
    return $GLOBALS[ 'WPBannerize' ];
  }
}