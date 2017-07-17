<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Browser detect
global $is_chrome, $is_gecko, $is_opera;

// Firefox and Chrome supports a native color picker input field. Others browsers will be use the WordPress Color Picker
$type = ( $is_chrome || $is_gecko || $is_opera ) ? 'color' : 'text';

$style = sprintf( 'style="width:%s;height:%s"', $banner->banner_width, $banner->banner_height );

$size = $banner->getSizeWithURL( $banner->getUrl() );

?>
<label for="">
  <?php _e( 'Background Color Preview', WPBANNERIZE_TEXTDOMAIN ) ?>:
  <input name="wp_bannerize_preview_background_color"
         id="wp_bannerize_preview_background_color"
         value="<?php echo $banner->preview_background_color ?>"
         type="<?php echo $type ?>"/>
</label>

<div class="wp-bannerize-image-preview"
     style="background-color: <?php echo $banner->preview_background_color ?>">
  <img alt="<?php echo $banner->getDescription() ?>"
    <?php echo $style ?>
       border="0"
       src="<?php echo $banner->getUrl() ?>"/>
</div>
<p class="text-center">
  <strong><?php _e( 'Type', WPBANNERIZE_TEXTDOMAIN ) ?></strong>: <?php echo $banner->banner_mime_type ?> -
  <strong><?php _e( 'Size', WPBANNERIZE_TEXTDOMAIN ) ?></strong>: <?php printf( '%sx%s', $size[ 0 ], $size[ 1 ] ) ?>
  pixel
</p>