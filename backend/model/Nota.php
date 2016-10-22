<?php

require_once("exceptions/NotaInvalidaException.php");

  class Nota {
    private $convocatoria, $nota, $curso, $estudiante;

    function __construct($convocatoria, $nota, $curso, $estudiante) {
      if ((!is_numeric($nota) && $nota !== "NP") || (is_numeric($nota) && ($nota<0 || $nota>10))) {
        throw new NotaInvalidaException($nota, $estudiante);
      }
      $this->convocatoria = $convocatoria;
      $this->nota = $nota;
      $this->curso = $curso;
      $this->estudiante = $estudiante;
    }

    function getConvocatoria() {
      return $this->convocatoria;
    }

    function getNota() {
      return $this->nota;
    }

    function getCurso() {
      return $this->curso;
    }

    function getEstudiante() {
      return $this->estudiante;
    }

    function toString() {
      return "Convocatoria " . $this->convocatoria . ". Nota: " . $this->nota;
    }
  }

 ?>
