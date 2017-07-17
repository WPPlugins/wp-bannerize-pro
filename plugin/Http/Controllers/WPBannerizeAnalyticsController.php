<?php

namespace WPBannerize\Http\Controllers;

use WPBannerize\Models\WPBannerizeImpressions;
use WPBannerize\MorrisPHP\Morris;

class WPBannerizeAnalyticsController extends Controller
{

  protected $dateFrom;
  protected $dateTo;
  protected $categories = [];

  public function load()
  {

    //set_current_screen( sanitize_title( get_current_screen()->id ) );

    // meta box
    wp_enqueue_script( 'common' );
    wp_enqueue_script( 'wp-lists' );
    wp_enqueue_script( 'postbox' );

    wp_enqueue_style( 'wp-bannerize-analytics',
                      WPBannerize()->css . '/wp-bannerize-analytics.css',
                      [],
                      WPBannerize()->Version );

    // morris
    Morris::enqueue();

    $this->add_meta_boxes();
  }

  public function add_meta_boxes(  )
  {
    $metaBoxes = [
      '\WPBannerize\MetaBoxes\Summary',
      '\WPBannerize\MetaBoxes\Impressions',
      '\WPBannerize\MetaBoxes\Clicks',
      '\WPBannerize\MetaBoxes\ImpressionsBanners',
      '\WPBannerize\MetaBoxes\ClicksBanners',
      // '\WPBannerize\MetaBoxes\CTR',
    ];

    foreach ( $metaBoxes as $metaBox ) {
      $instance = new $metaBox();
    }
  }

  public function index()
  {
    return WPBannerize()->view( 'analytics.index' );
  }

  public function report()
  {

    $this->dateFrom   = mktime( 0, 0, 0, date( 'm' ) - 1 );
    $this->dateTo     = time();
    $this->categories = [];

    // morris
    Morris::enqueue();

    return WPBannerize()->view( 'analytics.report' )
                        ->withAdminStyles( 'wp-bannerize-analytics' )
                        ->withScripts( 'wp-bannerize-report', [ 'jquery', 'morris-js' ] )
                        ->with( 'date_presets', $this->datePresets() )
                        ->with( 'default_date_from', $this->dateFrom )
                        ->with( 'default_date_to', $this->dateTo )
                        ->with( 'banners', $this->banners() )
                        ->with( 'categories', $this->cagetories() );

  }

  protected function datePresets()
  {
    return [
      '' => __( 'Custom', WPBANNERIZE_TEXTDOMAIN ),

      esc_attr( json_encode(
                  [
                    'start' => mktime( 0, 0, 0 ),
                    'end'   => time(),
                  ]
                ) ) => __( 'Today', WPBANNERIZE_TEXTDOMAIN ),

      esc_attr( json_encode(
                  [
                    'start' => ( mktime( 0, 0, 0, date( 'n' ), date( 'd' ) - 1 ) ),
                    'end'   => ( mktime( 0, 0, 0, date( 'n' ), date( 'd' ) - 1 ) ),
                  ] ) ) => __( 'Yesterday', WPBANNERIZE_TEXTDOMAIN ),

      esc_attr( json_encode(
                  [
                    'start' => ( mktime( 0, 0, 0, date( 'n' ), date( 'd' ) - 7 ) ),
                    'end'   => time(),
                  ] ) ) => __( 'Last week', WPBANNERIZE_TEXTDOMAIN ),

      esc_attr( json_encode(
                  [
                    'start' => ( mktime( 0, 0, 0, date( 'n' ) - 1 ) ),
                    'end'   => time(),
                  ] ) ) => __( 'Last month', WPBANNERIZE_TEXTDOMAIN ),

      esc_attr( json_encode(
                  [
                    'start' => ( mktime( 0, 0, 0, date( 'n' ), date( 'd' ), date( 'Y' ) - 1 ) ),
                    'end'   => time(),
                  ] ) ) => __( 'Last year', WPBANNERIZE_TEXTDOMAIN ),
    ];
  }

  protected function cagetories()
  {
    // List of categories
    $categories = array(
      '' => __( 'All', WPBANNERIZE_TEXTDOMAIN )
    );

    $args  = array(
      'hide_empty' => true
    );
    $terms = get_terms( 'wp_bannerize_tax', $args );

    foreach ( $terms as $term ) {
      $categories[ $term->term_taxonomy_id ] = sprintf( '%s (%s)', $term->name, $term->count );
    }

    return $categories;
  }

  protected function banners()
  {
    return WPBannerizeImpressions::groupBy( 'GROUP BY impressions.banner_id' )
                                 ->dateFrom( $this->dateFrom )
                                 ->dateTo( $this->dateTo )
                                 ->categories( $this->categories )
                                 ->get();
  }

  public function store()
  {
    // POST
  }

  public function update()
  {
    // PUT AND PATCH
  }

  public function destroy()
  {
    // DELETE
  }

}