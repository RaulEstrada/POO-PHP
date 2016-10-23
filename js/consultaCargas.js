$(document).ready(function() {
  $.ajax({
        url: "backend/consultaCargas.php",
        type: "get"
    }).done(function(json) {
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
      crearGraficoGenero(json.estudiantes);
      crearGraficoEdad(json.estudiantes);
    }).fail(function(data) {
      alert("FAIL: " + data);
    });
});

function crearGraficoGenero(estudiantes) {
  var estadisticas = {'Hombre': 0, 'Mujer': 0};
  for (var indx = 0; indx < estudiantes.length; indx++) {
    var estudiante = estudiantes[indx];
    estadisticas[estudiante.genero] += 1;
  }
  var gaugeHombre = new proteic.Gauge([{x: estadisticas['Hombre']}], {
     minLevel: 0,
     maxLevel: estudiantes.length,
     ticks: 10,
     selector: '#generoChart',
     label: 'Hombres',
     width: '45%'
   });
  gaugeHombre.draw();
  var gaugeMujer = new proteic.Gauge([{x: estadisticas['Mujer']}], {
      minLevel: 0,
      maxLevel: estudiantes.length,
      ticks: 10,
      selector: '#generoChart',
      label: 'Mujeres',
      width: '45%'
  });
  gaugeMujer.draw();
}

function crearGraficoEdad(estudiantes) {
  var estadisticas = {};
  for (var indx = 0; indx < estudiantes.length; indx++) {
    var estudiante = estudiantes[indx];
    var fecha = estudiante.fecha_nacimiento.split("-");
    var year = fecha[fecha.length-1];
    if (!estadisticas[year]) {
      estadisticas[year] = {'Hombre': 0, 'Mujer': 0};
    }
    estadisticas[year][estudiante.genero] += 1;
  }
  var dataArea = [];
  for (var year in estadisticas) {
    dataArea.push({key:'Hombre', x:year, y:estadisticas[year]['Hombre']});
    dataArea.push({key:'Mujer', x:year, y:estadisticas[year]['Mujer']});
  }
  areaLinechart = new proteic.Linechart(dataArea, {
      selector: '#edadChart',
      area: true,
      width: '90%',
      height: 400
  });
  areaLinechart.draw();
}
