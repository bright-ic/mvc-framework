<?php

declare(strict_types=1);

namespace Core\Models;

use Core\DB\connectionClass;
use Core\DB\DatabaseControllerClass;
use PDOException;

use Core\CoreInterface\BaseModelInterface;

class BaseModelClass implements BaseModelInterface
{
  private $db = null;
  private $dbController = null;

  public $dbTable;
  public $dbFields;
  public $PK = null;

  function __construct()
  {
    $this->getChildProperties();
  }

  public function getChildProperties()
  {
    $properties = get_object_vars($this);
    $this->dbFields = $properties['fields'] ? $properties['fields'] : [];
    $this->dbTable = $properties['tableName'] ? $properties['tableName'] : '';
    $this->PK = $properties['primaryKey'] ? $properties['primaryKey'] : 'id';
  }

  public function initDBConnection()
  {
    try {
      $conn = new connectionClass();
      $this->db = $conn->getDBConnection();
      $this->dbController = new DatabaseControllerClass($this->db);
      return $this->dbController;
    } catch (PDOException $ex) {
      $this->dbController = null;
      $this->db = null;
      return $this->dbController;
    }
  }



  public function getConnection()
  {
    return $this->db;
  }

  public function getDBController()
  {
    return $this->dbController;
  }


  public function create(array $dbData)
  {
    $response = '';
    $this->getChildProperties(); // execute this update, etc.
    $table = $this->dbTable;
    $fields = $this->dbFields;
    if (count(array_keys($dbData)) > 0 && count($fields) > 0 && $table != "") {

      $dbController = $this->initDBConnection();
      if ($dbController) {
        $response = $dbController->insert($table, $fields, $dbData, $this->PK);
      } else {
        $response = "failed to connect to db";
      }
    }

    return $response;
  }
}
