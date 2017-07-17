<?php

namespace WPBannerize\Http\Controllers;

use WPBannerize\Http\Controllers\Controller;
use WPBannerize\PureCSSTabs\PureCSSTabsProvider;
use WPBannerize\PureCSSSwitch\PureCSSSwitchProvider;

class WPBannerizeSettingsController extends Controller
{

  public function index()
  {
    PureCSSTabsProvider::enqueueStyles();
    PureCSSSwitchProvider::enqueueStyles();

    // GET
    return WPBannerize()->view( 'settings.index' );
  }

  public function store()
  {
    // POST
  }

  public function update()
  {
    PureCSSTabsProvider::enqueueStyles();
    PureCSSSwitchProvider::enqueueStyles();

    if ( $this->request->verifyNonce( 'wp_bannerize' ) ) {

      WPBannerize()->options->update( $this->request->getAsOptions() );

      return WPBannerize()->view( 'settings.index' )
                     ->with( 'feedback', __( 'Settings updated!', WPBANNERIZE_TEXTDOMAIN ) );
    }
    else {
      return WPBannerize()->view( 'settings.index' )
                     ->with( 'feedback', __( 'Action not allowed!', WPBANNERIZE_TEXTDOMAIN ) );
    }
  }

  public function destroy()
  {
    // DELETE
  }

}