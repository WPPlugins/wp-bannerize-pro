<?php

namespace WPBannerize\CustomTaxonomyTypes;

use WPBannerize\WPBones\Foundation\WordPressCustomTaxonomyTypeServiceProvider as ServiceProvider;

class WPBannerizeCustomTaxonomyType extends ServiceProvider
{

  protected $id              = 'wp_bannerize_tax';
  protected $name            = 'Banner';
  protected $plural          = 'Banners';
  protected $objectType      = 'wp_bannerize';
  protected $queryVar        = 'bannerize_category';
  protected $hierarchical    = true;
  protected $showTagcloud    = false;
  protected $showAdminColumn = true;
  protected $withFront       = false;

  /**
   * You may override this method in order to register your own actions and filters.
   *
   */
  public function boot()
  {
    // You may override this method
  }


}