<?php

require_once("persistency/NotaDAO.php");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  $curso_id = $_GET["curso"];
  $notaDAO = new NotaDAO();
  $notas = $notaDAO->findByCurso($curso_id);
  echo json_encode($notas);
} else {
  header("HTTP/1.1 400 Bad Request");
  print("Método HTTP no permitido");
  exit();
}

 ?>
