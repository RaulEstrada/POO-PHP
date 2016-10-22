<?php

require_once("model/Estudiante.php");
require_once("persistency/EstudianteDAO.php");

class EstudianteHandler {
  static function handleRequest() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $personas = EstudianteHandler::getPersonas();
      $estudianteDAO = new EstudianteDAO();
      $errors = [];
      foreach ($personas as $persona) {
        $estudianteID = $persona["id"];
        $estudiante = new Estudiante($estudianteID, $persona["nombre"], $persona["apellidos"],
          $persona["fechaNacimiento"], $persona["genero"]);
        try {
          $estudianteDAO->addEstudiante($estudiante);
        } catch (PDOException $e) {
          if ($e->getCode() === "23000") {
            $errors[] = $estudiante->getId();
          }
        }
      }
      header("HTTP/1.1 200 OK");
      header('Content-Type: application/json');
      print(json_encode($errors));
    } else {
      header("HTTP/1.1 400 Bad Request");
      print("Método HTTP no permitido");
    }
    exit();
  }

  static function getPersonas() {
    $file_contents = file_get_contents($_FILES["ficheroEstudiantes"]["tmp_name"]);
    $json_contents = json_decode($file_contents, true);
    $personas = $json_contents["personas"];
    return $personas;
  }
}

EstudianteHandler::handleRequest();

 ?>
