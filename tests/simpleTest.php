<?php

require_once("backend/persistency/EstudianteDAO.php");
require_once "backend/model/Estudiante.php";
require_once "backend/persistency/CursoDAO.php";
require_once "backend/model/Curso.php";
require_once "backend/persistency/NotaDAO.php";
require_once "backend/model/Nota.php";
require_once "backend/EstudianteStats.php";

class POOTest extends PHPUnit_Framework_TestCase
{
    function test_media_asignaturas() {
      $stats = new EstudianteStats();
      $student = new Estudiante("S1993", "Raul", "Estrada", "08-05-1993", "Hombre");
      $course = new Curso("C1993", "2014-15");
      $course2 = new Curso("C1994", "2014-15");
      $enrollment = new Nota("1", 7, "C1993", "2014-15", "S1993");
      $enrollment2 = new Nota("1", 3, "C1994", "2014-15", "S1993");
      $studentDAO = new EstudianteDAO();
      $courseDAO = new CursoDAO();
      $enrollmentDAO = new NotaDAO();

      $studentDAO->addEstudiante($student);
      $courseDAO->addCurso($course);
      $courseDAO->addCurso($course2);
      $enrollmentDAO->addNota($enrollment);
      $enrollmentDAO->addNota($enrollment2);

      $statsResult = $stats->getStats("S1993")["datosAsignaturas"];
      $this->assertEquals(7, $statsResult["C1993"]);
      $this->assertEquals(3, $statsResult["C1994"]);

      $enrollmentDAO->deleteByIds("S1993", "C1993", "2014-15");
      $enrollmentDAO->deleteByIds("S1993", "C1994", "2014-15");
      $courseDAO->deleteById("C1993");
      $courseDAO->deleteById("C1994");
      $studentDAO->deleteById("S1993");
    }

    function test_media() {
      $stats = new EstudianteStats();
      $student = new Estudiante("S1993", "Raul", "Estrada", "08-05-1993", "Hombre");
      $course = new Curso("C1993", "2014-15");
      $course2 = new Curso("C1994", "2014-15");
      $enrollment = new Nota("1", 7, "C1993", "2014-15", "S1993");
      $enrollment2 = new Nota("1", 3, "C1994", "2014-15", "S1993");
      $studentDAO = new EstudianteDAO();
      $courseDAO = new CursoDAO();
      $enrollmentDAO = new NotaDAO();

      $studentDAO->addEstudiante($student);
      $courseDAO->addCurso($course);
      $courseDAO->addCurso($course2);
      $enrollmentDAO->addNota($enrollment);
      $enrollmentDAO->addNota($enrollment2);

      $statsResult = $stats->getStats("S1993");
      $this->assertEquals(5, $statsResult["notaMedia"]);

      $enrollmentDAO->deleteByIds("S1993", "C1993", "2014-15");
      $enrollmentDAO->deleteByIds("S1993", "C1994", "2014-15");
      $courseDAO->deleteById("C1993");
      $courseDAO->deleteById("C1994");
      $studentDAO->deleteById("S1993");
    }

    function test_notas_alfabeticas() {
      $stats = new EstudianteStats();
      $student = new Estudiante("S1993", "Raul", "Estrada", "08-05-1993", "Hombre");
      $course = new Curso("C1993", "2014-15");
      $course2 = new Curso("C1994", "2014-15");
      $enrollment = new Nota("1", 7, "C1993", "2014-15", "S1993");
      $enrollment2 = new Nota("1", 3, "C1994", "2014-15", "S1993");
      $studentDAO = new EstudianteDAO();
      $courseDAO = new CursoDAO();
      $enrollmentDAO = new NotaDAO();

      $studentDAO->addEstudiante($student);
      $courseDAO->addCurso($course);
      $courseDAO->addCurso($course2);
      $enrollmentDAO->addNota($enrollment);
      $enrollmentDAO->addNota($enrollment2);

      $statsResult = $stats->getStats("S1993")["datosNotasNumericas"];
      $this->assertEquals(1, $statsResult["Notable"]);
      $this->assertEquals(1, $statsResult["Suspenso"]);
      $this->assertEquals(0, $statsResult["Sobresaliente"]);
      $this->assertEquals(0, $statsResult["Aprobado"]);
      $this->assertEquals(0, $statsResult["NP"]);

      $enrollmentDAO->deleteByIds("S1993", "C1993", "2014-15");
      $enrollmentDAO->deleteByIds("S1993", "C1994", "2014-15");
      $courseDAO->deleteById("C1993");
      $courseDAO->deleteById("C1994");
      $studentDAO->deleteById("S1993");
    }
}
