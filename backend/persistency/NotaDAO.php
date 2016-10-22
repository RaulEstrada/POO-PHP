<?php

require_once("DBConnector.php");

class NotaDAO {
  use DBConnector;

  function addNota($nota) {
    $sql = "INSERT INTO nota (convocatoria, nota, curso, estudiante) VALUES ('"
      . $nota->getConvocatoria() . "', '" . $nota->getNota() . "', '" .
      $nota->getCurso() . "', '" . $nota->getEstudiante() . "')";
    $conexion = $this->createConnection();
    $conexion->exec($sql);
  }

  function findByEstudiante($id_estudiante) {
    $sql = "SELECT n.nota, n.convocatoria, c.id, c.curso FROM nota n, curso c WHERE n.curso = c.id AND estudiante = '"
      . $id_estudiante . "';";
    $conexion = $this->createConnection();
    $statement = $conexion->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();
  }

  function findByCurso($id_curso) {
    $sql = "SELECT e.*, n.* FROM nota n, estudiante e WHERE n.estudiante = e.id AND curso = '"
      . $id_curso . "';";
    $conexion = $this->createConnection();
    $statement = $conexion->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();
  }

  function findByEstudianteAndCurso($id_curso, $id_estudiante) {
    $sql = "SELECT n.nota, n.convocatoria, n.estudiante, c.curso FROM nota n, curso c WHERE n.curso = c.id AND c.id = '" . $id_curso . "' AND n.estudiante = '"
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
