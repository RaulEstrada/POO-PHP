<?php

require_once("persistency/NotaDAO.php");
require_once("NotaNumerica.php");

class ConsultaAsignaturaHandler {
  use NotaNumerica;

  public function handleRequest() {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
      $asignatura = null;
      if (array_key_exists("asignaturaID", $_GET)) {
        $asignatura = $_GET["asignaturaID"];
      }
      $notaDAO = new NotaDAO();
      $notas = $notaDAO->findByAsignatura($asignatura);
      $result = array(
        "datosCursosMedia" => $this->getDatosPorCurso($notas),
        "cursosNotasAlfabeticas" => $this->getNotasAlfabeticas($notas)
      );
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

  function getDatosPorCurso($notas) {
    $datos_cursos = array();
    foreach ($notas as $nota) {
      if ($nota["nota"] == "NP") {
        continue;
      }
      $curso = $nota["curso"];
      if (!array_key_exists($curso, $datos_cursos)) {
        $datos_cursos[$curso] = array();
      }
      $convocatoria = $nota["convocatoria"];
      if (!array_key_exists($convocatoria, $datos_cursos[$curso])) {
        $datos_cursos[$curso][$convocatoria] = array("alumnos" => 0, "sumaNotas" => 0);
      }
      $datos_cursos[$curso][$convocatoria]["alumnos"] += 1;
      $datos_cursos[$curso][$convocatoria]["sumaNotas"] += $nota["nota"];
    }
    $resultado = array();
    foreach ($datos_cursos as $key_curso => $value_curso) {
      $resultado[$key_curso] = array();
      foreach ($value_curso as $key_convocatoria => $value_convocatoria) {
        $resultado[$key_curso][$key_convocatoria] = $value_convocatoria["sumaNotas"]/$value_convocatoria["alumnos"];
      }
    }
    return $resultado;
  }

  function getNotasAlfabeticas($notas) {
    $datos_cursos = array();
    foreach ($notas as $nota) {
      $curso = $nota["curso"];
      if (!array_key_exists($curso, $datos_cursos)) {
        $datos_cursos[$curso] = array();
      }
      $nota = $nota["nota"];
      if ($nota !== "NP") {
        $nota = $this->getNotaAlfabetica($nota);
      }
      if (!array_key_exists($nota, $datos_cursos[$curso])) {
        $datos_cursos[$curso][$nota] = array("count" => 0);
      }
      $datos_cursos[$curso][$nota]["count"] += 1;
    }
    $resultado = array();
    foreach ($datos_cursos as $key_curso => $value_curso) {
      $resultado[$key_curso] = array();
      foreach ($value_curso as $key_nota => $value_nota) {
        $resultado[$key_curso][$key_nota] = $value_nota["count"];
      }
    }
    return $resultado;
  }
}

$handler = new ConsultaAsignaturaHandler();
$handler->handleRequest();

 ?>
