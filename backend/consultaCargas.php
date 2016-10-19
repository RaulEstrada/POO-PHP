<?php

require_once("persistency/CursoDAO.php");
require_once("persistency/EstudianteDAO.php");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  $cursoDAO = new CursoDAO();
  $cursos = $cursoDAO->findAll();
  $estudianteDAO = new EstudianteDAO();
  $estudiantes = $estudianteDAO->findAll();
  $result = array("cursos" => $cursos, "estudiantes" => $estudiantes);
  echo json_encode($result);
} else {
  header("HTTP/1.1 400 Bad Request");
  print("Método HTTP no permitido");
  exit();
}

 ?>
