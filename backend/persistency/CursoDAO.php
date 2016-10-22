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

    function findCurso($idCurso) {
      $sql = "SELECT id FROM curso WHERE id = '" . $idCurso . "';";
      $conexion = $this->createConnection();
      $statement = $conexion->prepare($sql);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_COLUMN, "id");
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
