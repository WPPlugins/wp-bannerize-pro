<?php

return [
  
  /*
  |--------------------------------------------------------------------------
  | Use minified styles and scripts
  |--------------------------------------------------------------------------
  |
  | If you would like gulp to compile and compress your styles and scripts
  | the filenames in `public/css` will have `.min` as postfix. If this
  | setting is TRUE then will be used the minified version.
  |
  */

  'minified' => false,

  /*
  |--------------------------------------------------------------------------
  | Screen options
  |--------------------------------------------------------------------------
  |
  | Here is where you can register the screen options for List Table.
  |
  */

  'screen_options' => [ ],

  /*
  |--------------------------------------------------------------------------
  | Custom Post Types
  |--------------------------------------------------------------------------
  |
  | Here is where you can register the Custom Post Types.
  |
  */

  'custom_post_types' => [ '\WPBannerize\CustomPostTypes\WPBannerizeCustomPostType' ],

  /*
  |--------------------------------------------------------------------------
  | Custom Taxonomies
  |--------------------------------------------------------------------------
  |
  | Here is where you can register the Custom Taxonomy Types.
  |
  */

  'custom_taxonomy_types' => [ '\WPBannerize\CustomTaxonomyTypes\WPBannerizeCustomTaxonomyType' ],


  /*
  |--------------------------------------------------------------------------
  | Shortcodes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register the Shortcodes.
  |
  */

  'shortcodes' => [ '\WPBannerize\Shortcodes\WPBannerizeShortcode' ],

  /*
  |--------------------------------------------------------------------------
  | Widgets
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the Widget for a plugin.
  |
  */

  'widgets' => [ '\WPBannerize\Widgets\WPBannerizeWidget' ],


  /*
  |--------------------------------------------------------------------------
  | Ajax
  |--------------------------------------------------------------------------
  |
  | Here is where you can register your own Ajax actions.
  |
  */

  'ajax' => [ '\WPBannerize\Ajax\WPBannerizeAjax' ],

  /*
  |--------------------------------------------------------------------------
  | Autoloaded Service Providers
  |--------------------------------------------------------------------------
  |
  | The service providers listed here will be automatically loaded on the
  | init to your plugin. Feel free to add your own services to
  | this array to grant expanded functionality to your applications.
  |
  */

  'providers' => [
    'WPBannerize\Providers\WPBannerizeServiceProvider',
    'WPBannerize\Providers\WPBannerizeFrontendServiceProvider'
  ]

];