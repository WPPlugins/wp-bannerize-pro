<?php

namespace WPBannerize\Models;

class WPBannerizeModel
{

  public $table;

  protected $record;

  protected $where = [ 'WHERE 1' ];

  protected $count = '';

  protected $accuracy = '%Y-%m-%d %H:%i:%s';

  protected $orderBy = '';

  protected $order = 'ASC';

  protected $groupBy = '';

  protected $limit = '';

  protected $dateFrom = '';

  protected $dateTo = '';

  protected $dateIntervalFrom = '';

  protected $dateIntervalTo = '';

  protected $categories = [];

  protected $banners = [];

  public function __construct()
  {
    global $wpdb;

    $completeClassName = (string) get_class( $this );
    $parts             = (array) explode( '\\', $completeClassName );
    $className         = end( $parts );
    $this->table       = $wpdb->prefix . strtolower( $className );

  }

  public function __get( $name )
  {

  }

  public function __call( $name, $arguments )
  {
    $method = 'set' . ucfirst( $name ) . 'Attribute';

    if ( method_exists( $this, $method ) ) {
      return call_user_func_array( [ $this, $method ], $arguments );
    }
  }

  public static function __callStatic( $name, $arguments )
  {
    $instance = new static();

    $method = 'set' . ucfirst( $name ) . 'Attribute';

    if ( method_exists( $instance, $method ) ) {
      return call_user_func_array( [ $instance, $method ], $arguments );
    }
  }

  public static function getTableName()
  {
    $instance = new static();

    return $instance->table;
  }

  public static function find( $id )
  {

  }

  public static function all()
  {
    $instance = new static();

    return $instance->get();
  }

  public static function create( $values, $formats = [] )
  {
    /**
     * @var wpdb $wpdb
     */
    global $wpdb;

    $instance = new static();

    try {
      $result = $wpdb->insert( $instance->table, $values, $formats );
    }
    catch( \Exception $e ) {
      trigger_error( "Error while create a record in {$instance->table} table" );
    }
    finally {
      //
      return $instance;
    }
  }

  public static function update( $values )
  {

  }

  public function setWhereAttribute( $value )
  {
    $this->where[] = $value;
  }

  public function setCountAttribute( $count )
  {
    $this->count = $count . ',';

    return $this;
  }

  public function setAccuracyAttribute( $accuracy = null )
  {
    $conversion = array(
      'seconds' => '%Y-%m-%d %H:%i:%s',
      'minutes' => '%Y-%m-%d %H:%i',
      'hours'   => '%Y-%m-%d %H',
      'days'    => '%Y-%m-%d',
      'months'  => '%Y-%m',
      'years'   => '%Y',
    );

    if ( is_null( $accuracy ) ) {
      $this->accuracy = $conversion[ 'seconds' ];

      return $this;
    }

    // Check for keys
    if ( in_array( strtolower( $accuracy ), array_keys( $conversion ) ) ) {
      $this->accuracy = $conversion[ strtolower( $accuracy ) ];

      return $this;
    }

    // Check for values
    if ( in_array( $accuracy, array_values( $conversion ) ) ) {
      $this->accuracy = $accuracy;

      return $this;
    }

    $this->accuracy = current( $conversion );

    return $this;
  }

  public function setOrderByAttribute( $value )
  {
    $this->orderBy = $value;

    return $this;
  }

  public function setOrderAttribute( $value )
  {
    $this->order = $value;

    return $this;
  }

  public function setGroupByAttribute( $value )
  {
    $this->groupBy = $value;

    return $this;
  }

  public function setLimitAttribute( $value )
  {
    $this->limit = $value;

    return $this;
  }

  public function setDateFromAttribute( $value )
  {
    if ( is_numeric( $value ) ) {
      $value = date( 'Y-m-d H:i:s', $value );
    }
    $this->dateFrom = $value;

    return $this;
  }

  public function setDateToAttribute( $value )
  {
    if ( is_numeric( $value ) ) {
      $value = date( 'Y-m-d H:i:s', $value );
    }

    $this->dateTo = $value;

    return $this;
  }

  public function setDateIntervalFromAttribute( $value )
  {
    $this->dateIntervalFrom = $value;

    return $this;
  }

  public function setDateIntervalToAttribute( $value )
  {
    $this->dateIntervalTo = $value;

    return $this;
  }

  public function setCategoriesAttribute( $value )
  {
    if ( is_string( $value ) ) {
      $value = explode( ',', $value );
    }

    $this->categories = empty( $value ) ? [] : array_filter( $value );

    return $this;
  }

  public function setBannersAttribute( $value )
  {
    if ( is_string( $value ) ) {
      $value = explode( ',', $value );
    }
    $this->banners = $value;

    return $this;
  }
}