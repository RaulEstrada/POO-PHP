<?php

class CursoRepetidoException extends Exception {
  private $curso, $curso_id;

  public function __construct($curso, $curso_id, $convocatoria) {
    $this->curso = $curso;
    $this->curso_id = $curso_id;
    $this->convocatoria = $convocatoria;
  }

  public function getJSON() {
    return array("curso"=> $this->curso, "curso_id" => $this->curso_id, "convocatoria" => $this->convocatoria);
  }
}

 ?>
