<?php

namespace WPBannerize\CustomPostTypes;

use WPBannerize\WPBones\Foundation\WordPressCustomPostTypeServiceProvider;
use WPBannerize\Models\WPBannerizePost;
use WPBannerize\PureCSSTabs\PureCSSTabsProvider;
use WPBannerize\PureCSSSwitch\PureCSSSwitchProvider;

class WPBannerizeCustomPostType extends WordPressCustomPostTypeServiceProvider
{

  protected $id             = 'wp_bannerize';
  protected $name           = 'Banner';
  protected $plural         = 'Banners';
  protected $hierarchical   = true;
  protected $queryVar       = 'wp_bannerize';
  protected $capabilityType = 'page';
  protected $mapMetaCap     = true;
  protected $menuIcon       = 'dashicons-images-alt';
  protected $supports       = [
    'title',
    'author',
    'thumbnail',
    'revisions',
  ];
  protected $rewrite        = [
    'slug'       => 'banner',
    'with_front' => false,
    'pages'      => true,
    'ep_mask'    => EP_PERMALINK,
  ];

  /**
   * An instance of WPBannerizePost class.
   *
   * @var WPBannerizePost $_banner
   */
  private $_banner = null;

  /**
   * You may override this method in order to register your own actions and filters.
   *
   */
  public function boot()
  {
    // You may override this method
    $this->registerMetaBoxCallback = [ $this, 'register_meta_box_cb' ];

    $this->labels = [
      'name'               => __( 'Banners', WPBANNERIZE_TEXTDOMAIN ),
      'singular_name'      => __( 'Banner', WPBANNERIZE_TEXTDOMAIN ),
      'menu_name'          => __( 'WP Bannerize', WPBANNERIZE_TEXTDOMAIN ),
      'name_admin_bar'     => __( 'Banner', WPBANNERIZE_TEXTDOMAIN ),
      'add_new'            => __( 'Add New', WPBANNERIZE_TEXTDOMAIN ),
      'add_new_item'       => __( 'Add New Banner', WPBANNERIZE_TEXTDOMAIN ),
      'edit_item'          => __( 'Edit Banner', WPBANNERIZE_TEXTDOMAIN ),
      'new_item'           => __( 'New Banner', WPBANNERIZE_TEXTDOMAIN ),
      'view_item'          => __( 'View Banner', WPBANNERIZE_TEXTDOMAIN ),
      'search_items'       => __( 'Search Banner', WPBANNERIZE_TEXTDOMAIN ),
      'not_found'          => __( 'No Banner found', WPBANNERIZE_TEXTDOMAIN ),
      'not_found_in_trash' => __( 'No Banners found in trash', WPBANNERIZE_TEXTDOMAIN ),
      'all_items'          => __( 'Banners', WPBANNERIZE_TEXTDOMAIN ),
      'archive_title'      => __( 'Banner', WPBANNERIZE_TEXTDOMAIN ),
      'parent_item_colon'  => '',
    ];

    if ( is_admin() ) {

      // Fires after the title field.
      add_action( 'edit_form_after_title', [ $this, 'edit_form_after_title' ] );

      // Filter the title field placeholder text.
      add_filter( 'enter_title_here', [ $this, 'enter_title_here' ] );

      // help
      add_action( 'load-edit.php', [ $this, 'load_edit_php' ] );
      add_action( 'load-post.php', [ $this, 'load_post_php' ] );
      add_action( 'load-post-new.php', [ $this, 'load_post_php' ] );

      // Post edit

      // Fires when styles are printed for a specific admin page based on $hook_suffix.
      add_action( 'admin_print_styles-post.php', [ $this, 'admin_print_styles_post_php' ] );

      // Prints scripts and data queued for the footer.
      add_action( 'admin_print_footer_scripts-post.php', [ $this, 'admin_print_footer_scripts_post_php' ] );

      // Post new

      // Fires when styles are printed for a specific admin page based on $hook_suffix.
      add_action( 'admin_print_styles-post-new.php', [ $this, 'admin_print_styles_post_php' ] );

      // Prints scripts and data queued for the footer.
      add_action( 'admin_print_footer_scripts-post-new.php', [ $this, 'admin_print_footer_scripts_post_php' ] );

      // Post List

      // Fires when styles are printed for a specific admin page based on $hook_suffix.
      add_action( 'admin_print_styles-edit.php', [ $this, 'admin_print_styles_edit_php' ] );

      // Prints scripts and data queued for the footer.
      add_action( 'admin_print_footer_scripts-edit.php', [ $this, 'admin_print_footer_scripts_edit_php' ] );

      // Filters the columns displayed in the Posts list table for a specific post type.
      add_filter( "manage_{$this->id}_posts_columns", [ $this, 'manage_posts_columns' ] );

      // Fires for each custom column of a specific post type in the Posts list table.
      add_action( "manage_{$this->id}_posts_custom_column", [ $this, 'manage_posts_custom_column' ] );

      // Fires immediately after a post is deleted from the database.
      add_action( 'deleted_post', [ $this, 'deleted_post' ] );

      // Fires before the Filter button on the Posts and Pages list tables.
      add_action( 'restrict_manage_posts', [ $this, 'restrict_manage_posts' ] );

      // Fires after the main query vars have been parsed.
      add_filter( 'parse_query', [ $this, 'parse_query' ] );
    }
  }

  protected function getBanner( $post )
  {
    if ( is_null( $this->_banner ) ) {

      if ( is_numeric( $post ) ) {
        $post_id = $post;
      }
      elseif ( is_object( $post ) && isset( $post->ID ) ) {
        $post_id = $post->ID;
      }
      else {
        $post_id = null;
      }

      $this->_banner = WPBannerizePost::find( $post_id );
    }

    return $this->_banner;
  }

  /**
   * Override this method to save/update your custom data.
   * This method is called by hook action save_post_{post_type}`
   *
   * @param int|string $post_id Post ID
   * @param object     $post    Optional. Post object
   *
   */
  public function update( $post_id, $post )
  {
    // You can override this method to save your own data

    $type      = esc_attr( $_POST[ 'wp_bannerize_banner_type' ] );
    $url       = esc_url( $_POST[ 'wp_bannerize_banner_url' ] );
    $urlExt    = esc_url( $_POST[ 'wp_bannerize_banner_external_url' ] );
    $urlMine   = ( $type == 'local' ) ? $url : $urlExt;
    $size      = $this->getBanner( $post_id )->getSizeWithURL( $urlMine );
    $width     = empty( $size[ 0 ] ) ? '' : $size[ 0 ] . 'px';
    $height    = empty( $size[ 1 ] ) ? '' : $size[ 1 ] . 'px';
    $mime_type = $size[ 'mime' ];
    $width     = empty( $_POST[ 'wp_bannerize_banner_width' ] ) ? $width : esc_attr( $_POST[ 'wp_bannerize_banner_width' ] );
    $height    = empty( $_POST[ 'wp_bannerize_banner_height' ] ) ? $height : esc_attr( $_POST[ 'wp_bannerize_banner_height' ] );


    $meta = [
      'wp_bannerize_banner_type'                => $type,
      'wp_bannerize_banner_url'                 => $url,
      'wp_bannerize_banner_external_url'        => $urlExt,
      'wp_bannerize_banner_link'                => esc_url( $_POST[ 'wp_bannerize_banner_link' ] ),
      'wp_bannerize_banner_description'         => esc_attr( $_POST[ 'wp_bannerize_banner_description' ] ),
      'wp_bannerize_banner_no_follow'           => wpbones_is_true( $_POST[ 'wp_bannerize_banner_no_follow' ] ),
      'wp_bannerize_banner_target'              => esc_attr( $_POST[ 'wp_bannerize_banner_target' ] ),
      'wp_bannerize_banner_width'               => esc_attr( $width ),
      'wp_bannerize_banner_height'              => esc_attr( $height ),
      'wp_bannerize_banner_mime_type'           => $mime_type,
      'wp_bannerize_banner_impressions_enabled' => wpbones_is_true( $_POST[ 'wp_bannerize_banner_impressions_enabled' ] ),
      'wp_bannerize_banner_clicks_enabled'      => wpbones_is_true( $_POST[ 'wp_bannerize_banner_clicks_enabled' ] ),
      'wp_bannerize_banner_date_from'           => strtotime( $_POST[ 'wp_bannerize_banner_date_from' ] ),
      'wp_bannerize_banner_date_expiry'         => strtotime( $_POST[ 'wp_bannerize_banner_date_expiry' ] ),
      'wp_bannerize_preview_background_color'   => isset( $_POST[ 'wp_bannerize_preview_background_color' ] ) ? esc_attr( $_POST[ 'wp_bannerize_preview_background_color' ] ) : '#ffffff',
    ];

    foreach ( $meta as $key => $value ) {
      update_post_meta( $post_id, $key, $value );
    }
  }

  /*
  |--------------------------------------------------------------------------
  | Actions and filters
  |--------------------------------------------------------------------------
  |
  | Here is where you can insert your actions and filters.
  |
  */

  /**
   * This action is called when you can add the meta box
   */
  public function register_meta_box_cb()
  {
    global $post;

    // Init metabox

    add_meta_box( 'wp_bannerize_preview',
                  __( 'Preview', WPBANNERIZE_TEXTDOMAIN ),
                  [ $this, 'metaBoxViewPreview' ],
                  $this->id,
                  'normal',
                  'high' );
  }

  public function load_edit_php()
  {
    if ( $this->is() ) {
      get_current_screen()->add_help_tab(
        [
          'id'      => 'wp_bannerize-overview',
          'title'   => __( 'Overview' ),
          'content' => WPBannerize()->view( 'help.banners-list' ),
        ]
      );
    }
  }

  public function load_post_php()
  {
    if ( $this->is() ) {
      get_current_screen()->add_help_tab(
        [
          'id'      => 'wp_bannerize-overview',
          'title'   => __( 'Overview' ),
          'content' => WPBannerize()->view( 'help.banners-edit' ),
        ]
      );
    }
  }

  /**
   * Fires after the title field.
   */
  public function edit_form_after_title()
  {
    global $post;

    // Only for this custom post
    if ( $this->is() ) {
      echo WPBannerize()->view( 'cpt.edit' )->with( 'banner', $this->getBanner( $post->ID ) );
    }
  }

  /**
   * Filter the title field placeholder text.
   *
   * @param string $text Placeholder text. Default 'Enter title here'.
   *
   * @return string
   */
  public function enter_title_here( $text )
  {
    if ( ! $this->is() ) {
      return $text;
    }

    $text = __( 'Enter Banner name', WPBANNERIZE_TEXTDOMAIN );

    return $text;
  }

  // Fires when styles are printed for a specific admin page based on $hook_suffix.
  public function admin_print_styles_post_php()
  {
    if ( ! $this->is() ) {
      return;
    }

    // Embed lighbox
    add_thickbox();

    // pure css tabs
    PureCSSTabsProvider::enqueueStyles();
    PureCSSSwitchProvider::enqueueStyles();

    // Override thickbox styles
    wp_enqueue_style( 'wp-bannerize-thickbox',
                      WPBannerize()->css . '/wp-bannerize-thickbox.min.css',
                      [],
                      WPBannerize()->Version
    );
    wp_enqueue_style( 'wp-bannerize-admin-cpt',
                      WPBannerize()->css . '/wp-bannerize-admin-cpt.min.css',
                      [ 'wp-color-picker' ],
                      WPBannerize()->Version );
  }

  // Prints scripts and data queued for the footer.
  public function admin_print_footer_scripts_post_php()
  {
    if ( ! $this->is() ) {
      return;
    }

    wp_enqueue_script( 'wp-bannerize-admin-cpt',
                       WPBannerize()->js . '/wp-bannerize-admin-cpt.min.js',
                       [ 'wp-color-picker' ],
                       WPBannerize()->Version,
                       true
    );
  }

  // Fires when styles are printed for a specific admin page based on $hook_suffix.
  public function admin_print_styles_edit_php()
  {
    // Embed lighbox
    add_thickbox();

    // Override thickbox styles
    wp_enqueue_style( 'wp-bannerize-thickbox',
                      WPBannerize()->css . '/wp-bannerize-thickbox.min.css',
                      [],
                      WPBannerize()->Version
    );
    wp_enqueue_style( 'wp-bannerize-admin-cpt',
                      WPBannerize()->css . '/wp-bannerize-admin-cpt.min.css',
                      [ 'wp-color-picker' ],
                      WPBannerize()->Version
    );

  }

  // Prints scripts and data queued for the footer.
  public function admin_print_footer_scripts_edit_php()
  {
    if ( ! $this->is() ) {
      return;
    }

    wp_enqueue_script( 'wp-bannerize-admin-cpt',
                       WPBannerize()->js . '/wp-bannerize-admin-cpt.min.js',
                       [
                         'wp-color-picker',
                         'jquery-ui-core',
                         'jquery-ui-sortable',
                         'jquery-ui-draggable',
                       ],
                       WPBannerize()->Version,
                       true
    );

  }

  /**
   * Filters the columns displayed in the Posts list table for a specific post type.
   *
   * The dynamic portion of the hook name, `$post_type`, refers to the post type slug.
   *
   * @param array $post_columns An array of column names.
   *
   * @return array
   */
  public function manage_posts_columns( $post_columns )
  {
    $post_columns = wpbones_array_insert( $post_columns, 'wp_bannerize_column_menu_order', '<i class="dashicons dashicons-editor-ol"></i>' );
    $post_columns = wpbones_array_insert( $post_columns, 'wp_bannerize_column_thumbnail', __( 'Thumbnail', WPBANNERIZE_TEXTDOMAIN ), 2 );

    $post_columns = wpbones_array_insert( $post_columns, 'wp_bannerize_column_impressions', __( 'Impressions', WPBANNERIZE_TEXTDOMAIN ), count( $post_columns ) - 2 );
    $post_columns = wpbones_array_insert( $post_columns, 'wp_bannerize_column_clicks', __( 'Clicks', WPBANNERIZE_TEXTDOMAIN ), count( $post_columns ) - 2 );
    $post_columns = wpbones_array_insert( $post_columns, 'wp_bannerize_column_ctr', __( 'CTR', WPBANNERIZE_TEXTDOMAIN ), count( $post_columns ) - 2 );

    return $post_columns;
  }

  /**
   * Fires for each custom column of a specific post type in the Posts list table.
   *
   * The dynamic portion of the hook name, `$post->post_type`, refers to the post type.
   *
   * @param string $column_name The name of the column to display.
   */
  public function manage_posts_custom_column( $column_name )
  {
    global $post;

    $banner = WPBannerizePost::find( $post->ID );

    switch ( $column_name ) {

      // Thumbnail
      case 'wp_bannerize_column_thumbnail':

        echo $banner->thumbnail();

        break;

      // order
      case 'wp_bannerize_column_menu_order':
        printf( '<i data-order="%s" class="dashicons dashicons-move"></i>', $post->menu_order );
        break;

      // impressions
      case 'wp_bannerize_column_impressions':
        echo $banner->banner_impressions;
        break;

      // clicks
      case 'wp_bannerize_column_clicks':
        echo $banner->banner_clicks;
        break;

      // ctr
      case 'wp_bannerize_column_ctr':

        $impressions = $banner->banner_impressions;
        $clicks      = $banner->banner_clicks;

        if ( ! empty( $impressions ) ) {
          echo number_format( $clicks / $impressions * 100, 2 ) . ' %';
        }

        break;

      default:
        echo "todo";
        break;
    }
  }

  /**
   * Fires immediately after a post is deleted from the database.
   *
   * Used to delete impressions and clicks when a post is pemanently deleted. Remember that all postmeta are auto delete
   * by WordPress.
   *
   * @param int $post_id Post ID.
   */
  public function deleted_post( $post_id )
  {
    /**
     * @var wpdb $wpdb
     */
    global $wpdb;
    global $post_type;

    // Only for bannerize custom post
    if ( $post_type == $this->id ) {

      // TODO: remake
      // Delete impressions
//      $sql = sprintf( 'DELETE FROM %s WHERE banner_id = %s', WPXBannerizeImpressions::init()->table->table_name, $post_id );
//      $wpdb->query( $sql );
//
//      // Delete clicks
//      $sql = sprintf( 'DELETE FROM %s WHERE banner_id = %s', WPXBannerizeClicks::init()->table->table_name, $post_id );
//      $wpdb->query( $sql );
    }
  }

  /**
   * Fires before the Filter button on the Posts and Pages list tables.
   *
   * The Filter button allows sorting by date and/or category on the
   * Posts list table, and sorting by date on the Pages list table.
   *
   * @since WP 2.1.0
   */
  public function restrict_manage_posts()
  {
    global $typenow, $per_page;

    // Get the post type
    $cpt = get_post_type_object( $typenow );

    // Enabled drag & drop menu order only for post type page
    if ( ! empty( $cpt ) && is_object( $cpt ) && post_type_supports( $typenow, 'page-attributes' ) ) {
      // Build info on pagination. Useful for sorter
      $paged = isset( $_REQUEST[ 'paged' ] ) ? $_REQUEST[ 'paged' ] : '1';
      ?>
      <input rel="<?php echo $typenow ?>"
             type="hidden"
             name="wp-bannerize-per-page"
             id="wp-bannerize-per-page"
             value="<?php echo $per_page ?>"/>
      <input type="hidden"
             name="wp-bannerize-paged"
             id="wp-bannerize-paged"
             value="<?php echo $paged ?>"/>
      <?php
    }

    /*
     * If you only want this to work for your specific post type, check for that $type here and then return.
     * This function, if unmodified, will add the dropdown for each post type / taxonomy combination.
     *
     * // Return the registered custom post types; exclude the builtin
     * $post_types = get_post_types( array( '_builtin' => false ) );
     *
     */

    if ( $this->id == $typenow ) {
      $filters = get_object_taxonomies( $typenow );

      foreach ( $filters as $tax_slug ) {

        $tax_obj = get_taxonomy( $tax_slug );

        $args = [
          'show_option_all' => __( 'Show All' ) . ' ' . $tax_obj->label,
          'taxonomy'        => $tax_slug,
          'name'            => $tax_obj->query_var,
          'orderby'         => 'name',
          'selected'        => isset( $_GET[ $tax_obj->query_var ] ) ? $_GET[ $tax_obj->query_var ] : '',
          'hierarchical'    => $tax_obj->hierarchical,
          'show_count'      => true,
          'hide_empty'      => false,
        ];

        wp_dropdown_categories( $args );
      }
    }
  }

  /**
   * Fires after the main query vars have been parsed.
   *
   * @since WP 1.5.0
   *
   * @param \WP_Query &$query The WP_Query instance (passed by reference).
   */
  public function parse_query( $query )
  {
    global $pagenow, $typenow;

    if ( 'edit.php' == $pagenow && $this->id == $typenow ) {

      $filters = get_object_taxonomies( $typenow );
      foreach ( $filters as $tax_slug ) {
        $tax_obj = get_taxonomy( $tax_slug );
        $var     = &$query->query_vars[ $tax_obj->query_var ];

        if ( isset( $var ) ) {
          $term = get_term_by( 'id', $var, $tax_slug );
          $var  = $term->slug;
        }
      }
    }
  }

  public function metaBoxViewPreview()
  {
    global $post;

    echo WPBannerize()->view( 'cpt.preview' )->with( 'banner', $this->getBanner( $post ) );
  }
}