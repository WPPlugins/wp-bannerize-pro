<?php if ( ! defined( 'ABSPATH' ) ) exit;

if ( isset( $info ) ) :  ?>

  <div class="wp-bannerize-analytics-information">
    <p class="left">
    <span class="total">
      <?php echo $info[ 'total' ] ?>
    </span> <?php _e( 'Total' ) ?> /
      <span class="average">
      <?php echo $info[ 'average' ] ?>
    </span> <?php _e( 'Average' ) ?>
    </p>

    <p class="right">
    <span class="total_unique">
      <?php echo $info[ 'total_unique' ] ?>
    </span> <?php _e( 'Unique' ) ?> /
      <span class="average_unique">
      <?php echo $info[ 'average_unique' ] ?>
    </span> <?php _e( 'Average' ) ?>
    </p>
  </div>

<?php endif; ?>

<div id="chart-morris-clicks-for-banners">
  <?php echo $chart ?>
</div>