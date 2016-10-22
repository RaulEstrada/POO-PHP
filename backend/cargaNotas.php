<?php

require_once("model/Curso.php");
require_once("model/Nota.php");
require_once("persistency/CursoDAO.php");
require_once("persistency/NotaDAO.php");
require_once("model/exceptions/NotaInvalidaException.php");
require_once("model/exceptions/NotaRepetidaException.php");

class NotasHandler {
  static function handleRequest() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $file_contents = file_get_contents($_FILES["ficheroNotas"]["tmp_name"]);
      $convocatoria_JSON = json_decode($file_contents, true);
      $notas_JSON = $convocatoria_JSON["notas"];
      $numero_convocatoria = $convocatoria_JSON["convocatoria"];
      $curso = NotasHandler::intentarCrearCurso($convocatoria_JSON);
      $nota_DAO = new NotaDAO();
      $errores = array("errorNotasRepetidas"=> [], "errorEstudianteMissing"=> [], "errorNotaInvalida"=> []);
      foreach ($notas_JSON as $nota_JSON) {
        NotasHandler::handleNota($numero_convocatoria, $nota_JSON, $curso, $nota_DAO, $errores);
      }
      header("HTTP/1.1 200 OK");
      header('Content-Type: application/json');
      print(json_encode($errores));
    } else {
      header("HTTP/1.1 400 Bad Request");
      print("Método HTTP no permitido");
      exit();
    }
  }

  static function handleNota($numero_convocatoria, $nota_JSON, $curso, $nota_DAO, &$errores) {
    try {
      $nota = new Nota($numero_convocatoria, $nota_JSON["valor"], $curso->getId(), $nota_JSON["id"]);
      $nota_previa = $nota_DAO->findByEstudianteAndCurso($curso->getId(), $nota->getEstudiante());
      if (!empty($nota_previa)) {
        throw new NotaRepetidaException($nota_previa["nota"], $nota_previa["estudiante"], $nota_previa["curso"], $nota_previa["convocatoria"]);
      }
      $nota_DAO->addNota($nota);
    } catch (PDOException $e) {
      if ($e->getCode() === "23000") {
        $errores["errorEstudianteMissing"][] = $nota->getEstudiante();
      }
    } catch (NotaInvalidaException $e) {
      $errores["errorNotaInvalida"][] = $e->getJSON();
    } catch (NotaRepetidaException $e) {
      $errores["errorNotasRepetidas"][] = $e->getJSON();
    }
  }

  static function intentarCrearCurso($convocatoria_JSON) {
    $curso = new Curso($convocatoria_JSON["id"], $convocatoria_JSON["curso"]);
    $curso_DAO = new CursoDAO();
    $curso_DB = $curso_DAO->findCurso($curso->getId());
    $curso_existe = !empty($curso_DB);
    if (!$curso_existe) {
      $curso_DAO->addCurso($curso);
    }
    return $curso;
  }
}

NotasHandler::handleRequest();

 ?>
