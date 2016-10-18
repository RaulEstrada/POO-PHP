<?php

  class Estudiante {
    private $id, $nombre, $apellidos, $fecha_nacimiento, $genero;

    function __construct($id, $nombre, $apellidos, $fecha_nacimiento, $genero) {
      $this->id = $id;
      $this->nombre = $nombre;
      $this->apellidos = $apellidos;
      $this->fecha_nacimiento = $fecha_nacimiento;
      $this->genero = $genero;
    }

    function getId() {
      return $this->id;
    }

    function getNombre() {
      return $this->nombre;
    }

    function getApellidos() {
      return $this->apellidos;
    }

    function getFechaNacimiento() {
      return $this->fecha_nacimiento;
    }

    function getGenero() {
      return $this->genero;
    }

    function toString() {
      return "Estudiante: " . $this->id . ". " . $this->nombre . " " . $this->apellidos . ". Fecha de nacimiento: " . $this->fecha_nacimiento;
    }
  }

 ?>
