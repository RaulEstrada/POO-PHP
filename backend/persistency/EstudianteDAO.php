<?php

require_once("DBConnector.php");

class EstudianteDAO {
  use DBConnector;

  function addEstudiante($estudiante) {
    $sql = "INSERT INTO estudiante (id, nombre, apellidos, fecha_nacimiento, genero) VALUES ('"
      . $estudiante->getId() . "', '" . $estudiante->getNombre() . "', '" . $estudiante->getApellidos()
      . "', '" . $estudiante->getFechaNacimiento() . "', '" . $estudiante->getGenero() . "')";
    $conexion = $this->createConnection();
    $conexion->exec($sql);
  }

  function findAll() {
    $sql = "SELECT * FROM estudiante";
    $conexion = $this->createConnection();
    $statement = $conexion->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();
  }

  function deleteAll() {
    $sql = "DELETE FROM estudiante";
    $conexion = $this->createConnection();
    $conexion->exec($sql);
  }
}

 ?>
