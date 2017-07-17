<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( ! empty( $instance[ 'geo_countries' ] ) ) {
  $hasCountries = \WPBannerize\GeoLocalizer\GeoLocalizerProvider::hasCountries( $instance[ 'geo_countries' ] );

  if ( ! $hasCountries ) {
    return;
  }
}


$before_widget = $args[ 'before_widget' ];
$after_widget  = $args[ 'after_widget' ];
$before_title  = $args[ 'before_title' ];
$after_title   = $args[ 'after_title' ];

echo $before_widget;

// @since 1.3.8 - Added title support
if ( ! empty( $instance[ 'title' ] ) ) {
  printf( '%s%s%s', $before_title, $instance[ 'title' ], $after_title );
}

echo WPBannerize\Models\WPBannersQuery::query( $instance );

echo $after_widget;