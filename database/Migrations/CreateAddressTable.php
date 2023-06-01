<?php

namespace Database\Migrations;

use Core\Database\Migration;

class CreateAddressTable extends Migration
{

  public static function run()
  {
    self::getInstance()->query('
      CREATE TABLE IF NOT EXISTS address (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        customer_id BIGINT UNSIGNED NOT NULL,
        street VARCHAR(100) NOT NULL,
        number VARCHAR(20) DEFAULT NULL,
        city VARCHAR(100) NOT NULL,
        state VARCHAR(100) NOT NULL,
        zip_code VARCHAR(10) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE CASCADE
      )
    ');
  }
}
