<?php

namespace WPBannerize\MetaBoxes;

use WPBannerize\Models\WPBannerizeImpressions;

class ImpressionsBanners extends MetaBox
{

  public function boot()
  {
    $this->id    = 'impressions-banners';
    $this->title = __( 'Most Viewed Banners (last month)', WPBANNERIZE_TEXTDOMAIN );

  }

  public function chart()
  {
    $filters = [
      'target'  => 'chart-morris-impressions-for-banners',
      'banners' => [],
    ];

    $result = WPBannerizeImpressions::getChart( $filters );

    $this->args = $result[ 'args' ];

    return $result[ 'chart' ];

  }
}