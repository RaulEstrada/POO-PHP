<?php

require_once("DBConnector.php");

class NotaDAO extends DBConnector {
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
