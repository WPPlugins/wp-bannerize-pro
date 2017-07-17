<?php

namespace WPBannerize\MetaBoxes;

use WPBannerize\Models\WPBannerizeClicks;

class Clicks extends MetaBox
{

  public function boot()
  {
    $this->id    = 'clicks';
    $this->title = __( 'Clicks (last month)', WPBANNERIZE_TEXTDOMAIN );

  }

  public function chart()
  {

    $filters = [
      'target' => 'chart-morris-clicks',
    ];

    $result = WPBannerizeClicks::getChart( $filters );

    $this->args = $result[ 'args' ];

    return $result[ 'chart' ];

  }
}