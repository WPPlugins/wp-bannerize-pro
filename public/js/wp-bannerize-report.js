jQuery( function( $ )
{
  "use strict";

  window.WPXBannerizeAnalyticsReport = (function()
  {

    window.cacheImpressions = {
      impressions : null,
      clicks      : null,
      ctr         : null
    };

    var _WPXBannerizeAnalyticsReport = {
      version   : '1.0.0',
      construct : construct
    };

    /**
     * Init
     *
     * @returns {{version: string, construct: construct}}
     * @private
     */
    function construct()
    {
      // set date
      $( '#reload-banners' ).on( "click",
        function( e )
        {
          e.preventDefault();
          getBannersList();
        } );

      // date preset
      $( '#date-preset' ).on( 'change',
        function( e )
        {

          // get the value
          var value = $( e.target ).val();

          // get json
          var json = $.parseJSON( value.replace( /\\n/g, "\n" ) );

          $( "input[name='date_from']" ).triggerHandler( 'wpbones.setdate', json.start );
          $( "input[name='date_to']" ).triggerHandler( 'wpbones.setdate', json.end );

          getBannersList();

        } );

      // categories
      $( '#categories' ).on( 'change',
        function( e )
        {
          getBannersList();

        } );

      // Common, chart controller

      // accuracy
      $( '.accuracy' ).on( "change",
        function( e )
        {
          e.preventDefault();

          onDrawChart( $( e.target ).data( "target" ) );
        } );

      // chart type
      $( '.chart-type' ).on( 'change',
        function( e )
        {
          e.preventDefault();
          drawChart( $( e.target ).data( "target" ) );
        } );


      // draw chart
      $( '.draw-chart' ).on( "click",
        function( e )
        {
          e.preventDefault();

          onDrawChart( $( e.target ).data( "target" ) );
        } );

      return _WPXBannerizeAnalyticsReport;
    }

    // build the payload
    function payload( target )
    {
      var banners = [];

      $( '.banners-list' ).find( 'input:checked' ).each(
        function()
        {
          banners.push( $( this ).data( 'banner_id' ) );
        }
      );

      var $target = $( target );

      return {
        target    : "chart-morris-" + $target.attr( "id" ),
        action    : $target.data( "action" ),
        date_from : $( 'input[name="date_from"]' ).val(),
        date_to   : $( 'input[name="date_to"]' ).val(),
        category  : $( 'select#categories' ).val(),
        accuracy  : $target.find( 'select.accuracy' ).val(),
        banners   : banners
      };
    }

    // get the banner checkbox list
    function getBannersList()
    {
      $.post(
        ajaxurl,
        {
          action    : 'wp_bannerize_banners_list',
          date_from : $( 'input[name="date_from"]' ).val(),
          date_to   : $( 'input[name="date_to"]' ).val(),
          category  : $( 'select#categories' ).val(),
        },
        function( response )
        {
          var content = response.data.html;
          $( '.banners-list' ).html( content );
        } );
    }

    // remove a chart
    function clearCharts( target )
    {
      var id = $( target ).attr( "id" );
      $( target ).find( '.chart-box' ).html( '<div id="chart-morris-' + id + '"><img class="loading" src="/wp-admin/images/loading.gif" /></div>' );
    }

    // load and draw a chart
    function onDrawChart( target )
    {
      clearCharts( target );

      var id = $( target ).attr( "id" );

      $.post(
        ajaxurl,
        payload( target ),
        function( response )
        {
          // cache data
          window.cacheImpressions[ id ] = response.data.chart;

          drawChart( target );

        } );
    }

    // redraw a cached chart
    function drawChart( target )
    {
      clearCharts( target );

      var type      = $( target ).find( ".chart-type" ).val(),
          $chartBox = $( target ).find( '.chart-box' ),
          id        = $( target ).attr( "id" );

      $chartBox.find( '.loading' ).remove();

      if( typeof( window.cacheImpressions[ id ].data ) !== "undefined" ) {

        switch( type ) {
          case "line":
            Morris.Line( window.cacheImpressions[ id ] );
            break;

          case "bar":
            window.cacheImpressions[ id ].barSizeRatio = 0.4;
            window.cacheImpressions[ id ].barOpacity = 0.8;
            window.cacheImpressions[ id ].stacked = false;
            Morris.Bar( window.cacheImpressions[ id ] );
            break;

          case "bar-stacked":
            window.cacheImpressions[ id ].barSizeRatio = 0.4;
            window.cacheImpressions[ id ].barOpacity = 0.8;
            window.cacheImpressions[ id ].stacked = true;
            Morris.Bar( window.cacheImpressions[ id ] );
            break;

          case "area":
            window.cacheImpressions[ id ].fillOpacity = 0.5;
            Morris.Area( window.cacheImpressions[ id ] );
            break;
        }
      }
      else {
        $chartBox.html( '<div id="chart-morris-' + id + '"></div>' );
      }
    }

    return construct();
  })();

} );
