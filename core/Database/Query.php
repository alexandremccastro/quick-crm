<?php

namespace Core\Database;

trait Query
{
  protected $table = '';

  protected $params = [];

  protected $sql = [
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
    $this->params = [];

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

  public function where(string $key, string $condition, string $value)
  {
    $this->params[] = $value;

    if (!in_array('WHERE', $this->sql['WHERE']))
      $this->sql['WHERE'][] = 'WHERE';

    $this->sql['WHERE'][] = "$key $condition ?";
    return $this;
  }

  public function andWhere(string $key, string $condition, string  $value)
  {
    $this->sql['WHERE'][] = 'AND';
    $this->where($key, $condition, $value);
    return $this;
  }

  public function orWhere(string $key, string $condition, string $value)
  {
    $this->sql['WHERE'][] = 'OR';
    $this->where($key, $condition, $value);
    return $this;
  }

  public function orIn(string $key, array $values)
  {
    if (count($values) > 0) {
      $items = [];

      foreach ($values as $value) {
        $this->params[] = $value;
        $items[] = '?';
      }

      if (!in_array('WHERE', $this->sql['WHERE']))
        $this->sql['WHERE'][] = 'WHERE';
      else
        $this->sql['WHERE'][] = 'OR';

      $params = implode(', ', $items);

      $this->sql['WHERE'][] = "$key IN ($params)";
    }

    return $this;
  }

  public function andIn(string $key, array $values)
  {
    if (count($values)) {
      $items = [];

      foreach ($values as $value) {
        $this->params[] = $value;
        $items[] = '?';
      }

      if (!in_array('WHERE', $this->sql['WHERE']))
        $this->sql['WHERE'][] = 'WHERE';
      else
        $this->sql['WHERE'][] = 'AND';

      $params = implode(', ', $items);

      $this->sql['WHERE'][] = "$key IN ($params)";
    }

    return $this;
  }

  public function orNotIn(string $key, array $values)
  {
    if (count($values)) {
      $items = [];

      foreach ($values as $value) {
        $this->params[] = $value;
        $items[] = '?';
      }

      if (!in_array('WHERE', $this->sql['WHERE']))
        $this->sql['WHERE'][] = 'WHERE';
      else
        $this->sql['WHERE'][] = 'OR';

      $params = implode(', ', $items);

      $this->sql['WHERE'][] = "$key NOT IN ($params)";
    }

    return $this;
  }

  public function andNotIn(string $key, array $values)
  {
    if (count($values) > 0) {
      $items = [];

      foreach ($values as $value) {
        $this->params[] = $value;
        $items[] = '?';
      }

      if (!in_array('WHERE', $this->sql['WHERE']))
        $this->sql['WHERE'][] = 'WHERE';
      else
        $this->sql['WHERE'][] = 'AND';

      $params = implode(', ', $items);

      $this->sql['WHERE'][] = "$key NOT IN ($params)";
    }

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

  public function getParams(): array
  {
    return $this->params;
  }
}
