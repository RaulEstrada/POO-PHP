<?php

class NotaRepetidaException extends Exception {
  private $nota, $estudiante, $curso, $convocatoria;
  public function __construct($nota, $estudiante, $curso, $convocatoria) {
    $this->nota = $nota;
    $this->estudiante = $estudiante;
    $this->curso = $curso;
    $this->convocatoria = $convocatoria;
  }

  public function getJSON() {
    return array("nota"=> $this->nota, "estudiante"=> $this->estudiante ,
      "curso"=>$this->curso, "convocatoria"=>$this->convocatoria);
  }
}

 ?>
