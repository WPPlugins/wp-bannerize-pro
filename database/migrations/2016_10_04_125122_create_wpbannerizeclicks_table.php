<?php

use WPBannerize\WPBones\Database\Migrations\Migration;

class WPBannerizeClicks extends Migration
{

  public function up()
  {
    $this->create( "CREATE TABLE {$this->tablename} (
      id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      banner_id bigint(20) unsigned NOT NULL,
      date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      referrer text NOT NULL,
      ip varchar(255) NOT NULL DEFAULT '',
      user_agent text NOT NULL,
      PRIMARY KEY (id)
    ) {$this->charsetCollate};" );
  }

}