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
    $("#subirEstudiantes").reset();
  })
});

function subirEstudiantes() {
  var data = new FormData();
  var dialog = $("#dialog");
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
