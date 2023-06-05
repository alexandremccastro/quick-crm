<?php

namespace Core\Database;

use PDOStatement;

class Model extends DB
{
  use Query;

  protected $primaryKey = 'id';
  protected $fields = [];


  public function execute(): PDOStatement
  {
    $sql = $this->getSql();
    $stmt = $this->db()->prepare($sql);
    $stmt->execute($this->getParams());
    $this->cleanQuery();
    return $stmt;
  }

  /**
   * Inserts one record in a table on database
   * 
   * @param $data The data of the record
   * 
   * @return string The inserted id of the record
   */
  public function insertOne(array $data): string
  {
    self::db()->beginTransaction();

    $fields = implode(',', $this->fields);

    $results = array_map(function ($field) {
      return ':' . $field;
    }, $this->fields);
    $params = implode(',', $results);

    $sql = "
      INSERT INTO 
      $this->table 
      ($fields) 
      VALUES ($params)";

    $stmt = self::db()->prepare($sql);
    $stmt->execute($data);
    $insertedId = self::db()->lastInsertId();
    self::db()->commit();

    return $insertedId;
  }

  /**
   * Finds a record in the database
   * 
   * @return object The object fetched from database
   */
  public function findOne(array $where)
  {
    self::db()->beginTransaction();

    [$field, $operator, $value] = $where;

    $sql = "
      SELECT * FROM 
      $this->table 
      WHERE $field $operator :$field LIMIT 1";

    $stmt = self::db()->prepare($sql);
    $stmt->execute([$field => $value]);
    self::db()->commit();

    return $stmt->fetchObject();
  }

  /**
   * Updates one record in the database
   * 
   * @param $id The id that will be updated
   * @param $data The data of the record
   * 
   * @return int The number of affected records
   */
  public function updateOne(string $id, array $data)
  {
    self::db()->beginTransaction();

    $results = array_map(function ($field) {
      return $field . '=:' . $field;
    }, array_keys($data));

    $params = implode(',', $results);

    $sql = "
      UPDATE $this->table 
      SET $params
      WHERE $this->primaryKey = $id LIMIT 1";

    $stmt = self::db()->prepare($sql);
    $stmt->execute($data);
    self::db()->commit();


    return $stmt->rowCount();
  }

  /**
   * Deletes one record on the database
   * 
   * @param $id The primary key of the record
   * 
   * @return int The number of affected records
   */
  public function deleteOne(mixed $id)
  {
    self::db()->beginTransaction();

    $sql = "
      DELETE FROM $this->table 
      WHERE $this->primaryKey = :$this->primaryKey LIMIT 1";

    $stmt = self::db()->prepare($sql);
    $stmt->execute([$this->primaryKey => $id]);
    self::db()->commit();

    return $stmt->rowCount();
  }
}
