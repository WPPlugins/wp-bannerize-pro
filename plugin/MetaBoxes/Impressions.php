<?php

namespace WPBannerize\MetaBoxes;

use WPBannerize\Models\WPBannerizeImpressions;

class Impressions extends MetaBox
{

  public function boot()
  {
    $this->id    = 'impressions';
    $this->title = __( 'Impressions (last month)', WPBANNERIZE_TEXTDOMAIN );

  }

  public function chart()
  {
    $filters = [
      'target' => 'chart-morris-impressions',
    ];

    $result = WPBannerizeImpressions::getChart( $filters );

    $this->args = $result[ 'args' ];

    return $result[ 'chart' ];

  }
}