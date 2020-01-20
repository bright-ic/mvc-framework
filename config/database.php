<?php

declare(strict_types=1);

namespace Config\Database;

$databaseConfig = array(
  "driver" => "mysql",
  "host" => "localhost",
  "database" => "dbname",
  "username" => "root",
  "password" => ""
);

$dns = $databaseConfig['driver']
  . ":host=" . $databaseConfig['host']
  . ";database=" . $databaseConfig['database']
  . ";charset=utf8mb4";
