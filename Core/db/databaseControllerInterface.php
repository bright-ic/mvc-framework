<?php

declare(strict_types=1);

namespace Core\DB;

interface DatabaseControllerInterface
{

  public function insert($table, $fileds, array $data, $pk = null);
  public function delete($table, $condition, $data);
  public function update($table, $fileds, $data, $condition);
  public function select($table, $filedsArr, $condition, array $data = []);
  public function query($sql, array $data = []);
  public function fetchLastInserted(string $table, $pk, $value);
}
