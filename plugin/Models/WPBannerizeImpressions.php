<?php

namespace WPBannerize\Models;

use WPBannerize\MorrisPHP\Morris;

class WPBannerizeImpressions extends WPBannerizeModel
{

  protected $orderBy = 'date';

  public static function create( $values, $formats = [] )
  {
    $instance = parent::create( $values, $formats );

    $post_id = absint( $values[ 'banner_id' ] );

    // get current impressions
    $value = (int) get_post_meta( $post_id, 'wp_bannerize_banner_impressions', true );

    if ( ! $value ) {
      $value = 0;
    }

    // increment
    $value++;

    update_post_meta( $post_id, 'wp_bannerize_banner_impressions', $value );

  }

  public function get()
  {
    /**
     * @var wpdb $wpdb
     */
    global $wpdb;

    // Where date
    if ( empty( $this->dateFrom ) ) {
      $this->dateFrom = date( 'Y-m-d H:i:s', mktime( 0, 0, 0, date( 'n' ) - 1 ) );
    }
    $this->where[] = sprintf( 'DATE_FORMAT( impressions.date, "%s" ) >= DATE_FORMAT( "%s", "%s" )', $this->accuracy, $this->dateFrom, $this->accuracy );

    if ( empty( $this->dateTo ) ) {
      $this->dateTo = date( 'Y-m-d H:i:s' );
    }
    $this->where[] = sprintf( 'DATE_FORMAT( impressions.date, "%s" ) <= DATE_FORMAT( "%s", "%s" )', $this->accuracy, $this->dateTo, $this->accuracy );

    // Where date interval
    if ( ! empty( $this->dateIntervalFrom ) ) {
      $this->where[] = sprintf( 'DATE_FORMAT( impressions.date, "%s" ) >= DATE_SUB( NOW(), INTERVAL %s )', $this->accuracy, strtoupper( $this->dateIntervalFrom ) );
    }
    if ( ! empty( $this->dateIntervalTo ) ) {
      $this->where[] = sprintf( 'DATE_FORMAT( impressions.date, "%s" ) <= DATE_SUB( NOW(), INTERVAL %s )', $this->accuracy, strtoupper( $this->dateIntervalTo ) );
    }

    // categories
    if ( ! empty( $this->categories ) ) {
      $sub_select    = sprintf( 'SELECT tr.object_id FROM %s AS tr WHERE tr.term_taxonomy_id IN(%s)', $wpdb->term_relationships, implode( ',', (array) $this->categories ) );
      $this->where[] = sprintf( 'impressions.banner_id IN( %s )', $sub_select );
    }

    // banners (id)
    if ( ! empty( $this->banners ) ) {
      $this->where[] = sprintf( 'impressions.banner_id IN (%s)', implode( ',', (array) $this->banners ) );
    }

    $whereCond = implode( ' AND ', array_filter( $this->where ) );

    $sql = <<<SQL
SELECT {$this->count}
       impressions.*,
       impressions.id AS impression_id,
       DATE_FORMAT( impressions.date, '{$this->accuracy}' ) AS date_impressions,
       IF( posts.post_title = '', 'Untitled', posts.post_title ) AS title
FROM ( {$this->table} AS impressions )
LEFT JOIN {$wpdb->posts} AS posts ON ( posts.ID = impressions.banner_id )
{$whereCond}
{$this->groupBy}
ORDER BY {$this->orderBy} {$this->order}
{$this->limit}
SQL;

    //trigger_error( $sql );

    return $wpdb->get_results( $sql, ARRAY_A );
  }

  public static function getChart( $filters = [] )
  {

    $filters = array_merge(
      [
        'ajax'       => false,
        'target'     => false,
        'accuracy'   => 'days',
        'categories' => [],
        'date_from'  => '',
        'date_to'    => '',
      ],
      $filters
    );

    $chart = Morris::line( $filters[ 'target' ] )
                   ->lineColors( array( '#ed5a61', '#92b46f' ) );

    if ( ! isset( $filters[ 'banners' ] ) ) {
      $chart->xkey( array( 'date_impressions' ) );

      $items = self::count( 'COUNT( DISTINCT impressions.banner_id, impressions.ip ) AS impressions_unique_count, COUNT( impressions.banner_id ) AS impressions_count' )
                   ->accuracy( $filters[ 'accuracy' ] )
                   ->groupBy( 'GROUP BY date_impressions' )
                   ->categories( $filters[ 'categories' ] )
                   ->dateFrom( $filters[ 'date_from' ] )
                   ->dateTo( $filters[ 'date_to' ] )
                   ->get();
    }
    else {
      $chart = Morris::bar( $filters[ 'target' ] )
                     ->xkey( array( 'title' ) );

      $items = self::groupBy( 'GROUP BY impressions.banner_id' )
                   ->count( 'COUNT( DISTINCT impressions.banner_id, impressions.ip, impressions.user_agent, DATE_FORMAT( impressions.date, "%Y-%m-%d %H:%i:%s" ) ) AS impressions_unique_count, COUNT( impressions.banner_id ) AS impressions_count' )
                   ->accuracy( $filters[ 'accuracy' ] )
                   ->orderBy( 'impressions_count DESC,impressions_unique_count' )
                   ->categories( $filters[ 'categories' ] )
                   ->banners( $filters[ 'banners' ] )
                   ->dateFrom( $filters[ 'date_from' ] )
                   ->dateTo( $filters[ 'date_to' ] )
                   ->order( 'DESC' )
                   ->limit( 'LIMIT 0,10' )
                   ->get();
    }

    // common
    $chart->ykeys( array( 'impressions_count', 'impressions_unique_count' ) )
          ->labels( array( __( 'Impressions' ), __( 'Unique' ) ) )
          ->resize( true )
          ->goalLineColors( array( '#ed5a61', '#92b46f' ) )
          ->barColors( array( '#ed5a61', '#92b46f' ) );

    // Calculate average
    $total        = 0;
    $total_unique = 0;
    $data         = [];

    foreach ( $items as $value ) {

      if ( ! isset( $filters[ 'banners' ] ) ) {
        $data[] = [
          'date_impressions'         => $value[ 'date_impressions' ],
          'impressions_count'        => $value[ 'impressions_count' ],
          'impressions_unique_count' => $value[ 'impressions_unique_count' ],
        ];
      }
      else {
        $data[] = [
          'title'                    => $value[ 'title' ],
          'impressions_count'        => $value[ 'impressions_count' ],
          'impressions_unique_count' => $value[ 'impressions_unique_count' ],
        ];
      }

      $total += $value[ 'impressions_count' ];
      $total_unique += $value[ 'impressions_unique_count' ];
    }

    // Average
    $avg        = count( $items ) ? number_format( $total / count( $items ), 2, '.', '' ) : 0;
    $avg_unique = count( $items ) ? number_format( $total_unique / count( $items ), 2, '.', '' ) : 0;

    // Use morris goal to display the average
    $chart->data( $data )
          ->goals( array( $avg, $avg_unique ) );

    // Additional information
    $args[ 'info' ] = array(
      'total'          => number_format( $total, 2 ),
      'average'        => number_format( $avg, 2 ),
      'total_unique'   => number_format( $total_unique, 2 ),
      'average_unique' => number_format( $avg_unique, 2 ),
    );

    return [
      'args'  => $args,
      'chart' => $filters[ 'ajax' ] ? $chart->toArray() : $chart
    ];
  }
}