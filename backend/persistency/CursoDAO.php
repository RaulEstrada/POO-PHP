<?php

require_once("DBConnector.php");

  class CursoDAO {
    use DBConnector;

    function addCurso($curso) {
      $sql = "INSERT INTO curso (id, curso) VALUES ('"
        . $curso->getId() . "', '" . $curso->getCurso() . "')";
      $conexion = $this->createConnection();
      $conexion->exec($sql);
    }

    function findCurso($idCurso, $curso) {
      $sql = "SELECT * FROM curso WHERE id = '" . $idCurso . "' AND curso = '" . $curso . "'";
      $conexion = $this->createConnection();
      $statement = $conexion->prepare($sql);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function findConvocatoriaCurso($idCurso, $curso, $convocatoria) {
      $sql = "SELECT n.* FROM nota n WHERE n.convocatoria = '" . $convocatoria . "' AND n.curso_id = '" . $idCurso . "' AND n.curso = '" . $curso . "'";
      $conexion = $this->createConnection();
      $statement = $conexion->prepare($sql);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function findAll() {
      $sql = "SELECT * FROM curso";
      $conexion = $this->createConnection();
      $statement = $conexion->prepare($sql);
      $statement->execute();
      return $statement->fetchAll();
    }

    function deleteAll() {
      $sql = "DELETE FROM curso";
      $conexion = $this->createConnection();
      $conexion->exec($sql);
    }
  }

 ?>
