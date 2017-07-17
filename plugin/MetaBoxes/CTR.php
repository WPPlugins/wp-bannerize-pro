<?php

namespace WPBannerize\MetaBoxes;

use WPBannerize\Models\WPBannerizeCTR;

class CTR extends MetaBox
{

  public function boot()
  {
    $this->id    = 'ctr';
    $this->title = __( 'CTR (last month)', WPBANNERIZE_TEXTDOMAIN );

  }

  public function chart()
  {

    $filters = [
      'target'  => 'chart-morris-ctr',
      'banners' => [],
    ];

    $result = WPBannerizeCTR::getChart( $filters );

    $this->args = $result[ 'args' ];

    return $result[ 'chart' ];

  }
}