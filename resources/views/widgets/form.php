<?php if ( ! defined( 'ABSPATH' ) ) {
  exit;
} ?>

<h2><?php _e( 'Display', WPBANNERIZE_TEXTDOMAIN ) ?></h2>

<p>
  <label for="<?php echo $widget->get_field_name( 'title' ) ?>">
    <?php _e( 'Title', WPBANNERIZE_TEXTDOMAIN ) ?>:
    <input type="text"
           size="20"
           placeholder="<?php _e( 'eg: title on top', WPBANNERIZE_TEXTDOMAIN ) ?>"
           value="<?php echo $instance[ 'title' ] ?>"
           id="<?php echo $widget->get_field_name( 'title' ) ?>"
           name="<?php echo $widget->get_field_name( 'title' ) ?>"/>
  </label>
</p>

<p>
  <label for="<?php echo $widget->get_field_name( 'layout' ) ?>">
    <?php _e( 'Layout', WPBANNERIZE_TEXTDOMAIN ) ?>:
    <select id="<?php echo $widget->get_field_name( 'layout' ) ?>"
            name="<?php echo $widget->get_field_name( 'layout' ) ?>">
      <option <?php selected( 'vertical', $instance[ 'layout' ] ) ?> value="vertical"><?php _e( 'Vertical', WPBANNERIZE_TEXTDOMAIN ) ?></option>
      <option <?php selected( 'horizontal', $instance[ 'layout' ] ) ?> value="horizontal"><?php _e( 'Horizontal', WPBANNERIZE_TEXTDOMAIN ) ?></option>
    </select>
  </label>
</p>

<p>
  <strong>
    <?php _e( 'Maximum number of Banners to display: use -1 to display all banners', WPBANNERIZE_TEXTDOMAIN ) ?>
  </strong>
</p>
<p>
  <label for="<?php echo $widget->get_field_name( 'numbers' ) ?>">
    <?php _e( 'Numbers', WPBANNERIZE_TEXTDOMAIN ) ?>:
    <input type="number"
           placeholder="<?php _e( 'Maximum number of Banners to display: use -1 to display all banners', WPBANNERIZE_TEXTDOMAIN ) ?>"
           size="3"
           min="-1"
           value="<?php echo $instance[ 'numbers' ] ?>"
           id="<?php echo $widget->get_field_name( 'numbers' ) ?>"
           name="<?php echo $widget->get_field_name( 'numbers' ) ?>"/>
  </label>
</p>

<p>
  <strong>
    <?php _e( 'Warning! The "Order" param will ignored when RANDOM "Order by" is selected.', WPBANNERIZE_TEXTDOMAIN ) ?>
  </strong>
</p>
<p>
  <label for="<?php echo $widget->get_field_name( 'orderby' ) ?>">
    <?php _e( 'Order By', WPBANNERIZE_TEXTDOMAIN ) ?>:
    <select id="<?php echo $widget->get_field_name( 'orderby' ) ?>"
            name="<?php echo $widget->get_field_name( 'orderby' ) ?>">
      <option <?php selected( 'menu_order', $instance[ 'orderby' ] ) ?> value="menu_order"><?php _e( 'Manual', WPBANNERIZE_TEXTDOMAIN ) ?></option>
      <option <?php selected( 'random', $instance[ 'orderby' ] ) ?> value="random"><?php _e( 'Random', WPBANNERIZE_TEXTDOMAIN ) ?></option>
      <option <?php selected( 'impressions', $instance[ 'orderby' ] ) ?> value="impressions"><?php _e( 'Impressions', WPBANNERIZE_TEXTDOMAIN ) ?></option>
      <option <?php selected( 'clicks', $instance[ 'orderby' ] ) ?> value="clicks"><?php _e( 'Clicks', WPBANNERIZE_TEXTDOMAIN ) ?></option>
      <option <?php selected( 'ctr', $instance[ 'orderby' ] ) ?> value="ctr"><?php _e( 'CTR', WPBANNERIZE_TEXTDOMAIN ) ?></option>
    </select>
  </label>

  <label for="<?php echo $widget->get_field_name( 'order' ) ?>">
    <?php _e( 'Order', WPBANNERIZE_TEXTDOMAIN ) ?>:
    <select id="<?php echo $widget->get_field_name( 'order' ) ?>"
            name="<?php echo $widget->get_field_name( 'order' ) ?>">
      <option <?php selected( 'DESC', $instance[ 'order' ] ) ?> value="DESC"><?php _e( 'Descending', WPBANNERIZE_TEXTDOMAIN ) ?></option>
      <option <?php selected( 'ASC', $instance[ 'order' ] ) ?> value="ASC"><?php _e( 'Ascending', WPBANNERIZE_TEXTDOMAIN ) ?></option>
    </select>
  </label>
</p>

<p>
  <strong>
    <?php _e( 'Switch on to give some chances to the banners to be showed when use Impressions, Click or CTR order by. Switch off to absolute order.', WPBANNERIZE_TEXTDOMAIN ) ?>
  </strong>
</p>
<p>
  <label for="<?php echo $widget->get_field_name( 'rank_seed' ) ?>">
    <?php _e( 'Rank', WPBANNERIZE_TEXTDOMAIN ) ?>:
    <input type="checkbox"
      <?php checked( "true", $instance[ 'rank_seed' ] ) ?>
           value="<?php echo $instance[ 'rank_seed' ] ?>"
           id="<?php echo $widget->get_field_name( 'rank_seed' ) ?>"
           name="<?php echo $widget->get_field_name( 'rank_seed' ) ?>"/>
  </label>
</p>

<h2><?php _e( 'Filters', WPBANNERIZE_TEXTDOMAIN ) ?></h2>

<p>
  <strong>
    Your banners will be visible only for the following filters.
  </strong>
</p>

<hr/>

<h4>
  <?php _e( 'Geo Localization', WPBANNERIZE_TEXTDOMAIN ) ?>
  <label style="float:right">
    <?php $displayGepSelectedId = 'wpxbz-dgs-' . uniqid(); ?>
    <input type="checkbox"
           id="<?php echo $displayGepSelectedId ?>"/>
    <?php _e( 'Display selected', WPBANNERIZE_TEXTDOMAIN ) ?>
  </label>
</h4>

<div class="wp-bannerize-scroll">

  <?php
  $countries        = \WPBannerize\GeoLocalizer\GeoLocalizerProvider::countries();
  $displayGeoUlId   = 'wpxbz-geo-ul-' . uniqid();
  $deselectButtonId = 'wpxbz-geo-deselect-' . uniqid();
  ?>

  <ul id="<?php echo $displayGeoUlId ?>"
      class="wp-bannerize-ul-column"><?php
    foreach ( array_values( $countries ) as $country ) : ?>

      <li>
        <label>
          <input name="<?php echo $widget->get_field_name( 'geo_countries' ) ?>[]"
            <?php if ( ! empty( $instance[ 'geo_countries' ] ) ) wpbones_checked( $instance[ 'geo_countries' ], $country->country ) ?>
                 type="checkbox"
                 value="<?php echo $country->country ?>"/>
          <?php echo $country->country ?>
        </label>
      </li>

    <?php endforeach; ?>
  </ul>

</div>

<div class="clearfix" style="margin:8px 0 16px">
  <?php if ( count( $instance[ 'geo_countries' ] ) > 0 ) : ?>
    <span style="vertical-align:middle" class="left"><?php _e( 'Selected countries:', WPBANNERIZE_TEXTDOMAIN ) ?> <?php echo count( $instance[ 'geo_countries' ] ) ?></span>
    <button id="<?php echo $deselectButtonId ?>"
            style="vertical-align:middle"
            class="button button-small button-primary right">
      <?php _e( 'Deselect all', WPBANNERIZE_TEXTDOMAIN ) ?>
    </button>
  <?php endif; ?>
</div>

<hr/>

<h4>
  <?php _e( 'Bannerize Categories', WPBANNERIZE_TEXTDOMAIN ) ?>
</h4>

<div>

  <?php
  // Get all bannerize categories
  $args  = [
    'hide_empty' => true,
  ];
  $terms = get_terms( 'wp_bannerize_tax', $args );

  ?>
  <ul class="wp-bannerize-ul-column"><?php
    foreach ( $terms as $term ) : ?>

      <li>
        <label>
          <input name="<?php echo $widget->get_field_name( 'categories' ) ?>[]"
            <?php if ( ! empty( $instance[ 'categories' ] ) ) wpbones_checked( $instance[ 'categories' ], $term->term_id ) ?>
                 type="checkbox"
                 value="<?php echo $term->term_id ?>"/>
          <?php echo $term->name ?>
        </label>
      </li>

    <?php endforeach; ?>
  </ul>
</div>

<hr/>

<h4>
  <?php _e( 'Post Categories', WPBANNERIZE_TEXTDOMAIN ) ?>
</h4>

<div>

  <?php
  // All post categories list
  $all_categories = get_categories();

  ?>
  <ul class="wp-bannerize-ul-column"><?php
    foreach ( $all_categories as $category ) : ?>

      <li>
        <label>
          <input name="<?php echo $widget->get_field_name( 'post_categories' ) ?>[]"
            <?php if ( ! empty( $instance[ 'post_categories' ] ) ) wpbones_checked( $instance[ 'post_categories' ], $category->cat_ID ) ?>
                 type="checkbox"
                 value="<?php echo $category->cat_ID ?>"/>
          <?php echo $category->cat_name ?>
        </label>
      </li>

    <?php endforeach; ?>
  </ul>
</div>

<hr/>

<h4>
  <?php _e( 'User Roles', WPBANNERIZE_TEXTDOMAIN ) ?>
</h4>

<div>
  <?php
  // Get all user roles
  $wpRoles = new WP_Roles;

  ?>
  <ul class="wp-bannerize-ul-column"><?php
    foreach ( $wpRoles->roles as $role => $value ) : ?>

      <li>
        <label title="<?php echo $value[ 'name' ] ?>"
               class="wpdk-ui-control">
          <input name="<?php echo $widget->get_field_name( 'user_roles' ) ?>[]"
            <?php if ( ! empty( $instance[ 'user_roles' ] ) ) wpbones_checked( $instance[ 'user_roles' ], $role ) ?>
                 type="checkbox"
                 value="<?php echo $role ?>"/>
          <?php echo $value[ 'name' ] ?></label>
      </li>

    <?php endforeach; ?>
  </ul>

</div>
<script type="text/javascript">
  (function( $ )
  {
    $( document ).on( 'click', '#<?php echo $deselectButtonId ?>',
      function( event )
      {
        event.preventDefault();

        $( '#<?php echo $displayGeoUlId ?>' )
          .find( 'input[type="checkbox"]' )
          .each(
            function( i )
            {
              $( this ).attr( 'checked', false );
            }
          );
      }
    );

    $( document ).on( 'change', '#<?php echo $displayGepSelectedId ?>',
      function( event )
      {
        if( event.target.checked ) {

          $( '#<?php echo $displayGeoUlId ?>' )
            .find( 'input[type="checkbox"]' )
            .each(
              function( i )
              {
                if( $( this ).is( ":checked" ) ) {
                  $( this ).parent( 'label' ).show();
                }
                else {
                  $( this ).parent( 'label' ).hide();
                }
              }
            );
        }
        else {
          $( '#<?php echo $displayGeoUlId ?>' )
            .find( 'input[type="checkbox"]' )
            .each(
              function( i )
              {
                $( this ).parent( 'label' ).show();
              }
            );
        }
      }
    );

  }( window.jQuery ));
</script>