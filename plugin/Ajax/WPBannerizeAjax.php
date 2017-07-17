<?php

namespace WPBannerize\Ajax;

use WPBannerize\Models\WPBannerizeImpressions;
use WPBannerize\Models\WPBannerizeClicks;
use WPBannerize\Models\WPBannerizeCTR;
use WPBannerize\WPBones\Foundation\WordPressAjaxServiceProvider as ServiceProvider;

class WPBannerizeAjax extends ServiceProvider
{

  /**
   * List of the ajax actions executed by both logged and not logged users.
   * Here you will used a methods list.
   *
   * @var array
   */
  protected $trusted = [
    'wp_bannerize_add_clicks',
    'wp_bannerize_add_impressions',
  ];

  /**
   * List of the ajax actions executed only by logged in users.
   * Here you will used a methods list.
   *
   * @var array
   */
  protected $logged = [
    'wp_bannerize_action_sorting_post_page',
    'wp_bannerize_banners_list',
    'wp_bannerize_report_impressions_chart',
    'wp_bannerize_report_clicks_chart',
    'wp_bannerize_report_ctr_chart',
    'wp_bannerize_layout',
  ];

  /**
   * List of the ajax actions executed only by not logged in user, usually from frontend.
   * Here you will used a methods list.
   *
   * @var array
   */
  protected $notLogged = [
  ];

  public function wp_bannerize_banners_list()
  {
    // get post data
    $dateFrom   = wp_bannerize_pro_sanitize_mysql_datetime( $_POST[ 'date_from' ] );
    $dateTo     = wp_bannerize_pro_sanitize_mysql_datetime( $_POST[ 'date_to' ] );
    $categories = isset( $_POST[ 'category' ] ) ? absint( $_POST[ 'category' ] ) : [];

    $banners = WPBannerizeImpressions::groupBy( 'GROUP BY impressions.banner_id' )
                                     ->dateFrom( $dateFrom )
                                     ->dateTo( $dateTo )
                                     ->categories( $categories )
                                     ->get();

    ob_start();
    echo WPBannerize()->view( 'analytics.report-banners' )->with( 'banners', $banners );
    $content = ob_get_contents();
    ob_end_clean();

    $result = [
      'html' => $content,
    ];

    wp_send_json_success( $result );
  }

  // Impressions
  public function wp_bannerize_report_impressions_chart()
  {
    $accuracyAllowed = [
      'seconds',
      'minutes',
      'days',
      'months',
      'years',
    ];

    // sanitize
    $target   = sanitize_key( $_POST[ 'target' ] );
    $accracy  = in_array( $_POST[ 'accuracy' ], $accuracyAllowed ) ? $_POST[ 'accuracy' ] : 'days';
    $category = isset( $_POST[ 'category' ] ) ? esc_attr( $_POST[ 'category' ] ) : [];

    // get post data
    $filters = [
      'ajax'       => true,
      'target'     => $target,
      'accuracy'   => $accracy,
      'date_from'  => wp_bannerize_pro_sanitize_mysql_datetime( $_POST[ 'date_from' ] ),
      'date_to'    => wp_bannerize_pro_sanitize_mysql_datetime( $_POST[ 'date_to' ] ),
      'categories' => $category,
    ];

    if ( isset( $_POST[ 'banners' ] ) && ! empty( $_POST[ 'banners' ] ) ) {
      $filters[ 'banners' ] = array_map( 'esc_attr', $_POST[ 'banners' ] );
    }

    $result = WPBannerizeImpressions::getChart( $filters );

    wp_send_json_success( $result );
  }

  // Clicks
  public function wp_bannerize_report_clicks_chart()
  {
    $accuracyAllowed = [
      'seconds',
      'minutes',
      'days',
      'months',
      'years',
    ];

    // sanitize
    $target   = sanitize_key( $_POST[ 'target' ] );
    $accracy  = in_array( $_POST[ 'accuracy' ], $accuracyAllowed ) ? $_POST[ 'accuracy' ] : 'days';
    $category = isset( $_POST[ 'category' ] ) ? esc_attr( $_POST[ 'category' ] ) : [];

    // get post data
    $filters = [
      'ajax'       => true,
      'target'     => $target,
      'accuracy'   => $accracy,
      'date_from'  => wp_bannerize_pro_sanitize_mysql_datetime( $_POST[ 'date_from' ] ),
      'date_to'    => wp_bannerize_pro_sanitize_mysql_datetime( $_POST[ 'date_to' ] ),
      'categories' => $category,
    ];

    if ( isset( $_POST[ 'banners' ] ) && ! empty( $_POST[ 'banners' ] ) ) {
      $filters[ 'banners' ] = array_map( 'esc_attr', $_POST[ 'banners' ] );
    }

    $result = WPBannerizeClicks::getChart( $filters );

    wp_send_json_success( $result );
  }

  // CRT
  public function wp_bannerize_report_ctr_chart()
  {
    $accuracyAllowed = [
      'seconds',
      'minutes',
      'days',
      'months',
      'years',
    ];

    // sanitize
    $target   = sanitize_key( $_POST[ 'target' ] );
    $accracy  = in_array( $_POST[ 'accuracy' ], $accuracyAllowed ) ? $_POST[ 'accuracy' ] : 'days';
    $category = isset( $_POST[ 'category' ] ) ? esc_attr( $_POST[ 'category' ] ) : [];

    // get post data
    $filters = [
      'ajax'       => true,
      'target'     => $target,
      'accuracy'   => $accracy,
      'date_from'  => wp_bannerize_pro_sanitize_mysql_datetime( $_POST[ 'date_from' ] ),
      'date_to'    => wp_bannerize_pro_sanitize_mysql_datetime( $_POST[ 'date_to' ] ),
      'categories' => $category,
    ];

    if ( isset( $_POST[ 'banners' ] ) && ! empty( $_POST[ 'banners' ] ) ) {
      $filters[ 'banners' ] = array_map( 'esc_attr', $_POST[ 'banners' ] );;
    }

    $result = WPBannerizeCTR::getChart( $filters );

    wp_send_json_success( $result );
  }


  /**
   * Updated `menu_order` field in post table.
   *
   * @internal param $_POST['sorted'] List sequence of sorted items
   * @internal param $_POST['paged'] Pagination value
   * @internal param $_POST['per_page'] Number of items per page
   *
   */
  public function wp_bannerize_action_sorting_post_page()
  {
    /**
     * @var wpdb $wpdb
     */
    global $wpdb;

    $sorted   = wp_parse_args( $_POST[ 'sorted' ] );
    $paged    = absint( esc_attr( $_POST[ 'paged' ] ) );
    $per_page = absint( esc_attr( $_POST[ 'per_page' ] ) );

    if ( is_array( $sorted[ 'post' ] ) ) {
      $offset = ( $paged - 1 ) * $per_page;
      foreach ( $sorted[ 'post' ] as $key => $value ) {
        $menu_order = $key + $offset;
        $sql        = sprintf( 'UPDATE %s SET menu_order = %s WHERE ID = %s', $wpdb->posts, $menu_order, absint( $value ) );
        $wpdb->query( $sql );
      }
    }

    wp_send_json_success();
  }

  public function wp_bannerize_add_impressions()
  {
    if ( ! isset( $_POST[ 'banner_id' ] ) || empty( $_POST[ 'banner_id' ] ) ) {
      wp_send_json_error(
        [
          'description' => __( 'No banner id set', WPBANNERIZE_TEXTDOMAIN ),
        ]
      );
    }

    if ( ! isset( $_POST[ 'referrer' ] ) || empty( $_POST[ 'referrer' ] ) ) {

      wp_send_json_error(
        [
          'description' => __( 'No referrer set', WPBANNERIZE_TEXTDOMAIN ),
        ]
      );
    }

    $ids = (array) $_POST[ 'banner_id' ];

    foreach ( $ids as $bannerId ) {
      WPBannerizeImpressions::create(
        [
          'banner_id'  => absint( $bannerId ),
          'referrer'   => isset( $_POST[ 'referrer' ] ) ? esc_url( $_POST[ 'referrer' ] ) : "",
          'ip'         => $_SERVER[ 'REMOTE_ADDR' ],
          'user_agent' => $_SERVER[ 'HTTP_USER_AGENT' ],
        ]
      );
    }

    wp_send_json_success();
  }

  public function wp_bannerize_add_clicks()
  {
    if ( ! isset( $_POST[ 'banner_id' ] ) || empty( $_POST[ 'banner_id' ] ) ) {
      wp_send_json_error(
        [
          'description' => __( 'No banner id set', WPBANNERIZE_TEXTDOMAIN ),
        ]
      );
    }

    if ( ! isset( $_POST[ 'referrer' ] ) || empty( $_POST[ 'referrer' ] ) ) {

      wp_send_json_error(
        [
          'description' => __( 'No referrer set', WPBANNERIZE_TEXTDOMAIN ),
        ]
      );
    }

    WPBannerizeClicks::create(
      [
        'banner_id'  => absint( $_POST[ 'banner_id' ] ),
        'referrer'   => isset( $_POST[ 'referrer' ] ) ? esc_url( $_POST[ 'referrer' ] ) : "",
        'ip'         => $_SERVER[ 'REMOTE_ADDR' ],
        'user_agent' => $_SERVER[ 'HTTP_USER_AGENT' ],
      ]
    );

    wp_send_json_success();
  }

  public function wp_bannerize_layout()
  {
    $border  = $_POST[ 'border' ];
    $value   = $_POST[ 'value' ];
    $allowed = [ 'top', 'right', 'bottom', 'left' ];

    if ( isset( $border ) && in_array( $border, $allowed ) ) {
      if ( ! isset( $value ) || empty( $value ) || ! is_numeric( $value ) ) {
        $value = null;
      }

      WPBannerize()->options->set( "Layout.{$border}", $value );

      wp_send_json_success( [ "Layout.{$border}" => $value, WPBannerize()->options->toArray() ] );
    }

    wp_send_json_error( [ 'description' => 'Wrong values types' ] );
  }

}
