<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="wp-bannerize-analytics-report wrap">
  <h1>
    <?php _e( 'WP Bannerize Analytics Report', WPBANNERIZE_TEXTDOMAIN ) ?>
  </h1>

  <div class="wp-bannerize-filters">
    <h2><?php _e( 'Filters', WPBANNERIZE_TEXTDOMAIN ) ?></h2>

    <div class="date-filter">

      <label><?php _e( 'From date', WPBANNERIZE_TEXTDOMAIN ) ?>:
        <?php echo WPBannerize\Html::datetime()->value( $default_date_from )->name( 'date_from' ) ?>
      </label>

      <label><?php _e( 'to date', WPBANNERIZE_TEXTDOMAIN ) ?>:
        <?php echo WPBannerize\Html::datetime()->value( $default_date_to )->name( 'date_to' ) ?>
      </label>

      <button class="button button-primary"
              id="reload-banners">
        <?php _e( 'Set date', WPBANNERIZE_TEXTDOMAIN ) ?>
      </button>

      <p>
        <label for="date-preset"><?php _e( 'Date Preset', WPBANNERIZE_TEXTDOMAIN ) ?>:
          <select id="date-preset"
                  name="date-preset">

            <?php foreach ( $date_presets as $key => $value ) : ?>
              <option value="<?php echo $key ?>"><?php echo $value ?></option>
            <?php endforeach; ?>

          </select>
        </label>
      </p>

    </div>

    <div class="categories-filter">
      <label for="categories"><?php _e( 'Categories', WPBANNERIZE_TEXTDOMAIN ) ?>:
        <select id="categories"
                name="categories">

          <?php foreach ( $categories as $key => $value ) : ?>
            <option value="<?php echo $key ?>"><?php echo $value ?></option>
          <?php endforeach; ?>

        </select>
      </label>
    </div>

    <div class="banners-filters">
      <div class="banners-list">

        <?php echo WPBannerize()->view( 'analytics.report-banners' )->with( 'banners', $banners ) ?>

        <?php //var_dump( $banners ) ?>

      </div>
    </div>

    <!-- Impressions -->
    <div class="chart"
         id="impressions"
         data-action="wp_bannerize_report_impressions_chart">
      <div class="chart-controller">
        <div class="left">
          <h2><?php _e( 'Impressions Chart Reports', WPBANNERIZE_TEXTDOMAIN ) ?></h2>
        </div>

        <div class="chart-setting right">

          <label for="accuracy-impressions">
            <?php _e( 'Accuracy', WPBANNERIZE_TEXTDOMAIN ) ?>:
            <select name="accuracy-impressions"
                    class="accuracy"
                    data-target="#impressions"
                    id="accuracy-impressions">
              <option value="years"><?php _e( 'Years', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="months"><?php _e( 'Months', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option selected
                      value="days"><?php _e( 'Days', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="minutes"><?php _e( 'Minutes', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="seconds"><?php _e( 'Seconds', WPBANNERIZE_TEXTDOMAIN ) ?></option>
            </select>
          </label>

          <label for="chart-type-impressions">
            <?php _e( 'Chart Type', WPBANNERIZE_TEXTDOMAIN ) ?>:
            <select name="chart-type-impressions"
                    class="chart-type"
                    data-target="#impressions"
                    id="chart-type-impressions">
              <option value="line"><?php _e( 'Line', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="bar"><?php _e( 'Bar', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="bar-stacked"><?php _e( 'Bar Stacked', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="area"><?php _e( 'Area', WPBANNERIZE_TEXTDOMAIN ) ?></option>
            </select>
          </label>

          <button class="button button-primary draw-chart"
                  data-target="#impressions">
            <?php _e( 'Draw Chart', WPBANNERIZE_TEXTDOMAIN ) ?>
          </button>

        </div>
      </div>

      <div class="chart-box">
        <div id="chart-morris-impressions">
          <i><?php _e( 'Click on <strong>Draw Chart</strong> button', WPBANNERIZE_TEXTDOMAIN ) ?></i></div>
      </div>
    </div>

    <!-- Clicks -->
    <div class="chart"
         id="clicks"
         data-action="wp_bannerize_report_clicks_chart">
      <div class="chart-controller">
        <div class="left">
          <h2><?php _e( 'Clicks Chart Reports', WPBANNERIZE_TEXTDOMAIN ) ?></h2>
        </div>

        <div class="chart-setting right">

          <label for="accuracy-clicks">
            <?php _e( 'Accuracy', WPBANNERIZE_TEXTDOMAIN ) ?>:
            <select name="accuracy-clicks"
                    class="accuracy"
                    data-target="#clicks"
                    id="accuracy-clicks">
              <option value="years"><?php _e( 'Years', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="months"><?php _e( 'Months', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option selected
                      value="days"><?php _e( 'Days', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="minutes"><?php _e( 'Minutes', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="seconds"><?php _e( 'Seconds', WPBANNERIZE_TEXTDOMAIN ) ?></option>
            </select>
          </label>

          <label for="chart-type-clicks">
            <?php _e( 'Chart Type', WPBANNERIZE_TEXTDOMAIN ) ?>:
            <select name="chart-type-clicks"
                    class="chart-type"
                    data-target="#clicks"
                    id="chart-type-clicks">
              <option value="line"><?php _e( 'Line', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="bar"><?php _e( 'Bar', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="bar-stacked"><?php _e( 'Bar Stacked', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="area"><?php _e( 'Area', WPBANNERIZE_TEXTDOMAIN ) ?></option>
            </select>
          </label>

          <button class="button button-primary draw-chart"
                  data-target="#clicks">
            <?php _e( 'Draw Chart', WPBANNERIZE_TEXTDOMAIN ) ?>
          </button>

        </div>
      </div>

      <div class="chart-box">
        <div id="chart-morris-clicks">
          <i><?php _e( 'Click on <strong>Draw Chart</strong> button', WPBANNERIZE_TEXTDOMAIN ) ?></i></div>
      </div>
    </div>

    <!-- CRT -->
    <div class="chart"
         id="ctr"
         data-action="wp_bannerize_report_ctr_chart">
      <div class="chart-controller">
        <div class="left">
          <h2><?php _e( 'CTR Chart Reports', WPBANNERIZE_TEXTDOMAIN ) ?></h2>
        </div>

        <div class="chart-setting right">

          <label for="accuracy-ctr">
            <?php _e( 'Accuracy', WPBANNERIZE_TEXTDOMAIN ) ?>:
            <select name="accuracy-ctr"
                    class="accuracy"
                    data-target="#ctr"
                    id="accuracy-ctr">
              <option value="years"><?php _e( 'Years', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="months"><?php _e( 'Months', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option selected
                      value="days"><?php _e( 'Days', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="minutes"><?php _e( 'Minutes', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="seconds"><?php _e( 'Seconds', WPBANNERIZE_TEXTDOMAIN ) ?></option>
            </select>
          </label>

          <label for="chart-type-ctr">
            <?php _e( 'Chart Type', WPBANNERIZE_TEXTDOMAIN ) ?>:
            <select name="chart-type-ctr"
                    class="chart-type"
                    data-target="#ctr"
                    id="chart-type-ctr">
              <option value="line"><?php _e( 'Line', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="bar"><?php _e( 'Bar', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="bar-stacked"><?php _e( 'Bar Stacked', WPBANNERIZE_TEXTDOMAIN ) ?></option>
              <option value="area"><?php _e( 'Area', WPBANNERIZE_TEXTDOMAIN ) ?></option>
            </select>
          </label>

          <button class="button button-primary draw-chart"
                  data-target="#ctr">
            <?php _e( 'Draw Chart', WPBANNERIZE_TEXTDOMAIN ) ?>
          </button>

        </div>
      </div>

      <div class="chart-box">
        <div id="chart-morris-ctr">
          <i><?php _e( 'Click on <strong>Draw Chart</strong> button', WPBANNERIZE_TEXTDOMAIN ) ?></i></div>
      </div>
    </div>

  </div>


</div>