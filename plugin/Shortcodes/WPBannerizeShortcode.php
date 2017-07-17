<?php

namespace WPBannerize\Shortcodes;

use WPBannerize\WPBones\Foundation\WordPressShortcodesServiceProvider as ServiceProvider;
use WPBannerize\GeoLocalizer\GeoLocalizerProvider;

class WPBannerizeShortcode extends ServiceProvider
{

  /**
   * List of registred shortcodes. {shortcode}/method
   *
   * @var array
   */
  protected $shortcodes = [
    'wp_bannerize_pro'     => 'wp_bannerize',
    'wp_bannerize_pro_geo' => 'wp_bannerize_pro_geo',
  ];


  /**
   * WP Bannerize Pro shortcode.
   *
   * @param array $atts    Optional.Attribute into the shortcode
   * @param null  $content Optional. HTML content
   *
   * @return string
   */
  public function wp_bannerize( $atts = [], $content = null )
  {
    // Default values for shortcode
    $defaults = [
      'random'          => false,       // deprecated since 1.3.5
      'id'              => false,
      'numbers'         => 10,
      'category'        => '',
      'categories'      => '',
      'order'           => 'DESC',
      'rank_seed'       => true,
      'orderby'         => 'menu_order', // 'impressions', 'clicks', 'ctr', 'random'
      'post_categories' => '',
      'layout'          => 'vertical',
    ];

    $atts = shortcode_atts( $defaults, $atts, 'wp_bannerize' );

    ob_start();

    if ( function_exists( 'wp_bannerize_pro' ) ) {
      wp_bannerize_pro( $atts );
    }

    $content = ob_get_contents();
    ob_end_clean();

    return $content;
  }

  public function wp_bannerize_pro_geo( $atts = [], $content = null )
  {
    return GeoLocalizerProvider::shortcode( $atts, $content );
  }
}