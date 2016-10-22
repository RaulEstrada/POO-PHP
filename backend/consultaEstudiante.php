<?php

require_once("persistency/NotaDAO.php");
require_once("NotaNumerica.php");

class ConsultaEstudianteHandler {
  use NotaNumerica;

  public function handleRequest() {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
      $estudiante_id = null;
      if (array_key_exists("estudianteID", $_GET)) {
        $estudiante_id = $_GET["estudianteID"];
      }
      $nota_DAO = new NotaDAO();
      $notas = $nota_DAO->findByEstudiante($estudiante_id);
      $resultado = array(
        "datosAsignaturas" => $this->getDatosAsignaturas($notas),
        "notaMedia" => $this->getDatosMedia($notas),
        "datosNotasNumericas" => $this->getDatosLetra($notas),
        "datosCursoAcademico" => $this->getDatosPorCursoAcademico($notas)
      );
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

  function getDatosAsignaturas($notas) {
    $datos_asignaturas = array();
    foreach ($notas as $nota) {
      if ($nota["nota"] == "NP") {
        continue;
      }
      $curso = $nota["curso_id"];
      if (!array_key_exists($curso, $datos_asignaturas)) {
        $datos_asignaturas[$curso] = array("alumnos" => 0, "sumaNotas" => 0);
      }
      $datos_asignaturas[$curso]["alumnos"] += 1;
      $datos_asignaturas[$curso]["sumaNotas"] += $nota["nota"];
    }
    $resultado = array();
    foreach ($datos_asignaturas as $key => $value) {
      $resultado[$key] = $value["sumaNotas"]/$value["alumnos"];
    }
    return $resultado;
  }

  function getDatosMedia($notas) {
    $suma_notas = 0;
    $count_alumnos = 0;
    foreach ($notas as $nota) {
      if ($nota["nota"] !== "NP") {
        $suma_notas += $nota["nota"];
        $count_alumnos += 1;
      }
    }
    $resultado = 0;
    if ($count_alumnos != 0) {
      $resultado = $suma_notas / $count_alumnos;
    }
    return $resultado;
  }

  function getDatosLetra($notas) {
    $datos_asignaturas = array("Sobresaliente" => 0, "Notable" => 0, "Aprobado" => 0, "Suspenso" => 0, "NP" => 0);
    foreach ($notas as $nota) {
      if ($nota["nota"] == "NP") {
        $datos_asignaturas["NP"] += 1;
      } else {
        $nota_alfabetica = $this->getNotaAlfabetica($nota["nota"]);
        $datos_asignaturas[$nota_alfabetica] += 1;
      }
    }
    return $datos_asignaturas;
  }

  function getDatosPorCursoAcademico($notas) {
    $datos_curso = array();
    foreach ($notas as $nota) {
      if ($nota["nota"] == "NP") {
        continue;
      }
      $curso = $nota["curso"];
      if (!array_key_exists($curso, $datos_curso)) {
        $datos_curso[$curso] = array("sumaNotas" => 0, "alumnos" => 0);
      }
      $datos_curso[$curso]["sumaNotas"] += $nota["nota"];
      $datos_curso[$curso]["alumnos"] += 1;
    }
    $resultado = array();
    foreach ($datos_curso as $key => $value) {
      $resultado[$key] = $value["sumaNotas"]/$value["alumnos"];
    }
    return $resultado;
  }
}

$handler = new ConsultaEstudianteHandler();
$handler->handleRequest();

 ?>
