<?php

  trait DBConnector {

    function createConnection() {
      $DB_SERVER_NAME = "localhost";
      $DB_USERNAME = "root";
      $DB_PASSWORD = "secret";
      $DB_NAME = "POO_PHP";
      $conexion = new PDO("mysql:host=" . $DB_SERVER_NAME . ";dbname=" . $DB_NAME,
        $DB_USERNAME, $DB_PASSWORD);
      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      ini_set('max_execution_time', 300);
      return $conexion;
    }
  }

 ?>
