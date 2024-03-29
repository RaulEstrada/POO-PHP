$(document).ready(function() {
  $("#dialog").dialog({
      modal: true,
      autoOpen: false,
      width: 500,
      height: 400
    });
  $("#subirEstudiantes").on("submit", function(event) {
    event.preventDefault();
    subirEstudiantes();
    $("#subirEstudiantes")[0].reset();
  });
  $("#subirNotas").on("submit", function(event) {
    event.preventDefault();
    subirNotas();
    $("#subirNotas")[0].reset();
  });
  $("#hacerReset").on("submit", function(event) {
    event.preventDefault();
    hacerReset();
  });
});

function subirEstudiantes() {
  var data = new FormData();
  var dialog = $("#dialog");
  dialog.html("");
  data.append("ficheroEstudiantes", $("#ficheroEstudiantes").prop('files')[0]);
  $.ajax({
    url: "http://156.35.98.14/POO-PHP/backend/cargaEstudiantes.php",
    method: "post",
    cache: false,
    contentType: false,
    processData: false,
    data: data
  }).done(function(data) {
    var msg = "Alumnos añadidos.";
    if (data && data.length > 0) {
      msg = msg + " Los siguientes ya existían: " + data.join(", ");
    }
    dialog.append($("<p>" + msg + "</p>"));
    dialog.dialog("open");
  }).fail(function(data) {
    dialog.append($("<p>FAILED</p>"));
    dialog.dialog("open");
  });
}

function subirNotas() {
  var data = new FormData();
  var dialog = $("#dialog");
  dialog.html("");
  data.append("ficheroNotas", $("#ficheroNotas").prop('files')[0]);
  $.ajax({
    url: "http://156.35.98.14/POO-PHP/backend/cargaNotas.php",
    method: "post",
    cache: false,
    contentType: false,
    processData: false,
    data: data
  }).done(function(data) {
    displaySubirNotasResult(data);
    dialog.dialog("open");
  }).fail(function(data) {
    dialog.append($("<p>FAILED</p>"));
    dialog.dialog("open");
  });
}

function displaySubirNotasResult(data) {
  var dialog = $("#dialog");
  dialog.append("<p>Notas subidas.</p>")
  procesarErroresEstudiantesMissing(data, dialog);
  procesarErroresNotasInvalidas(data, dialog);
  procesarErroresNotasRepetidas(data, dialog);
  procesarErrorCursoRepetido(data, dialog);
}

function procesarErroresEstudiantesMissing(data, dialog) {
  if (data.errorEstudianteMissing && data.errorEstudianteMissing.length > 0) {
    var msg = "<p>Los siguientes alumnos no se han encontrado, y sus notas no se han subido:</p><ul>";
    for (var indx = 0; indx < data.errorEstudianteMissing.length; indx++) {
      msg = msg + "<li>" + data.errorEstudianteMissing[indx] + "</li>";
    }
    msg = msg + "</ul>";
    dialog.append(msg);
  }
}

function procesarErroresNotasInvalidas(data, dialog) {
  if (data.errorNotaInvalida && data.errorNotaInvalida.length > 0) {
    var msg = "<p>Las siguientes notas son inválidas y no se han subido:</p><ul>";
    for (var indx = 0; indx < data.errorNotaInvalida.length; indx++) {
      var errorNota = data.errorNotaInvalida[indx];
      msg = msg + "<li>" + errorNota.estudiante + ": " + errorNota.nota + "</li>";
    }
    msg = msg + "</ul>";
    dialog.append(msg);
  }
}

function procesarErroresNotasRepetidas(data, dialog) {
  if (data.errorNotasRepetidas && data.errorNotasRepetidas.length > 0) {
    var msg = "<p>Los siguientes alumnos ya tenían nota el curso y no se han añadido las nuevas:</p><ul>";
    for (var indx = 0; indx < data.errorNotasRepetidas.length; indx++) {
      var errorNota = data.errorNotasRepetidas[indx];
      msg = msg + "<li>Estudiante " + errorNota.estudiante + ": Nota " + errorNota.nota + ": Curso " +
        errorNota.curso + ": Convocatoria " + errorNota.convocatoria + "</li>";
    }
    msg = msg + "</ul>";
    dialog.append(msg);
  }
}

function procesarErrorCursoRepetido(data, dialog) {
  if (data.errorCursoRepetido && data.errorCursoRepetido != '') {
    var msg = "<p>El curso ya se había subido anteriormente. No se han registrado las notas</p>";
    dialog.append(msg);
  }
}

function hacerReset() {
  var dialog = $("#dialog");
  dialog.html("");
  $.ajax({
    url: "http://156.35.98.14/POO-PHP/backend/borrarBaseDatos.php",
    method: "post"
  }).done(function(data) {
    dialog.append($("<p>" + data.message + "</p>"));
    dialog.dialog("open");
  }).fail(function(data) {
    dialog.append($("<p>FAILED</p>"));
    dialog.dialog("open");
  });
}
