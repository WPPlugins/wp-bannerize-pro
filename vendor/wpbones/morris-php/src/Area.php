<?php

namespace WPBannerize\MorrisPHP;

use WPBannerize\MorrisPHP\Chart;
use WPBannerize\MorrisPHP\ChartTypes;

class Area extends Chart
{

  /**
   * Change the opacity of the area fill colour.
   * Accepts values between 0.0 (for completely transparent) and 1.0 (for completely opaque).
   *
   * @brief Opacity
   *
   * @var string $fillOpacity
   */
  protected $fillOpacity = 'auto';

  /**
   * Set to true to overlay the areas on top of each other instead of stacking them.
   *
   * @brief Line
   *
   * @var bool $behaveLikeLine
   */
  protected $behaveLikeLine = false;

  /**
   * Create an instance of MorrisAreaChart class
   *
   * @param string $element_id The element id
   *
   */
  public function __construct( $element_id )
  {
    parent::__construct( $element_id, ChartTypes::AREA );
  }
}