<?php

require_once("persistency/NotaDAO.php");
require_once("NotaNumerica.php");
require_once("persistency/NotaDAO.php");

class EstudianteStats {
  use NotaNumerica;

  public function getStats($estudiante_id) {
    $nota_DAO = new NotaDAO();
    $notas = $nota_DAO->findByEstudiante($estudiante_id);
    $resultado = array(
      "datosAsignaturas" => $this->getDatosAsignaturas($notas),
      "notaMedia" => $this->getDatosMedia($notas),
      "datosNotasNumericas" => $this->getDatosLetra($notas),
      "datosCursoAcademico" => $this->getDatosPorCursoAcademico($notas)
    );
    return $resultado;
  }

  public function getDatosAsignaturas($notas) {
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

  public function getDatosLetra($notas) {
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

  public function getDatosPorCursoAcademico($notas) {
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

 ?>
