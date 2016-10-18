<?php

  class DBConnector {
    const DB_SERVER_NAME = "localhost";
    const DB_USERNAME = "root";
    const DB_PASSWORD = "secret";
    const DB_NAME = "POO_PHP";

    function createConnection() {
      $conexion = new PDO("mysql:host=" . DBConnector::DB_SERVER_NAME . ";dbname=" . DBConnector::DB_NAME,
        DBConnector::DB_USERNAME, DBConnector::DB_PASSWORD);
      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      ini_set('max_execution_time', 300);
      return $conexion;
    }
  }

 ?>
