<?php

require_once("DBConnector.php");

class EstudianteDAO extends DBConnector {
  function addEstudiante($estudiante) {
    try {
      $sql = "INSERT INTO estudiante (id, nombre, apellidos, fecha_nacimiento, genero) VALUES ('"
        . $estudiante->getId() . "', '" . $estudiante->getNombre() . "', '" . $estudiante->getApellidos()
        . "', '" . $estudiante->getFechaNacimiento() . "', '" . $estudiante->getGenero() . "')";
      $conexion = $this->createConnection();
      $conexion->exec($sql);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
  }

  function deleteAll() {
    try {
      $sql = "DELETE FROM estudiante";
      $conexion = $this->createConnection();
      $conexion->exec($sql);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
  }
}

 ?>
