<?php

namespace WPBannerize\MetaBoxes;

use WPBannerize\Models\WPBannerizeImpressions;
use WPBannerize\Models\WPBannerizeClicks;

class Summary extends MetaBox
{
  protected $totalBanner = 0;

  protected $totalImpressions = [];

  protected $totalClicks = [];

  public function boot()
  {
    $this->id    = 'summary';
    $this->title = __( 'All Time Summary', WPBANNERIZE_TEXTDOMAIN );

    $this->args[ 'result' ] = [];
//    $this->args[ 'result' ] = array_merge( $this->args[ 'result' ], [ "prova" => 88 ] );
    $this->args[ 'result' ] = array_merge( $this->args[ 'result' ], $this->getTotalImpressions() );
    $this->args[ 'result' ] = array_merge( $this->args[ 'result' ], $this->getTotalClicks() );
    $this->args[ 'result' ] = array_merge( $this->args[ 'result' ], $this->getTotalCTR() );
    $this->args[ 'result' ] = array_merge( $this->args[ 'result' ], $this->getBannerCategories() );
    $this->args[ 'result' ] = array_merge( $this->args[ 'result' ], $this->getTotalCategories() );
    $this->args[ 'result' ] = array_merge( $this->args[ 'result' ], $this->getTotalBanners() );
    $this->args[ 'result' ] = array_merge( $this->args[ 'result' ], $this->getBannerTypes() );
    $this->args[ 'result' ] = array_merge( $this->args[ 'result' ], [ __( 'Total Banners', WPBANNERIZE_TEXTDOMAIN ) => $this->totalBanner ] );
  }

  protected function getTotalImpressions()
  {
    $result = WPBannerizeImpressions::count( 'COUNT( DISTINCT impressions.banner_id, impressions.ip ) AS impressions_unique_count, COUNT( impressions.banner_id ) AS impressions_count' )
                                    ->get();

    $this->totalImpressions = current( $result );

    $format = sprintf( '%s / %s %s',
                       $this->totalImpressions[ 'impressions_count' ],
                       $this->totalImpressions[ 'impressions_unique_count' ],
                       __( 'Unique', WPBANNERIZE_TEXTDOMAIN )
    );

    return [
      __( 'All time Impressions', WPBANNERIZE_TEXTDOMAIN ) => $format
    ];
  }

  protected function getTotalClicks()
  {
    $result = WPBannerizeClicks::count( 'COUNT( DISTINCT clicks.banner_id, clicks.ip ) AS clicks_unique_count, COUNT( clicks.banner_id ) AS clicks_count' )
                               ->get();

    $this->totalClicks = current( $result );

    $format = sprintf( '%s / %s %s',
                       $this->totalClicks[ 'clicks_count' ],
                       $this->totalClicks[ 'clicks_unique_count' ],
                       __( 'Unique', WPBANNERIZE_TEXTDOMAIN )
    );

    return [
      __( 'All time Clicks', WPBANNERIZE_TEXTDOMAIN ) => $format
    ];
  }

  protected function getTotalCTR()
  {
    $total_ctr        = number_format( $this->totalClicks[ 'clicks_count' ] / max( 1, $this->totalImpressions[ 'impressions_count' ] ) * 100, 2 );
    $total_unique_ctr = number_format( $this->totalClicks[ 'clicks_unique_count' ] / max( 1, $this->totalImpressions[ 'impressions_unique_count' ] ) * 100, 2 );

    $format = sprintf( '%s %% / %s %% %s', $total_ctr, $total_unique_ctr, __( 'Unique', WPBANNERIZE_TEXTDOMAIN ) );

    return [
      __( 'All time CTR', WPBANNERIZE_TEXTDOMAIN ) => $format
    ];

  }

  protected function getBannerCategories()
  {
    $args  = array( 'hide_empty' => true );
    $terms = get_terms( 'wp_bannerize_tax', $args );

    return array( __( 'Categories with Banners', WPBANNERIZE_TEXTDOMAIN ) => count( $terms ) );

  }

  protected function getTotalCategories()
  {
    $args  = array( 'hide_empty' => false );
    $terms = get_terms( 'wp_bannerize_tax', $args );

    return array( __( 'Total Categories', WPBANNERIZE_TEXTDOMAIN ) => count( $terms ) );

  }

  protected function getTotalBanners()
  {
    /**
     * @var wpdb $wpdb
     */
    global $wpdb;

    $result = [];

    $sql = <<<SQL
SELECT COUNT( * ) AS value, posts.post_status AS label FROM ( {$wpdb->posts} AS posts )
WHERE 1 AND posts.post_type = '{$this->cptId}'
GROUP BY posts.post_status
SQL;

    $items = $wpdb->get_results( $sql, ARRAY_A );
    foreach ( $items as $value ) {
      $key            = sprintf( '%s (%s)', __( 'Banners' ), $value[ 'label' ] );
      $result[ $key ] = $value[ 'value' ];
      $this->totalBanner += $value[ 'value' ];
    }

    return $result;
  }

  protected function getBannerTypes()
  {
    /**
     * @var wpdb $wpdb
     */
    global $wpdb;

    $result = [];

    $sql = <<<SQL
SELECT COUNT( postmeta.meta_value ) AS value, postmeta.meta_value AS label 
FROM ( {$wpdb->posts} AS posts )
LEFT JOIN {$wpdb->postmeta} AS postmeta ON ( postmeta.post_id = posts.ID )
WHERE 1 AND posts.post_type = '{$this->cptId}' AND postmeta.meta_key = 'wp_bannerize_banner_type'
GROUP BY postmeta.meta_value
SQL;

    $items = $wpdb->get_results( $sql, ARRAY_A );

    $labels = array(
      'local'  => __( 'Local', WPBANNERIZE_TEXTDOMAIN ),
      'remote' => __( 'Remote', WPBANNERIZE_TEXTDOMAIN ),
      'text'   => __( 'Text', WPBANNERIZE_TEXTDOMAIN ),
    );

    foreach ( $items as $value ) {
      $key            = sprintf( '%s %s', $labels[ $value[ 'label' ] ], __( 'Banners', WPBANNERIZE_TEXTDOMAIN ) );
      $result[ $key ] = $value[ 'value' ];
    }

    return $result;
  }

  public function chart()
  {

  }
}