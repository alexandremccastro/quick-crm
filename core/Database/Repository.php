<?php

namespace Core\Database;

use PDO;

abstract class Repository
{
  public function __construct(private Model $model)
  {
  }

  public function insertOne(array $data): mixed
  {
    return $this->model->insert(array_keys($data))
      ->values($data)->execute()->rowCount();
  }

  public function findOne(string $key, string $condition, string $value)
  {
    return $this->model->select()->where($key, $condition, $value)
      ->limit(1)->execute()->fetch(PDO::FETCH_ASSOC);
  }

  public function findMany(string $key, string $condition, string $value)
  {
    return $this->model->where($key, $condition, $value)
      ->execute()->fetchAll(PDO::FETCH_ASSOC);
  }


  public function deleteOne(string $key, string $condition, string $value)
  {
    return $this->model->where($key, $condition, $value)
      ->execute()->rowCount();
  }
  public function updateOne($id, array $data)
  {
    return $this->model->update($data)->where($this->model->primaryKey, '=', $id)
      ->execute()->rowCount();
  }
}
