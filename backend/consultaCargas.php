<?php

require_once("persistency/CursoDAO.php");
require_once("persistency/EstudianteDAO.php");

class ConsultaCargasHandler {
  static function handleRequest() {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
      $cursoDAO = new CursoDAO();
      $cursos = $cursoDAO->findAll();
      $estudianteDAO = new EstudianteDAO();
      $estudiantes = $estudianteDAO->findAll();
      $result = array("cursos" => $cursos, "estudiantes" => $estudiantes);
      header("HTTP/1.1 200 OK");
      header('Content-Type: application/json');
      print(json_encode($result));
    } else {
      header("HTTP/1.1 400 Bad Request");
      header('Content-Type: application/json');
      print(json_encode(array("message"=> "Método HTTP no permitido")));
    }
    exit();
  }
}

ConsultaCargasHandler::handleRequest();

?>
