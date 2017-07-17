<?php

namespace WPBannerize\Widgets;

use WPBannerize\WPBones\Support\Widget;

class WPBannerizeWidget extends Widget
{

  /**
   * Base ID for the widget, lower case, if left empty a portion of the widget's class name will be used. Has to be
   * unique.
   *
   * @var string
   */
  public $id_base = 'wp-bannerize-widget';

  /**
   * Name for the widget displayed on the configuration page.
   *
   * @var string
   */
  public $name = 'Bannerize';

  /**
   * Optional. Passed to wp_register_sidebar_widget()
   *
   * - description: shown on the configuration page
   * - classname
   *
   * @var array
   */
  public $widget_options = [
    'description' => 'Use this Bannerize widget to display your banner anywhere. Drag & Drop this widget on your sidebars and setup your preferred settings.'
  ];

  /**
   * Optional. Passed to wp_register_widget_control()
   *
   * - width: required if more than 250px
   * - height: currently not used but may be needed in the future
   *
   * @var array
   */
  public $control_options = [
    'width'  => 480,
    'height' => 350,
  ];

  public function update( $new_instance, $old_instance )
  {
    $old_instance[ 'title' ]           = strip_tags( stripslashes( $new_instance[ 'title' ] ) );
    $old_instance[ 'category' ]        = isset( $new_instance[ 'category' ] ) ? $new_instance[ 'category' ] : array();
    $old_instance[ 'categories' ]      = isset( $new_instance[ 'categories' ] ) ? $new_instance[ 'categories' ] : $old_instance[ 'category' ];
    $old_instance[ 'numbers' ]         = $new_instance[ 'numbers' ];
    $old_instance[ 'orderby' ]         = $new_instance[ 'orderby' ];
    $old_instance[ 'layout' ]          = $new_instance[ 'layout' ];
    $old_instance[ 'order' ]           = $new_instance[ 'order' ];
    $old_instance[ 'rank_seed' ]       = isset( $new_instance[ 'rank_seed' ] );
    $old_instance[ 'post_categories' ] = isset( $new_instance[ 'post_categories' ] ) ? $new_instance[ 'post_categories' ] : array();
    $old_instance[ 'geo_countries' ]   = isset( $new_instance[ 'geo_countries' ] ) ? $new_instance[ 'geo_countries' ] : array();
    $old_instance[ 'user_roles' ]      = isset( $new_instance[ 'user_roles' ] ) ? $new_instance[ 'user_roles' ] : array();


    return $old_instance;
  }

  /**
   * Retrun a key pairs array with the default value for widget.
   *
   * @return array
   */
  public function defaults()
  {
    return [
      'category'        => [],  // @deprecated since 1.5.0 - use 'categories' instead
      'title'           => '',
      'random'          => false,
      'categories'      => [],
      'numbers'         => 10,
      'orderby'         => 'menu_order',
      'order'           => 'DESC',
      'rank_seed'       => false,
      'post_categories' => [],
      'geo_countries'   => [],
      'user_roles'      => [],
      'layout'          => 'vertical'
    ];
  }

  public function viewForm( $instance )
  {
    $instance = array_merge( $this->defaults(), $instance );

    return WPBannerize()->view( 'widgets.form' )
                        ->withStyles( 'wp-bannerize-widget' )
                        ->with( [ 'instance' => $instance, 'widget' => $this ] );
  }


  public function viewWidget( $args, $instance )
  {
    // users
    if ( is_user_logged_in() ) {
      if ( ! empty( $instance[ 'user_roles' ] ) ) {

        // Get current logged in user
        $user = wp_get_current_user();

        // Get user roles
        $user_roles = $user->roles;

        // Get the first user role
        $current_user_role = array_shift( $user_roles );

        if ( ! in_array( $current_user_role, $instance[ 'user_roles' ] ) ) {
          return "";
        }
      }
    }

//    if( !empty( $instance[ 'geo_countries' ] ) ) {
//
//      $geo = WPDKGeo::init()->geoIP();
//
//      if( !empty( $geo ) && isset( $geo[ 'country_code' ] ) && !empty( $geo[ 'country_code' ] ) ) {
//        if( !in_array( $geo[ 'country_code' ], $instance[ 'geo_countries' ] ) ) {
//          return;
//        }
//      }
//    }


    return WPBannerize()->view( 'widgets.index' )
                        ->with( [ 'args' => $args, 'instance' => $instance ] )
                        ->withStyles( 'wp-bannerize-widget' );
  }


}