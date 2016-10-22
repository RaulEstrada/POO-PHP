function consultarEstudiante(event) {
  event.preventDefault();
  $.ajax({
    url: "backend/consultaEstudiante.php",
    type: "get",
    data: $("#estudiantesForm").serialize()
  }).done(function(data) {
    crearGraficaEstudianteAsignaturas(data);
    crearGraficaEstudianteMedia(data);
    crearGraficaEstudianteCurso(data);
    crearGraficaEstudianteNotaAlfabetica(data);
  }).fail(function(data) {
    alert("FAIL: " + data);
  });
}

function crearGraficaEstudianteAsignaturas(data) {
  $("#estudiantesAsignaturasMedias").html("");
  var datosAsignaturas = data.datosAsignaturas;
  var dataGrafica = [];
  for (var asignatura in datosAsignaturas) {
    dataGrafica.push({x: asignatura, key: asignatura, y: datosAsignaturas[asignatura]});
  }
  var barchartGrouped = new proteic.Barchart(dataGrafica, {
    selector: '#estudiantesAsignaturasMedias',
    stacked: false,
    xAxisLabel: 'Asignatura',
    yAxisLabel: 'Nota media',
    width: '60%'
  });
  barchartGrouped.draw();
}

function crearGraficaEstudianteMedia(data) {
  $("#estudiantesMedias").html("");
  var notaMedia = Math.round(data.notaMedia * 100) / 100;
  var gauge = new proteic.Gauge([{x: notaMedia}], {
     minLevel: 0,
     maxLevel: 10,
     ticks: 1,
     selector: '#estudiantesMedias',
     label: 'Nota media'
   });
  gauge.draw();
}

function crearGraficaEstudianteCurso(data) {
  $("#estudiantesCursoMedias").html("");
  var datosCursos = data.datosCursoAcademico;
  var dataGrafica = [];
  for (var curso in datosCursos) {
    var year = curso.split("-")[0].substring(2,4);
    dataGrafica.push({x: '01/01/' + year, key: 'Nota media', y: datosCursos[curso].toFixed(2)});
  }
  areaLinechart = new proteic.Linechart(dataGrafica, {
      selector: '#estudiantesCursoMedias',
      area: true,
      width: '70%',
      height: 400,
      xAxisType: 'time'
  });
  areaLinechart.draw();
  $("#estudiantesCursoMedias g.x g.tick text").attr("transform", "translate(0, 40),rotate(90)");
}

function crearGraficaEstudianteNotaAlfabetica(data) {
  $("#estudiantesNotasAlfabeticas").html("");
  var datosCursos = data.datosNotasNumericas;
  var dataGrafica = [{"id": "root", "parent": "", "value": "0", "label": "sequences"}];
  var indx = 0;
  for (var curso in datosCursos) {
    dataGrafica.push({id: indx, parent: "root", value: datosCursos[curso], label: curso});
    indx = indx + 1;
  }
  var sunburst = new proteic.Sunburst(dataGrafica, {
      selector: '#estudiantesNotasAlfabeticas'
  });
  sunburst.draw();
}

function consultarCurso(event) {
  event.preventDefault();
  alert("hiii");
}

function consultarAsignatura(event) {
  event.preventDefault();
  alert("hiii");
}
