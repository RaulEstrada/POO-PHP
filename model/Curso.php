<?php

  class Curso {
    private $id, $curso;

    function __construct($id, $curso) {
      $this->id = $id;
      $this->curso = $curso;
    }

    function getId() {
      return $this->id;
    }

    function getCurso() {
      return $this->curso;
    }

    function toString() {
      return "Curso: " . $this->id . " " . $this->curso;
    }
  }

 ?>
