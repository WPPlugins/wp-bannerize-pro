<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$size = $banner->getSizeWithURL( $banner->getUrl() );
?>

<div class="wp-bannerize-image-thumbnail">
  <a rel="gallery"
     title="<?php echo $banner->getDescription() ?>"
     href="<?php echo $banner->getUrl() ?>"
     class="thickbox">
    <img alt="<?php echo $banner->getDescription() ?>"
         border="0"
         src="<?php echo $banner->getUrl() ?>"/>
  </a>
</div>