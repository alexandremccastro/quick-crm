<?php

namespace Core\Database;

trait Query
{
  protected $table = '';

  protected $params = [];

  private $sql = [
    'SELECT' => null,
    'INSERT' => null,
    'UPDATE' => null,
    'DELETE' => null,
    'VALUES' => [],
    'WHERE' => [],
    'LIMIT' => null,
    'OFFSET' => null,
  ];

  public function cleanQuery()
  {
    foreach ($this->sql as $key => $value) {
      if (is_string($value)) $this->sql[$key] = null;
      else if (is_array($value)) $this->sql[$key] = [];
    }
  }


  public function select(array $keys = ['*'])
  {
    $params = implode(', ', $keys);
    $this->sql['SELECT'] = "SELECT $params FROM $this->table";
    return $this;
  }

  public function insert(array $keys)
  {
    $params = implode(', ', $keys);
    $this->sql['INSERT'] = "INSERT INTO $this->table ($params)";
    return $this;
  }

  public function update(array $values)
  {
    $sets = [];

    foreach ($values as $key => $value) {
      $this->params[] = $value;
      $sets[] = implode(' = ', [$key, "?"]);
    }

    $fields = implode(', ', $sets);
    $this->sql['UPDATE'] = "UPDATE $this->table SET $fields";

    return $this;
  }

  public function delete()
  {
    $this->sql['DELETE'] = "DELETE FROM $this->table";
    return $this;
  }

  public function values(array $values)
  {
    $names = [];

    foreach ($values as $value) {
      $this->params[] = $value;
      $names[] = '?';
    }

    if (!in_array('VALUES', $this->sql['VALUES']))
      $this->sql['VALUES'][] = 'VALUES';

    if (count($this->sql['VALUES']) > 1) $this->sql['VALUES'][] = ', ';

    $values = implode(', ', $names);
    $this->sql['VALUES'][] = "($values)";
    return $this;
  }

  public function where($key, $condition, $value)
  {
    $this->params[] = $value;

    if (!in_array('WHERE', $this->sql['WHERE']))
      $this->sql['WHERE'][] = 'WHERE';

    $this->sql['WHERE'][] = "$key $condition ?";
    return $this;
  }

  public function andWhere($key, $condition, $value)
  {
    $this->sql['WHERE'][] = 'AND';
    $this->where($key, $condition, $value);
    return $this;
  }

  public function orWhere($key, $condition, $value)
  {
    $this->sql['WHERE'][] = 'OR';
    $this->where($key, $condition, $value);
    return $this;
  }

  public function offset(int $offset)
  {
    $this->sql['OFFSET'] = "OFFSET $offset";
    return $this;
  }

  public function limit(int $limit)
  {
    $this->sql['LIMIT'] = "LIMIT $limit";
    return $this;
  }

  public function getSql()
  {
    $output = [];

    foreach ($this->sql as $value) {
      if (is_string($value) && !empty($value))
        $output[] = $value;
      else if (is_array($value) && count($value)) {
        $output[] = implode(' ', $value);
      }
    }
    return implode(' ', $output);
  }

  public function getParams()
  {
    return $this->params;
  }
}
