<?php

require_once("DBConnector.php");

class NotaDAO {
  use DBConnector;

  function addNota($nota) {
    $sql = "INSERT INTO nota (convocatoria, nota, curso_id, curso, estudiante) VALUES ('"
      . $nota->getConvocatoria() . "', '" . $nota->getNota() . "', '" .
      $nota->getCursoID() . "', '" .
      $nota->getCurso() . "', '" . $nota->getEstudiante() . "')";
    $conexion = $this->createConnection();
    $conexion->exec($sql);
  }

  function findByEstudiante($id_estudiante) {
    $sql = "SELECT n.* FROM nota n";
    if ($id_estudiante != null) {
      $sql = $sql . " WHERE n.estudiante = '" . $id_estudiante . "'";
    }
    $conexion = $this->createConnection();
    $statement = $conexion->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();
  }

  function findByCurso($curso) {
    $sql = "SELECT e.*, n.* FROM nota n, estudiante e WHERE n.estudiante = e.id AND curso = '"
      . $curso . "';";
    $conexion = $this->createConnection();
    $statement = $conexion->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();
  }

  function findByEstudianteAndCurso($id_curso, $id_estudiante) {
    $sql = "SELECT n.nota, n.convocatoria, n.estudiante, c.curso FROM nota n, curso c WHERE n.curso_id = c.id AND c.id = '" . $id_curso . "' AND n.estudiante = '"
      . $id_estudiante . "' AND n.nota != 'NP' AND CAST(n.nota AS INTEGER) >= 5 LIMIT 1";
    $conexion = $this->createConnection();
    $statement = $conexion->prepare($sql);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  function findNotaByCursoAndEstudiante($id_curso, $id_estudiante) {
    $sql = "SELECT nota FROM nota WHERE curso = '" . $id_curso . "' AND estudiante = '"
      . $id_estudiante . "';";
    $conexion = $this->createConnection();
    $statement = $conexion->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_COLUMN, "id");
  }

  function deleteAll() {
    $sql = "DELETE FROM nota";
    $conexion = $this->createConnection();
    $conexion->exec($sql);
  }
}

 ?>
