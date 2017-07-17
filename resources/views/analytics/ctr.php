<?php if ( ! defined( 'ABSPATH' ) ) exit;

if ( isset( $info ) ) : ?>

  <div class="wp-bannerize-analytics-information">
    <p class="left">
    <span class="total">
      <?php echo $info[ 'average' ] ?>
    </span> <?php _e( 'Average' ) ?> /
      <span class="average">
      <?php echo $info[ 'average_unique' ] ?>
    </span> <?php _e( 'Average Unique' ) ?>
    </p>
  </div>

<?php endif; ?>

<div id="ctr-chart">
  <?php echo $chart ?>
</div>