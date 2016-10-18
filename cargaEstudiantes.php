<?php

require_once("model/Estudiante.php");
require_once("EstudianteDAO.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $file_contents = file_get_contents($_FILES["ficheroEstudiantes"]["tmp_name"]);
  $json_contents = json_decode($file_contents, true);
  $personas = $json_contents["personas"];
  $estudianteDAO = new EstudianteDAO();
  foreach ($personas as $persona) {
    $estudianteID = $persona["id"];
    $estudiante = new Estudiante($estudianteID, $persona["nombre"], $persona["apellidos"],
      $persona["fechaNacimiento"], $persona["genero"]);
    $estudianteDAO->addEstudiante($estudiante);
  }
} else {
  header("HTTP/1.1 400 Bad Request");
  print("Método HTTP no permitido");
  exit();
}

 ?>
