<?php

require_once("DBConnector.php");

  class CursoDAO {
    use DBConnector;

    function addCurso($curso) {
      try {
        $sql = "INSERT INTO curso (id, curso) VALUES ('"
          . $curso->getId() . "', '" . $curso->getCurso() . "')";
        $conexion = $this->createConnection();
        $conexion->exec($sql);
      } catch (PDOException $e) {
          echo $sql . "<br>" . $e->getMessage();
        }
    }

    function findCurso($idCurso) {
      try {
        $sql = "SELECT id FROM curso WHERE id = '" . $idCurso . "';";
        $conexion = $this->createConnection();
        $statement = $conexion->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_COLUMN, "id");
      } catch (PDOException $e) {
          echo $sql . "<br>" . $e->getMessage();
        }
    }

    function findAll() {
      try {
        $sql = "SELECT * FROM curso";
        $conexion = $this->createConnection();
        $statement = $conexion->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
      } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
    }

    function deleteAll() {
      try {
        $sql = "DELETE FROM curso";
        $conexion = $this->createConnection();
        $conexion->exec($sql);
      } catch (PDOException $e) {
          echo $sql . "<br>" . $e->getMessage();
        }
    }
  }

 ?>
