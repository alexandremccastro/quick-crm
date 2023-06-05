<?php

namespace Core\Database;

use PDO;
use PDOStatement;

class Model extends DB
{
  use Query;

  protected $primaryKey = 'id';
  protected $fields = [];

  public function getPrimaryKey()
  {
    return $this->primaryKey;
  }

  public function execute()
  {
    $sql = $this->getSql();
    $stmt = $this->db()->prepare($sql);
    $stmt->execute($this->getParams());
    $this->cleanQuery();
    return $stmt;
  }

  public function lastInsertId()
  {
    return $this->db()->lastInsertId();
  }
}
