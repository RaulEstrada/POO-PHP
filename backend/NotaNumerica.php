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

  function getDatosMedia($notas) {
    $suma_notas = 0;
    $count_alumnos = 0;
    foreach ($notas as $nota) {
      if ($nota["nota"] !== "NP") {
        $suma_notas += $nota["nota"];
        $count_alumnos += 1;
      }
    }
    $resultado = 0;
    if ($count_alumnos != 0) {
      $resultado = $suma_notas / $count_alumnos;
    }
    return $resultado;
  }
}

 ?>
