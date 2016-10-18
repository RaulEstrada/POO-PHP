<?php

require_once("DatabaseCleaner.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $databaseCleaner = new DatabaseCleaner();
  $databaseCleaner->clean();
} else {
  header("HTTP/1.1 400 Bad Request");
  print("Método HTTP no permitido");
  exit();
}

 ?>
