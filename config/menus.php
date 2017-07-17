<?php

/*
|--------------------------------------------------------------------------
| Plugin Menus routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the menu routes for a plugin.
| In this context the route are the menu link.
|
*/

return [
  'edit.php?post_type=wp_bannerize' => [
    "menu_title" => "WP Bannerize Settings",
    'capability' => 'manage_options',
    'items'      => [

      'overview' => [
        "menu_title" => __( "Analytics Overview", WPBANNERIZE_TEXTDOMAIN ),
        'route'      => [
          'load' => 'WPBannerizeAnalyticsController@load',
          'get'  => 'WPBannerizeAnalyticsController@index'
        ],
      ],

      'analitycs_report'   => [
        "menu_title" => __( "Analytics Report", WPBANNERIZE_TEXTDOMAIN ),
        'route'      => [
          'get' => 'WPBannerizeAnalyticsController@report'
        ],
      ],

      'settings'           => [
        "menu_title" => __( "Settings" ),
        'route'      => [
          'get'  => 'WPBannerizeSettingsController@index',
          'post' => 'WPBannerizeSettingsController@update',
        ],
      ],
      'import' => get_option( 'wp_bannerize_old_table', false ) ?
        [
          "menu_title" => __( "Import" ),
          'route'      => [
            'resource' => 'WPBannerizeImporterController',
          ],
        ]
        : null,
    ]
  ]
];
