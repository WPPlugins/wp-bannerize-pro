<?php

/*
|--------------------------------------------------------------------------
| Plugin options
|--------------------------------------------------------------------------
|
| Here is where you can insert the options model of your plugin.
| These options model will store in WordPress options table
| (usually wp_options).
| You'll get these options by using `$plugin->options` property
|
*/

return [

  'General' => [
    'impressions_enabled' => true,
    'clicks_enabled'      => true,
  ],
  'Layout'  => [
    'top'    => 0,
    'right'  => 0,
    'bottom' => 0,
    'left'   => 0,
  ],
];