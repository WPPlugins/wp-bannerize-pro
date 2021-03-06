<?php
if ( ! defined( 'ABSPATH' ) ) exit;

wp_nonce_field( 'wp_bannerize' );
wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );

$columns = absint( get_current_screen()->get_columns() );

$columns_css = '';
if ( $columns ) {
  $columns_css = "columns-$columns";
}
?>
<input type="hidden" name="action" value="save_wp_bannerize" />

<div class="wp-bannerize-analytics-overview wrap">
  <h1>
    <?php _e( 'WP Bannerize Analytics Overview', WPBANNERIZE_TEXTDOMAIN ) ?>
  </h1>

  <div class="metabox-holder">

    <div class="metabox-holder <?php echo $columns_css; ?>">
      <?php do_meta_boxes( get_current_screen(), 'normal', '' ); ?>
    </div>

  </div>


</div>

<script type="text/javascript">
  //<![CDATA[
  jQuery( document ).ready( function()
  {
    // close postboxes that should be closed
    jQuery( '.if-js-closed' ).removeClass( 'if-js-closed' ).addClass( 'closed' );

    // postboxes setup
    postboxes.add_postbox_toggles( '<?php echo get_current_screen()->id ?>' );
  } );
  //]]>
</script>