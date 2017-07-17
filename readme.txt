=== WP Bannerize Pro ===
Contributors: gfazioli
Donate link: http://undolog.com
Tags: Banner, Manage, Image, ADV, Random, Impressions, Click Counter, CTR
Requires at least: 4.6
Tested up to: 4.8
Stable tag: 1.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Bannerize Pro is the new version of WP Bannerize. It is an easy to use adv image manager with html and free text support.

== Description ==

WP Bannerize Pro is an Amazing Banner Manager. With WP Bannerize you can manage all your advertising stuff through widgets, shortcodes or directly from your template.

**New in 1.1.0**

* Geo Localization

**FEATURES**

* Manage your banner as Custom Post Types for image, HTML/Javascript and free text
* Create your banner categories
* Sort your banner with easy Drag & Drop
* Display your banners by PHP code, WordPress **shortcode** or Widget
* Set the filters such as random order, numbers, user roles and categories filters
* Date Time schedule
* "nofollow" attribute support
* Clicks and Impressions Counter engine for stats
* CTR (Click-through rate)
* Analytics reports

**WHAT'S NEWS IN PRO RELEASE**

* New core engine
* New Analytics reports
* Removed Adobe Flash support

**HOW TO**

You can display the banners by shortcodes, PHP functions or Widgets.

= Shortcode =

From v1.1.0 you can use the new shortcode in order to display geo localized banners.
Let's see some exmaple:

`
[wp_bannerize_pro_geo city="rome"]
  [wp_bannerize_pro id="1678"]
[/wp_bannerize_pro_geo]
`

The above shortcodes, will display the banner with id 1678 only for visitors from Rome.

Let's see more sample.

`
[wp_bannerize_pro_geo city="Rome"]
  Only for Rome
[/wp_bannerize_pro_geo]

[wp_bannerize_pro_geo city="rome"]
  Only for Rome
[/wp_bannerize_pro_geo]

[wp_bannerize_pro_geo city="rome,london"]
  Only for Rome and Landon
[/wp_bannerize_pro_geo]

[wp_bannerize_pro_geo region_name="lazio"]
  Only for region (Italy) Lazio
[/wp_bannerize_pro_geo]

[wp_bannerize_pro_geo country_code="IT"]
  Italian only
[/wp_bannerize_pro_geo]

[wp_bannerize_pro_geo country_name="italy"]
  Italian only
[/wp_bannerize_pro_geo]

[wp_bannerize_pro_geo zip_code="00137"]
  Wow
[/wp_bannerize_pro_geo]

[wp_bannerize_pro_geo ip="80.182.82.82"]
  Only for me
[/wp_bannerize_pro_geo]

[wp_bannerize_pro_geo time_zone="europe/rome"]
  Rome/Berlin time zone
[/wp_bannerize_pro_geo]
`

Also, have a look to the new widget UI with geo-localization settings.

`
// single banners
[wp_bannerize_pro id="1678"]
[wp_bannerize_pro id="my-banner-slug"]
[wp_bannerize_pro id="1678,my-banner-slug"]

// random
[wp_bannerize_pro numbers="1" orderby="random"]

// random with category
[wp_bannerize_pro orderby="random" categories="56"]
[wp_bannerize_pro orderby="random" categories="sidebar-blog"]

// post categories
[wp_bannerize_pro post_categories="news,events"]
[wp_bannerize_pro post_categories="34,67"]
`

= PHP Function =

`
<?php
// Display a single banner
if( function_exists( 'wp_bannerize_pro' ) ) {
  wp_bannerize_pro( array( 'id' => '156' ) );
}

// Display a more single banner
if( function_exists( 'wp_bannerize_pro' ) ) {
  wp_bannerize_pro( array( 'id' => '156,157,158' ) );
}

// Display a more single banner
if( function_exists( 'wp_bannerize_pro' ) ) {
  wp_bannerize_pro( array( 'id' => array( 156, 157, 158 ) ) );
}

// Display a more single banner by mixed id and slug
if( function_exists( 'wp_bannerize_pro' ) ) {
  wp_bannerize_pro( array( 'id' => array( 156, 'my-banner-slug', 158 ) ) );
}


// Display all banners from banner category "sidebar" in random order
if( function_exists( 'wp_bannerize_pro' ) ) {
  wp_bannerize_pro( array( 'orderby' => 'random', 'categories' => 'sidebar' ) );
}

// Display one banner from banner category "sidebar" in random order
if( function_exists( 'wp_bannerize_pro' ) ) {
  wp_bannerize_pro( array( 'orderby' => 'random', 'numbers' => 1, 'categories' => 'sidebar' ) );
}

// Display banners from banner category "sidebar" and post categories news and events
if( function_exists( 'wp_bannerize_pro' ) ) {
  wp_bannerize_pro( array( 'category' => 'sidebar', 'post_categories' => 'news,events' ) );
}

// Or... as array of slug
if( function_exists( 'wp_bannerize_pro' ) ) {
  wp_bannerize_pro( array( 'categories' => 'sidebar', 'post_categories' => array( 'news', 'events' ) ) );
}

// Or... as array of Title
if( function_exists( 'wp_bannerize_pro' ) ) {
  wp_bannerize_pro( array( 'categories' => 'sidebar', 'post_categories' => array( 'News', 'Events' ) ) );
}

// Or... as array of ids
if( function_exists( 'wp_bannerize_pro' ) ) {
  wp_bannerize_pro( array( 'categories' => 'sidebar', 'post_categories' => array( 24, 67 ) ) );
}
`

The code above shows banners only for the posts categories 13 or 14, for the "right_sidebar" banner category.

or in your post:

`[wp_bannerize_pro categories="adv" orderby="random" numbers="3"]`

The default HTML output for above code is:

= Params =

`
 Name              | Default      | Description
 ------------------+--------------+------------------------------------------------
 id                | null         | ID or slug comma separate (default null)
 categories        | []           | Banner categories slug or id (default '')
 post_categories   | []           | Any string, int or array of string, id. (default '')
 order             | "DESC"       | Order "ASC" or "DESC"
 orderby           | "menu_order" | Order by or 'impressions', 'clicks', 'ctr' or 'random'. (default 'menu_order')
 rank_seed         | true         | Set to true to give some chances to the banners to be showed when use Impressions, Click or CTR order by. Set to false to absolute order
 numbers           | 10           | Max numbers of banners (default 10)
 layout            | vertical     | Banners layout, "horizontal" or "vertical"
`
== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the entire content of plugin archive to your `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress (deactivate and reactivate if you're upgrading).
3. Done. Enjoy.

== Frequently Asked Questions ==

= Can I customize the HTML output? =

Yes, below a typical output:

`
<div class="wp_bannerize_banner_box wp_bannerize_category_cocacola"
     data-title="Amiga Ball"
     data-mime_type="imagegif"
     data-impressions_enabled="true"
     data-clicks_enabled="true"
     data-banner_id="241"
     id="wpbanner-241">
    <a href="http://undolog.com">
      <img src="http://wordpress.dev/wp-content/uploads/2016/10/Boing.gif"
           alt="Amiga Ball"
           title="Amiga Ball"
           width="173px"
           height="141px"
           border="0">
     </a>
</div>
`

== Screenshots ==

1. Add new banner by local media library
2. Add new banner text
3. Real time preview
4. Date range rules
5. Enable impressions and click for single banner
6. Banner categories
7. Statistics overview
8. Single report with filters
9. Settings
10. Widget

Your screenshot

== Changelog ==

= 1.2.4 =

* test wp 4.8
* fix img tag width and height

= 1.2.3 =

* test wp 4.7.5
* fix geolocalizer

= 1.2.2 =

* several fixes
* update localization

= 1.0.4 =

* minor fixes and improvements

= 1.0.2 =

* improved meta data
* minor fixes

= 1.0.0 =

* this version replaced the old version

== Upgrade Notice ==

= 1.0.0 =
Please download :)