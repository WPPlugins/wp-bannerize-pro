<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Browser detect
global $is_chrome, $is_gecko, $is_opera;

// Firefox and Chrome supports a native color picker input field. Others browsers will be use the WordPress Color Picker
$type = ( $is_chrome || $is_gecko || $is_opera ) ? 'color' : 'text';

// Get size
$width  = empty( $banner->banner_width ) ? '100%' : $banner->banner_width;
$height = empty( $banner->banner_height ) ? '100%' : $banner->banner_height;

// Preview color
$color       = '';
$color_style = '';

if ( ! empty( $banner->preview_background_color ) ) {
  $color       = $banner->preview_background_color;
  $color_style = sprintf( 'background-color:%s', $color );
}
?>
<div style="<?php echo $color_style ?>" class="wp-bannerize-image-preview">
  <iframe src="/wp_bannerize_pro?id=<?php echo $banner->ID ?>" style="width:<?php echo $width ?>;height:<?php echo $height ?>;<?php echo $color_style ?>" id="wp-bannerize-iframe-preview"></iframe>
</div>
<p class="text-center">
  <strong>
    <?php _e( 'Type', WPBANNERIZE_TEXTDOMAIN ) ?>
  </strong>: <?php echo $banner->banner_mime_type ?> - <strong><?php _e( 'Size', WPBANNERIZE_TEXTDOMAIN ) ?></strong>: <?php echo $width ?> x <?php echo $height ?>
</p>
<input value="<?php echo $color ?>" type="<?php echo $type ?>" id="wp_bannerize_preview_background_color" name="wp_bannerize_preview_background_color"/>