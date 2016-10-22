<?php

require_once("persistency/NotaDAO.php");
require_once("NotaNumerica.php");

class ConsultaCursoHandler {
  use NotaNumerica;

  public function handleRequest() {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
      $curso = null;
      if (array_key_exists("cursoAcademico", $_GET)) {
        $curso = $_GET["cursoAcademico"];
      }
      $notaDAO = new NotaDAO();
      $notas = $notaDAO->findByCurso($curso);
      $result = array(
        "datosConvocatorias" => $this->getDatosPorConvocatoria($notas),
        "notaMedia" => $this->getDatosMedia($notas),
        "datosGenero" => $this->getDatosPorGenero($notas)
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

  function getDatosPorConvocatoria($notas) {
    $datos_convocatorias = array();
    foreach ($notas as $nota) {
      if ($nota["nota"] == "NP") {
        continue;
      }
      $convocatoria = $nota["convocatoria"];
      if (!array_key_exists($convocatoria, $datos_convocatorias)) {
        $datos_convocatorias[$convocatoria] = array("alumnos" => 0, "sumaNotas" => 0);
      }
      $datos_convocatorias[$convocatoria]["alumnos"] += 1;
      $datos_convocatorias[$convocatoria]["sumaNotas"] += $nota["nota"];
    }
    $resultado = array();
    foreach ($datos_convocatorias as $key => $value) {
      $resultado[$key] = $value["sumaNotas"]/$value["alumnos"];
    }
    return $resultado;
  }

  function getDatosPorGenero($notas) {
    $datos_genero = array("Hombre"=> array("count"=> 0, "suma"=> 0), "Mujer"=> array("count"=> 0, "suma"=> 0));
    foreach ($notas as $nota) {
      if ($nota["nota"] == "NP") {
        continue;
      }
      $datos_genero[$nota["genero"]]["count"] += 1;
      $datos_genero[$nota["genero"]]["suma"] += $nota["nota"];
    }
    $resultado = array();
    foreach ($datos_genero as $key => $value) {
      $resultado[$key] = $value["count"] != 0 ? $value["suma"]/$value["count"] : 0;
    }
    return $resultado;
  }
}

$handler = new ConsultaCursoHandler();
$handler->handleRequest();

 ?>
