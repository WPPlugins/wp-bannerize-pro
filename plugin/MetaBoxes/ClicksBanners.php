<?php

namespace WPBannerize\MetaBoxes;

use WPBannerize\Models\WPBannerizeClicks;

class ClicksBanners extends MetaBox
{

  public function boot()
  {
    $this->id    = 'clicks-banners';
    $this->title = __( 'Most Clicked Banners (last month)', WPBANNERIZE_TEXTDOMAIN );

  }

  public function chart()
  {
    $filters = [
      'target'  => 'chart-morris-clicks-for-banners',
      'banners' => [],
    ];

    $result = WPBannerizeClicks::getChart( $filters );

    $this->args = $result[ 'args' ];

    return $result[ 'chart' ];

  }
}