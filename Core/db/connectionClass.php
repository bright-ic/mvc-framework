<?php

declare(strict_types=1);

namespace Core\DB;

require_once ROOT_URL . "/config/database.php";

use PDO;

class connectionClass
{
  public $db;

  function __construct()
  {
    $databaseConfig = array(
      "driver" => "mysql",
      "host" => "localhost",
      "database" => "mvc_framework",
      "username" => "root",
      "password" => ""
    );

    $dns = $databaseConfig['driver']
      . ":host=" . $databaseConfig['host']
      . ";dbname=" . $databaseConfig['database']
      . ";charset=utf8mb4";

    $this->db = new PDO($dns, $databaseConfig["username"], $databaseConfig["password"]);

    /* $this->db = new PDO(
      \Config\Database\dns,
      \Config\Database\databaseConfig["username"],
      \Config\Database\databaseConfig["password"]
    ); */

    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  }

  public function getDBConnection()
  {
    return  $this->db;
  }
}
