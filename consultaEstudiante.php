<?php

require_once("NotaDAO.php");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  $estudiante_id = $_GET["estudiante"];
  $notaDAO = new NotaDAO();
  $notas = $notaDAO->findByEstudiante($estudiante_id);
  echo json_encode($notas);
} else {
  header("HTTP/1.1 400 Bad Request");
  print("Método HTTP no permitido");
  exit();
}

 ?>
