<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="wrap">

  <h2><?php _e( 'WP Bannerize Importer' ) ?></h2>

  <div class="wpbones-tabs">

    <?php WPBannerize\PureCSSTabs\PureCSSTabsProvider::openTab( __( 'Import' ), null, true ) ?>

    <p>
      <?php _e( 'A previous release of Bannerize table has been found. You can import your previous banners by following the instruction below.' ) ?>
    </p>

    <table class="wp-bannerize-importer-table-info">
      <tbody>

      <tr>
        <th>
          <?php _e( 'Table name' ) ?>
        </th>
        <td>
          <?php echo $importer->Tablename ?>
        </td>
      </tr>

      <tr>
        <th>
          <?php _e( 'Total records' ) ?>
        </th>
        <td>
          <?php echo $importer->totalRecords ?>
        </td>
      </tr>

      <tr>
        <th>
          <?php _e( 'Total enabled' ) ?>
        </th>
        <td>
          <?php echo $importer->totalEnabled ?>
        </td>
      </tr>

      <tr>
        <th>
          <?php _e( 'Total disabled' ) ?>
        </th>
        <td>
          <?php echo $importer->totalDisabled ?>
        </td>
      </tr>

      <tr>
        <th>
          <?php _e( 'Total trash' ) ?>
        </th>
        <td>
          <?php echo $importer->totalTrash ?>
        </td>
      </tr>

      </tbody>
    </table>

    <form method="post">

      <?php wp_nonce_field( 'wp_bannerize_importer' ); ?>

      <?php if( $importer->totalRecords > 0 ) : ?>

      <p>
        <?php _e( 'Select at least one group of Banner below that you would like to import' ) ?>
      </p>

      <ul class="wp-bannerize-ul-column">
        <?php foreach ( $importer->groups as $key => $label ) : ?>
          <li>
            <label for="<?php echo $key ?>">
              <input type="checkbox"
                     checked="checked"
                     value="<?php echo $key ?>"
                     id="<?php echo $key ?>"
                     name="wp_bannerize_importer_groups[]"/>
              <?php echo $label ?>
            </label>
          </li>
        <?php endforeach; ?>
      </ul>

      <p>
        <label for="wp_bannerize_importer_gropus">
          <?php ?>
        </label>
      </p>

      <p>
        <?php _e( 'Select at least one type of Banner below that you would like to import' ) ?>
      </p>

      <p>
        <label for="wp_bannerize_importer_local">
          <input type="checkbox"
                 checked="checked"
                 value="1"
                 id="wp_bannerize_importer_local"
                 name="wp_bannerize_importer_types[]"/>
          <?php _e( 'Local' ) ?>
        </label>
      </p>

      <p>
        <label for="wp_bannerize_importer_remote">
          <input type="checkbox"
                 checked="checked"
                 value="2"
                 id="wp_bannerize_importer_remote"
                 name="wp_bannerize_importer_types[]"/>
          <?php _e( 'Remote' ) ?>
        </label>
      </p>

      <p>
        <label for="wp_bannerize_importer_text">
          <input type="checkbox"
                 checked="checked"
                 value="3"
                 id="wp_bannerize_importer_text"
                 name="wp_bannerize_importer_types[]"/>
          <?php _e( 'text' ) ?>
        </label>
      </p>

      <hr/>

      <p>
        <?php _e( 'Optionals' ) ?>
      </p>

      <p>
        <label for="wp_bannerize_importer_trash">
          <?php echo WPBannerize\Html::checkbox()
                                     ->name( 'wp_bannerize_importer_trash' )
                                     ->id( 'wp_bannerize_importer_trash' )
                                     ->value( "1" ); ?>

          <?php _e( 'Import Trash' ) ?>
        </label>
      </p>

      <p>
        <label for="wp_bannerize_importer_disabled">
          <?php echo WPBannerize\Html::checkbox()
                                     ->name( 'wp_bannerize_importer_disabled' )
                                     ->id( 'wp_bannerize_importer_disabled' )
                                     ->value( "1" ); ?>

          <?php _e( 'Import Disabled' ) ?>
        </label>
      </p>

      <p>
        <label for="wp_bannerize_importer_drop_table">
          <?php echo WPBannerize\Html::checkbox()
                                     ->name( 'wp_bannerize_importer_drop_table' )
                                     ->id( 'wp_bannerize_importer_drop_table' )
                                     ->value( "1" ); ?>

          <?php _e( 'Drop previous bannerize table after import' ) ?>

        </label>
      </p>

      <hr>

      <p>
        <button name="wp_bannerize_destroy_previous_table"
                value="do_destroy"
                data-confirm="<?php _e( 'Warning! Are you sure to delete permately the previous table of Bannerize?' ) ?>"
                class="button button-hero alignleft">
          <?php _e( 'I don\'t want to import previous banners! Drop previous table!' ) ?>
        </button>

        <button name="wp_bannerize_import"
                value="do_import"
                class="button-primary button button-hero alignright">
          <?php _e( 'Start import' ) ?>
        </button>
      </p>

      <?php else : ?>

        <p>
          <?php _e( 'The previous WP Bannerize database table is empty! Of course, you can drop it by click the button below.', WPBANNERIZE_TEXTDOMAIN ) ?>
        </p>

        <p style="text-align: center">
          <button name="wp_bannerize_destroy_previous_table"
                  value="do_destroy"
                  data-confirm="<?php _e( 'Warning! Are you sure to delete permately the previous table of Bannerize?' ) ?>"
                  class="button button-hero">
            <?php _e( 'Drop previous table!' ) ?>
          </button>
        </p>

      <?php endif; ?>

    </form>

    <?php WPBannerize\PureCSSTabs\PureCSSTabsProvider::closeTab() ?>

  </div>

</div>

<script>

  jQuery( function( $ )
  {

    $( 'button[name="wp_bannerize_destroy_previous_table"]' ).on( 'click', function()
    {
      return confirm( $( this ).data( 'confirm' ) );

    } );


  } );

</script>