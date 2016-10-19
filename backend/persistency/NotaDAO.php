<?php

require_once("DBConnector.php");

class NotaDAO {
  use DBConnector;
  
  function addNota($nota) {
    try {
      $sql = "INSERT INTO nota (convocatoria, nota, curso, estudiante) VALUES ('"
        . $nota->getConvocatoria() . "', '" . $nota->getNota() . "', '" .
        $nota->getCurso() . "', '" . $nota->getEstudiante() . "')";
      $conexion = $this->createConnection();
      $conexion->exec($sql);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
  }

  function findByEstudiante($id_estudiante) {
    try {
      $sql = "SELECT n.nota, n.convocatoria, c.id, c.curso FROM nota n, curso c WHERE n.curso = c.id AND estudiante = '"
        . $id_estudiante . "';";
      $conexion = $this->createConnection();
      $statement = $conexion->prepare($sql);
      $statement->execute();
      return $statement->fetchAll();
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
  }

  function findByCurso($id_curso) {
    try {
      $sql = "SELECT e.*, n.* FROM nota n, estudiante e WHERE n.estudiante = e.id AND curso = '"
        . $id_curso . "';";
      $conexion = $this->createConnection();
      $statement = $conexion->prepare($sql);
      $statement->execute();
      return $statement->fetchAll();
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
  }

  function findNotaByCursoAndEstudiante($id_curso, $id_estudiante) {
    try {
      $sql = "SELECT nota FROM nota WHERE curso = '" . $id_curso . "' AND estudiante = '"
        . $id_estudiante . "';";
      $conexion = $this->createConnection();
      $statement = $conexion->prepare($sql);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_COLUMN, "id");
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
  }

  function deleteAll() {
    try {
      $sql = "DELETE FROM nota";
      $conexion = $this->createConnection();
      $conexion->exec($sql);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
  }
}

 ?>
