<?php

namespace Core\Database;

use Core\Database\DB;

abstract class Migration extends DB
{

  /**
   * This method will be implemented by all subclasses
   */
  abstract static public function run();
}
