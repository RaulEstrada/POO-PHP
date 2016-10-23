<?php

require_once("persistency/NotaDAO.php");
require_once("NotaNumerica.php");
require_once("EstudianteStats.php");

class ConsultaEstudianteHandler {

  public function handleRequest() {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
      $stats = new EstudianteStats();
      $estudiante_id = null;
      if (array_key_exists("estudianteID", $_GET)) {
        $estudiante_id = $_GET["estudianteID"];
      }
      $resultado = $stats->getStats($estudiante_id);
      header("HTTP/1.1 200 OK");
      header('Content-Type: application/json');
      print(json_encode($resultado));
    } else {
      header("HTTP/1.1 400 Bad Request");
      header('Content-Type: application/json');
      print(json_encode(array("message"=> "Método HTTP no permitido")));
    }
    exit();
  }


}

$handler = new ConsultaEstudianteHandler();
$handler->handleRequest();

 ?>
