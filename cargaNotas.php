<?php

require_once("model/Curso.php");
require_once("model/Nota.php");
require_once("CursoDAO.php");
require_once("NotaDAO.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $file_contents = file_get_contents($_FILES["ficheroNotas"]["tmp_name"]);
  $convocatoriaJSON = json_decode($file_contents, true);
  $curso = new Curso($convocatoriaJSON["id"], $convocatoriaJSON["curso"]);
  $notasJSON = $convocatoriaJSON["notas"];
  $numero_convocatoria = $convocatoriaJSON["convocatoria"];
  $cursoDAO = new CursoDAO();
  $cursoDB = $cursoDAO->findCurso($curso->getId());
  $cursoExiste = !empty($cursoDB);
  if ($cursoExiste) {
    header("HTTP/1.1 400 Bad Request");
    print("El curso " . $curso->getId() . " ya existe en la base de datos");
    exit();
  }
  $cursoDAO->addCurso($curso);
  $notaDAO = new NotaDAO();
  foreach ($notasJSON as $notaJSON) {
    $nota = new Nota($numero_convocatoria, $notaJSON["valor"], $curso->getId(), $notaJSON["id"]);
    $notaDAO->addNota($nota);
  }
} else {
  header("HTTP/1.1 400 Bad Request");
  print("Método HTTP no permitido");
  exit();
}

 ?>
