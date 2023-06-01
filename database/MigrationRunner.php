<?php

namespace Database;

use Database\Migrations\CreateUsersTable;
use Database\Migrations\CreateCustomersTable;
use Database\Migrations\CreateAddressTable;

abstract class MigrationRunner
{
  public static function execute()
  {
    CreateUsersTable::run();
    CreateCustomersTable::run();
    CreateAddressTable::run();
  }
}
