<?php

namespace WPBannerize\MetaBoxes;

use WPBannerize\WPBones\Support\Str;

abstract class MetaBox
{
  protected $id = '';

  protected $title = '';

  protected $context = 'normal';

  protected $priority = 'default';

  protected $args = [];

  protected $cptId = 'wp_bannerize';

  abstract public function boot();

  abstract public function chart();

  public function __construct()
  {
    $this->boot();

    add_meta_box( $this->id,
                  $this->title,
                  [ $this, 'view' ],
                  get_current_screen(),
                  $this->context,
                  $this->priority
    );
  }

  public function __get( $name )
  {
    $method = "get" . Str::studly( $name ) . 'Attribute';

    if ( method_exists( $this, $method ) ) {
      return $this->{$method}();
    }
  }

  public function view()
  {
    // check if chart() method fill some additional key in $this->args
    $chart = $this->chart();

    echo WPBannerize()
      ->view( "analytics.{$this->id}" )
      ->with( array_merge( $this->args, [ 'chart' => $chart ] ) );
  }

}