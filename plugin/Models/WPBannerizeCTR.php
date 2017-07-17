<?php

namespace WPBannerize\Models;

use WPBannerize\MorrisPHP\Morris;

class WPBannerizeCTR extends WPBannerizeModel
{
  public function get()
  {
    /**
     * @var wpdb $wpdb
     */
    global $wpdb;

    $impressionsTable = WPBannerizeImpressions::getTableName();
    $clicksTable      = WPBannerizeClicks::getTableName();

    // Where date
    if ( empty( $this->dateFrom ) ) {
      $this->dateFrom = date( 'Y-m-d H:i:s', mktime( 0, 0, 0, date( 'n' ) - 1 ) );
    }
    $this->where[] = sprintf( 'DATE_FORMAT( impressions.date, "%s" ) >= DATE_FORMAT( "%s", "%s" )', $this->accuracy, $this->dateFrom, $this->accuracy );

    if ( empty( $this->dateTo ) ) {
      $this->dateTo = date( 'Y-m-d H:i:s' );
    }
    $this->where[] = sprintf( 'DATE_FORMAT( impressions.date, "%s" ) <= DATE_FORMAT( "%s", "%s" )', $this->accuracy, $this->dateTo, $this->accuracy );

    // categories
    if ( ! empty( $this->categories ) ) {
      $sub_select    = sprintf( 'SELECT tr.object_id FROM %s AS tr WHERE tr.term_taxonomy_id IN(%s)', $wpdb->term_relationships, implode( ',', (array) $this->categories ) );
      $this->where[] = sprintf( 'clicks.banner_id IN( %s )', $sub_select );
    }

    // Where for banners id
    $sub_select_where = '';
    if ( ! empty( $this->banners ) ) {
      $banners_id = implode( ',', (array) $this->banners );

      $this->where[]    = sprintf( 'impressions.banner_id IN (%s)', $banners_id );
      $sub_select_where = sprintf( 'AND clicks.banner_id IN (%s) AND impressions.banner_id IN (%s)', $banners_id, $banners_id );
    }

    $whereCond = implode( ' AND ', array_filter( $this->where ) );

    $sql = <<<SQL
SELECT 
  COUNT( DISTINCT impressions.banner_id, impressions.ip ) AS impressions_unique_count, 
  COUNT( impressions.banner_id ) AS impressions_count,

  DATE_FORMAT( impressions.date, '{$this->accuracy}' ) AS date_ctr,

	IF( posts.post_title = '', 'Untitled', posts.post_title ) AS title,

    ( SELECT FORMAT( ( COUNT( clicks.banner_id ) / COUNT( impressions.banner_id ) * 100 ), 2 )
		FROM ( {$clicksTable} AS clicks )
		WHERE DATE_FORMAT( clicks.date, '%Y-%m-%d' ) = DATE_FORMAT( impressions.date, '%Y-%m-%d' ) {$sub_select_where} ) AS CTR,

    ( SELECT FORMAT( ( COUNT( DISTINCT clicks.banner_id, clicks.ip )  / COUNT( DISTINCT impressions.banner_id, impressions.ip )  * 100 ), 2 )
		FROM ( {$clicksTable} AS clicks )
		WHERE DATE_FORMAT( clicks.date, '%Y-%m-%d' ) = DATE_FORMAT( impressions.date, '%Y-%m-%d' ) {$sub_select_where} ) AS CTR_unique

FROM ( {$impressionsTable} AS impressions )
LEFT JOIN {$wpdb->posts} AS posts ON ( posts.ID = impressions.banner_id )
{$whereCond}
GROUP BY date_ctr
ORDER BY impressions.date
SQL;

    trigger_error( $whereCond );

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
        'banners'    => null,
        'date_to'    => '',
      ],
      $filters
    );

    $items = self::categories( $filters[ 'categories' ] )
                 ->accuracy( $filters[ 'accuracy' ] )
                 ->dateFrom( $filters[ 'date_from' ] )
                 ->dateTo( $filters[ 'date_to' ] )
                 ->banners( $filters[ 'banners' ] )
                 ->get();

    $chart = Morris::line( $filters[ 'target' ] )
                   ->xkey( array( 'date_ctr' ) )
                   ->ykeys( array( 'CTR', 'CTR_unique' ) )
                   ->labels( array( __( 'CTR' ), __( 'Unique' ) ) )
                   ->resize( true )
                   ->postUnits( '%' )
                   ->lineColors( array( '#ed5a61', '#92b46f' ) )
                   ->goalLineColors( array( '#ed5a61', '#92b46f' ) )
                   ->goalStrokeWidth( 2 );

    // Calculate average
    $total        = 0;
    $total_unique = 0;
    $data         = [];

    foreach ( $items as $value ) {
      $data[] = array(
        'date_ctr'   => $value[ 'date_ctr' ],
        'CTR'        => $value[ 'CTR' ],
        'CTR_unique' => $value[ 'CTR_unique' ]
      );
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
      'average'        => number_format( $avg, 2 ),
      'average_unique' => number_format( $avg_unique, 2 ),
    );

    return [
      'args'  => $args,
      'chart' => $filters[ 'ajax' ] ? $chart->toArray() : $chart
    ];
  }
}