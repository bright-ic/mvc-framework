<?php

declare(strict_types=1);

namespace Core\DB;

use Core\CoreInterface\DatabaseInterface;
use PDO;
use PDOException;

class DatabaseControllerClass implements DatabaseControllerInterface
{
  public $db;
  function __construct($db)
  {
    $this->db = $db;
  }

  public function insert($table, $filedsArr, array $data, $pk = null)
  {
    $fields = "";
    $fieldPlaceHolders = "";
    $lastInstertId = '';

    if (is_array($data)) {
      if (count($data) > 0) {
        foreach ($data as $key => $value) {
          if (in_array($key, $filedsArr)) {
            $fields .= "," . $key;
            $fieldPlaceHolders .= ", :" . $key;
            $data[':' . $key] = $value;
          }
          unset($data[$key]);
        }
        // remove initial comma's
        $fieldPlaceHolders = substr($fieldPlaceHolders, 1);
        $fields = substr($fields, 1);

        try {
          $sql = "insert into $table($fields) values($fieldPlaceHolders)";
          $stmt = $this->db->prepare($sql);
          $stmt->execute($data);
          $lastInstertId = $this->db->lastInsertId();
          $data['lastInsertedId'] = $lastInstertId;
        } catch (PDOException $ex) {
          return $ex->getMessage();
        }
        // fetch last inserted data
        try {
          if ($pk) {
            $newData = $this->fetchLastInserted($table, $pk, $lastInstertId);
            $newData = $newData ? $newData : $data;
          } else {
            $newData = $data;
          }
          return $newData;
        } catch (PDOException $ex) {
          $newData = $data;
          return $newData;
        }
      }
    }
    return null;
  }

  public function update($table, $fileds, $data, $condition)
  {
    /* $fields = implode(',', $filedsArr);
    $fieldPlaceHolders = str_replace(",", ",:", $fields);
    $fieldPlaceHolders = ":" . $fieldPlaceHolders;
    //$fieldPlaceHolders = substr($fieldPlaceHolders, 1);
    if (is_array($data)) {
      if (count($data) > 0) {
        $sql = "insert into $table($fields) values($fieldPlaceHolders)";
        $stmt = $this->db->prepare($sql);
        foreach ($filedsArr as $field) {
          $value =  $data[$field] ? $data[$field] : "";
          $stmt->bindValue(":" . $field, $value);
        }
        $stmt->execute();
      }
    }
    */
  }
  public function query($sql, array $data = [])
  {
    $stmt = $this->db->prepare($sql);
    if (count($data)) {
      $stmt->execute($data);
    } else {
      $stmt->execute();
    }
    return $stmt;
  }

  public function delete($table, $condition, $data)
  {
  }


  public function select($table, $filedsArr, $condition, array $data = [])
  {
    $fields = implode(',', $filedsArr);
    $isData = false;
    if (count($data) > 0) {
      $isData = true;

      foreach ($data as $key => $value) {
        if (in_array($key, $filedsArr)) {
          $data[':' . $key] = $value;
        }
        unset($data[$key]);
      }
    }

    $condition =  strlen($condition) > 0 ? $condition : '';
    $sql = "select $fields from $table $condition";
    $stmt = $this->db->prepare($sql);

    $isData ? $stmt->execute($data) : $stmt->execute();
    return $stmt;
  }

  public function fetchLastInserted(string $table, $pk, $value)
  {
    if ($table !== "") {
      if ($pk) {
        $sql = "select *from $table where $pk=:$pk order by $pk desc limit 1";
        try {
          $stmt = $this->db->prepare($sql);
          $stmt->execute(array(":$pk" => $value));
          $result = $stmt->fetch(\PDO::FETCH_ASSOC);
          return $result;
        } catch (PDOException $ex) {
          return null;
        }
      }
    }
    return null;
  }
}
