<?php

namespace Database\Migrations;

use Core\Database\Migration;

class CreateCustomersTable extends Migration
{

  public static function run()
  {
    self::db()->query('
      CREATE TABLE IF NOT EXISTS customers (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id BIGINT UNSIGNED NOT NULL,
        name VARCHAR(100) NOT NULL,
        cpf VARCHAR(11) UNIQUE NOT NULL,
        cnpj VARCHAR(15) UNIQUE NOT NULL,
        phone VARCHAR(20) NOT NULL,
        birth_date DATE NOT NULL,
        is_favorite TINYINT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
      )
    ');
  }
}
