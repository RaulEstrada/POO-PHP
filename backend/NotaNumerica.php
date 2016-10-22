<?php

trait NotaNumerica {
  function getNotaAlfabetica($nota_decimal) {
    if ($nota_decimal >= 9) {
      return "Sobresaliente";
    } elseif ($nota_decimal >= 7) {
      return "Notable";
    } elseif ($nota_decimal >= 5) {
      return "Aprobado";
    } else {
      return "Suspenso";
    }
  }
}

 ?>
