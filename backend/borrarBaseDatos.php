<?php

require_once("persistency/DatabaseCleaner.php");

class BorrarBaseDatosHandler {
  static function handleRequest() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $databaseCleaner = new DatabaseCleaner();
      $databaseCleaner->clean();
      header("HTTP/1.1 200 OK");
      header('Content-Type: application/json');
      print(json_encode(array("message"=> "Reset realizado correctamente")));
    } else {
      header("HTTP/1.1 400 Bad Request");
      header('Content-Type: application/json');
      print(json_encode(array("message"=> "Método HTTP no permitido")));
    }
    exit();
  }
}

BorrarBaseDatosHandler::handleRequest();

 ?>
