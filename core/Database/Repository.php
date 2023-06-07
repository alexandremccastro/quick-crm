<?php

namespace Core\Database;

use PDO;

abstract class Repository
{
  public function __construct(private Model $model)
  {
  }

  public abstract function paginate(array $data, $page = 0);

  public function insertOne(array $data): string
  {
    $this->model->insert(array_keys($data))
      ->values($data)->execute();

    return $this->model->lastInsertId();
  }

  public function where(string $key, string $condition, string $value)
  {
    return $this->model->select()->where($key, $condition, $value);
  }

  public function findOne(string $key, string $condition, string $value)
  {
    return $this->model->select()->where($key, $condition, $value)
      ->limit(1)->execute()->fetch(PDO::FETCH_ASSOC);
  }

  public function findMany(string $key, string $condition, string $value)
  {
    return $this->model->select()->where($key, $condition, $value)
      ->execute()->fetchAll(PDO::FETCH_ASSOC);
  }

  public function deleteOne(string $key, string $condition, string $value)
  {
    return $this->model->delete()->where($key, $condition, $value)
      ->limit(1)->execute()->rowCount();
  }
  public function updateOne($id, array $data)
  {
    return $this->model->update($data)->where($this->model->getPrimaryKey(), '=', $id)
      ->limit(1)->execute()->rowCount();
  }

  public function update(array $values)
  {
    return $this->model->update($values);
  }


  public function delete()
  {
    return $this->model->delete();
  }

  public function select(array $keys = ['*'])
  {
    return $this->model->select($keys);
  }
}
