<?php

require_once("EstudianteDAO.php");
require_once("CursoDAO.php");
require_once("NotaDAO.php");

  class DatabaseCleaner {
    function clean() {
      $estudianteDAO = new EstudianteDAO();
      $cursoDAO = new CursoDAO();
      $notaDAO = new NotaDAO();

      $notaDAO->deleteAll();
      $estudianteDAO->deleteAll();
      $cursoDAO->deleteAll();
    }
  }

 ?>
