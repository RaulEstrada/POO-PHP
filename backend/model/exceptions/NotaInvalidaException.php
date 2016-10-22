<?php

class NotaInvalidaException extends Exception {
  private $nota, $estudiante;
  public function __construct($nota, $estudiante) {
    $this->nota = $nota;
    $this->estudiante = $estudiante;
  }

  public function getJSON() {
    return array("nota"=> $this->nota, "estudiante"=> $this->estudiante);
  }
}

 ?>
