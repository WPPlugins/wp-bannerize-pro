<?php

namespace WPBannerize\Models;

use WPBannerize\MorrisPHP\Morris;

class WPBannerizeClicks extends WPBannerizeModel
{

  protected $orderBy = 'date';

  public static function create( $values, $formats = [] )
  {
    parent::create( $values, $formats );

    $post_id = absint( $values[ 'banner_id' ] );

    // get current click
    $value = (int) get_post_meta( $post_id, 'wp_bannerize_banner_clicks', true );

    if ( ! $value ) {
      $value = 0;
    }

    // increment
    $value++;

    update_post_meta( $post_id, 'wp_bannerize_banner_clicks', $value );

  }

  public function get()
  {
    /**
     * @var wpdb $wpdb
     */
    global $wpdb;

    // Where date
    if ( empty( $this->dateFrom ) ) {
      $this->dateFrom = date( 'Y-m-d H:i:s', mktime( 0, 0, 0, date( 'm' ) - 1 ) );
    }
    $this->where[] = sprintf( 'DATE_FORMAT( clicks.date, "%s" ) >= DATE_FORMAT( "%s", "%s" )', $this->accuracy, $this->dateFrom, $this->accuracy );

    if ( empty( $this->dateTo ) ) {
      $this->dateTo = date( 'Y-m-d H:i:s' );
    }
    $this->where[] = sprintf( 'DATE_FORMAT( clicks.date, "%s" ) <= DATE_FORMAT( "%s", "%s" )', $this->accuracy, $this->dateTo, $this->accuracy );

    // Where date interval
    if ( ! empty( $this->dateIntervalFrom ) ) {
      $this->where[] = sprintf( 'DATE_FORMAT( clicks.date, "%s" ) >= DATE_SUB( NOW(), INTERVAL %s )', $this->accuracy, strtoupper( $this->dateIntervalFrom ) );
    }
    if ( ! empty( $this->dateIntervalTo ) ) {
      $this->where[] = sprintf( 'DATE_FORMAT( clicks.date, "%s" ) <= DATE_SUB( NOW(), INTERVAL %s )', $this->accuracy, strtoupper( $this->dateIntervalTo ) );
    }

    // categories
    if ( ! empty( $this->categories ) ) {
      $sub_select    = sprintf( 'SELECT tr.object_id FROM %s AS tr WHERE tr.term_taxonomy_id IN(%s)', $wpdb->term_relationships, implode( ',', (array) $this->categories ) );
      $this->where[] = sprintf( 'clicks.banner_id IN( %s )', $sub_select );
    }

    // banners (id)
    if ( ! empty( $this->banners ) ) {
      $this->where[] = sprintf( 'clicks.banner_id IN (%s)', implode( ',', (array) $this->banners ) );
    }

    $whereCond = implode( ' AND ', array_filter( $this->where ) );

    $sql = <<<SQL
SELECT {$this->count}
       clicks.*,
       clicks.id AS clicks_id,
       DATE_FORMAT( clicks.date, '{$this->accuracy}' ) AS date_clicks,
       IF( posts.post_title = '', 'Untitled', posts.post_title ) AS title
FROM ( {$this->table} AS clicks )
LEFT JOIN {$wpdb->posts} AS posts ON ( posts.ID = clicks.banner_id )
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
      $chart->xkey( array( 'date_clicks' ) );

      $items = self::count( 'COUNT( DISTINCT clicks.banner_id, clicks.ip ) AS clicks_unique_count, COUNT( clicks.banner_id ) AS clicks_count' )
                   ->groupBy( 'GROUP BY date_clicks' )
                   ->accuracy( $filters[ 'accuracy' ] )
                   ->categories( $filters[ 'categories' ] )
                   ->dateFrom( $filters[ 'date_from' ] )
                   ->dateTo( $filters[ 'date_to' ] )
                   ->get();
    }
    else {
      $chart = Morris::bar( $filters[ 'target' ] )
                     ->xkey( array( 'title' ) );

      $items = self::count( 'COUNT( DISTINCT clicks.banner_id, clicks.ip, clicks.user_agent, DATE_FORMAT( clicks.date, "' . $filters[ 'accuracy' ] . '" ) ) AS clicks_unique_count, COUNT( clicks.banner_id ) AS clicks_count' )
                   ->groupBy( 'GROUP BY clicks.banner_id' )
                   ->orderBy( 'clicks_count DESC,clicks_unique_count' )
                   ->accuracy( $filters[ 'accuracy' ] )
                   ->categories( $filters[ 'categories' ] )
                   ->banners( $filters[ 'banners' ] )
                   ->dateFrom( $filters[ 'date_from' ] )
                   ->dateTo( $filters[ 'date_to' ] )
                   ->order( 'DESC' )
                   ->limit( 'LIMIT 0,10' )
                   ->get();
    }

    $chart->ykeys( array( 'clicks_count', 'clicks_unique_count' ) )
          ->labels( array( __( 'Clicks' ), __( 'Unique' ) ) )
          ->resize( true )
          ->goalLineColors( array( '#ed5a61', '#92b46f' ) )
          ->barColors( array( '#ed5a61', '#92b46f' ) );

    // Calculate average
    $total        = 0;
    $total_unique = 0;
    $data         = [];
    foreach ( $items as $value ) {

      if ( ! isset( $filters[ 'banners' ] ) ) {
        $data[] = array(
          'date_clicks'         => $value[ 'date_clicks' ],
          'clicks_count'        => $value[ 'clicks_count' ],
          'clicks_unique_count' => $value[ 'clicks_unique_count' ],
        );
      }
      else {
        $data[] = array(
          'title'               => $value[ 'title' ],
          'clicks_count'        => $value[ 'clicks_count' ],
          'clicks_unique_count' => $value[ 'clicks_unique_count' ],
        );
      }

      $total += $value[ 'clicks_count' ];
      $total_unique += $value[ 'clicks_unique_count' ];
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