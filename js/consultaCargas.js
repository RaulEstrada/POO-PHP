$(document).ready(function() {
  $.ajax({
        url: "backend/consultaCargas.php",
        type: "get"
    }).done(function(data) {
      var json = JSON.parse(data);
      var tablaCursos = $("#cursos tbody");
      for(var indx = 0; indx < json.cursos.length; indx++) {
        var curso = json.cursos[indx];
        var row = $("<tr><td>" + curso.id + "</td><td>" + curso.curso + "</td></tr>");
        tablaCursos.append(row);
      }
      var tablaEstudiantes = $("#estudiantes tbody");
      for(var indx = 0; indx < json.estudiantes.length; indx++) {
        var estudiante = json.estudiantes[indx];
        var row = $("<tr><td>" + estudiante.id + "</td><td>" + estudiante.nombre +
         "</td><td>" + estudiante.apellidos + "</td><td>" + estudiante.fecha_nacimiento +
         "</td><td>" + estudiante.genero + "</td></tr>");
        tablaEstudiantes.append(row);
      }
    });
});
