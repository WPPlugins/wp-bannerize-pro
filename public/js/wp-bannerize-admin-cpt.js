jQuery( function( $ )
{
  "use strict";

  window.WPXBannerizeAdminEditor = (function()
  {

    /**
     * This object
     *
     * @type {{version: string, init: _init}}
     * @private
     */
    var _WPXBannerizeAdminEditor = {
      version : '1.0.0',
      boot    : boot
    };

    function boot()
    {
      _initPreview();
      _initButtonsGroup();
      _initUpload();
      _initSortable();

      return _WPXBannerizeAdminEditor;
    }

    function _initPreview()
    {
      // Change background color
      $( document ).on( 'input change', '#wp_bannerize_preview_background_color', function()
      {
        $( '.wp-bannerize-image-preview' ).css( 'backgroundColor', $( this ).val() );
      } );
    }

    function _initButtonsGroup()
    {
      $( '.wp-bannerize-editor' ).find( '.wp-bannerize-btn-group input[type="radio"]' ).change(
        function()
        {
          var tab = $( this ).data( 'tab' );
          $( '.wp-bannerize-editor' ).find( '.wp-bannerize-tab' ).hide();
          $( '.wp-bannerize-editor ' + tab ).show();
        }
      );
    }

    function _initUpload()
    {
      var file_frame, attachment;

      $( document ).on( 'click', '.upload_image_button', false, function( event )
      {
        event.preventDefault();

        // If the media frame already exists, reopen it.
        if( file_frame ) {
          file_frame.open();
          return;
        }

        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media( {
          title    : $( this ).data( 'uploader_title' ),
          button   : {
            text : $( this ).data( 'uploader_button_text' )
          },
          multiple : false  // Set to true to allow multiple files to be selected
        } );

        // When an image is selected, run a callback.
        file_frame.on( 'select', function()
        {
          // We set multiple to false so only get one image from the uploader
          attachment = file_frame.state().get( 'selection' ).first().toJSON();

          // Do something with attachment.id and/or attachment.url here
          $( '#wp_bannerize_banner_url' ).val( attachment.url );
        } );

        // Finally, open the modal
        file_frame.open();
      } );
    }

    function _initSortable()
    {
      if( $( ".wp-list-table" ).length ) {
        $( 'table.wp-list-table tbody' ).sortable( {
            axis   : "y",
            cursor : "n-resize",
            start  : function( event, ui )
            {
            },
            stop   : function()
            {
            },
            update : function( event, ui )
            {

              // Serializze sortated post id
              var sorted = $( 'table.wp-list-table tbody' ).sortable( "serialize" );

              // Get the paged
              var paged = $( 'input#wp-bannerize-paged' ).val();

              // Get items per page
              var per_page = $( 'input#wp-bannerize-per-page' ).val();

              $.post(
                ajaxurl,
                {
                  action   : "wp_bannerize_action_sorting_post_page",
                  sorted   : sorted,
                  paged    : paged,
                  per_page : per_page
                },
                function( response )
                {
                }
              );
            }
          }
        );
      }
    }

    return boot();
  })();

} );
