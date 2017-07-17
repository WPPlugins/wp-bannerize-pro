<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<!-- main tabs container -->
<div class="wpbones-tabs">

  <?php echo WPBannerize()->view( 'cpt.bannertype' )->with( 'banner', $banner ) ?>
  <?php echo WPBannerize()->view( 'cpt.settings' )->with( 'banner', $banner ) ?>
  <?php echo WPBannerize()->view( 'cpt.rules' )->with( 'banner', $banner ) ?>
  <?php echo WPBannerize()->view( 'cpt.size' )->with( 'banner', $banner ) ?>
  <?php echo WPBannerize()->view( 'cpt.analytics' )->with( 'banner', $banner ) ?>

</div>
