<?php if ( ! defined( 'ABSPATH' ) ) exit;

if ( empty( $banners ) ) : ?>

  <p>
    <i style="color:#aaa">
      <?php _e( 'No Banner impressions found for selected filters', WPBANNERIZE_TEXTDOMAIN ) ?>
    </i>
  </p>

<?php else : ?>

  <ul>
    <?php foreach ( $banners as $banner ): ?>
      <li>
        <label for="banner-<?php echo $banner[ 'banner_id' ] ?>">
          <input type="checkbox"
                 name="banner-<?php echo $banner[ 'banner_id' ] ?>"
                 data-banner_id="<?php echo $banner[ 'banner_id' ] ?>"
                 id="banner-<?php echo $banner[ 'banner_id' ] ?>"/>
          <?php echo $banner[ 'title' ] ?>
        </label>
      </li>
    <?php endforeach; ?>
  </ul>

<?php endif;