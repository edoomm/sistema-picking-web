$(document).ready(function() {
  resetForm('#Registrar');
  $('#Dm').html("Pickup");
  graphic_Change("Pickup",'P');
});


function graphic_Change(selection, opcion){
  $('#Dm').html(selection);

  let empleado = new Array();
  let accion = new Array();

  var dataString = 'tipo_movimiento=' + opcion;

  $.ajax({
    url: '../php/operadores/operadoresGrafica.php',
    type: 'post',
    data: dataString,
    dataType: "json",
    success: function(data) {
      empleado = data.numero;
      cantidad = data.cantidad;

      Graphic(empleado.length, empleado, cantidad, opcion);
    }
  });

  return false;
}



var grafico;

function Graphic(total, nombres, datos, opcion){
  var pos;
  var accion;

  if (grafico){
    pos = $(document).scrollTop();
    grafico.destroy();
  }

  if (opcion == 'P') accion = "Pickeos";
  else accion = "Reabastos";


  var coloR = [];
  var dataLabel = "# de "+ accion +" realizados";

  for (var i = 0; i < total; i++) {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);

    coloR.push("rgb(" + r + "," + g + "," + b + ")");
  }

  var mostrar = $("#miGrafico");
  grafico = new Chart(mostrar, {
    type: 'bar',
    data: {
      labels: nombres,
      datasets: [{
        label: dataLabel,
        data: datos,
        backgroundColor: coloR,
        borderColor: coloR,
        borderWidth: 1
      }]
    },
    options: {
      responsive:true,
      legend: {
        display: true,
        labels: {
          backgroundColor: coloR,
        }
      },

      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });
  $(document).scrollTop(pos);
}



function filtrar() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("busqueda");
  filter = input.value.toUpperCase();
  table = document.getElementById("operador");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function formValidate(formId, formMsg, numeroEmpleado) {
  var flag = 0;

$(formId).find('[data-required]').each(function() {
  var actual = $(this).val();

  if (actual === "") {
    $(this).addClass('is-invalid');
    flag = 1;
  } else {
    if (actual == numeroEmpleado) {
      if (!Validate_NumeroEmpleado(actual)) flag = 2;
    }
  }
});

if (flag == 1) {
  $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> Todos los campos son necesarios! </div>');
  return false;
} else if (flag == 2) {
  $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> Error con el número de empleado! </div>');
  $(inputNumeroEmpleado).addClass('is-invalid');
  return false;
}
else {
  $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> </div>');
  $(formId).find('[data-required]').each(function() {
    $(this).removeClass('is-invalid');
    $(this).addClass('is-valid');
  });
  insert(formId);
}
}

function insert(formID) {
  $.ajax({
    type: 'POST',
    url: '../php/operadores/operadoresInsert.php',
    data: $(formID).serialize(),
    success: function(data) {
      $('#registro').modal('hide');
      $('#exito').modal('show');
      $('#inputCorreo').val('');
    }
  });
}

function liderButton() {
  $('#registro').modal('hide');
  $('#lider1').modal('show');
  $('#numeroLider').val('');
}


function Validate_Delete(formId, formMsg, numeroEmpleado) {
  var valido = Validate_NumeroEmpleado(numeroEmpleado);

  if (valido) {
    $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> No existe el número de empleado! </div>');
    $(formId).find('[data-required]').each(function() {
      $(this).addClass('is-invalid');
    });
  } else {
    $(formId).find('[data-required]').each(function() {
      $(this).removeClass('is-invalid');
      $(this).addClass('is-valid');
    });
    $('#eliminar1').modal('hide');
    $('#eliminar2').modal('show');
    $('#SE').html('<b>' + numeroEmpleado + '</b>');
  }
}

function DeleteOperador(numeroEmpleado) {
  var dataString = 'numero_empleado=' + numeroEmpleado;
  $.ajax({
    url: '../php/operadores/operadoresDelete.php',
    type: 'post',
    data: dataString,
    success: function(value) {
      $('#eliminar2').modal('hide');
      $('#inputEliminar').val('');
      $('#exito').modal('show');
    }
  });
}

function Validate_Modify(formId, formMsg, numeroEmpleado) {
  var valido = Validate_NumeroEmpleado(numeroEmpleado);

  //valido == false, it exists in the database
  if (valido) {
    $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> No existe el número de empleado! </div>');
    $(formId).find('[data-required]').each(function() {
      $(this).addClass('is-invalid');
    });
  } else {
      $('#modificar1').modal('hide');
      fillForm(formId, formMsg, numeroEmpleado);
  }
}

function Validate_ModifyLider(formId, formMsg, numeroEmpleado) {
  var num = Validate_NumeroEmpleado(numeroEmpleado);

  if (num){
    $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> No existe el número de empleado! </div>');
    $(formId).find('[data-required]').each(function() {
      $(this).addClass('is-invalid');
    });
  }
  else{
    var usr = Validate_NumeroUsr(numeroEmpleado);

    if (!usr){
      $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> El número de empleado ya es líder de almacén! </div>');
      $(formId).find('[data-required]').each(function() {
      $(this).addClass('is-invalid');
      });
    }
    else{
      $('#lider1').modal('hide');
      $('#lider2').modal('show');
    }

  }
}

//Aqui lleno el formulario con los datos que ya tengo
function fillForm(formID, formMsg, numeroEmpleado) {
  var dataString = 'numero_empleado=' + numeroEmpleado;
  $.ajax({
    url: '../php/operadores/operadoresModify.php',
    type: 'post',
    data: dataString,
    dataType: "json",
    success: function(data) {
      $('#modificarNombre').val(data[0]);
      $('#modificarCorreo').val(data[1]);
    }
  });
  $('#modificar2').modal('show');
}

//Aqui tengo que hacer el update de el usuario en la base de datos
function Validate_Form2(formId, formMsg, numeroEmpleado) {
  var flag = 0;

  $(formId).find('[data-required]').each(function() {
    var actual = $(this).val();

    if (actual === "") {
      $(this).addClass('is-invalid');
      flag = 1;
    }
  });
  if (flag == 1) {
    $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> Todos los campos son necesarios! </div>');
    return false;
  } else {
    var dataString = 'numero_empleado=' + numeroEmpleado + "&" + $(formId).serialize();
    $.ajax({
      url: '../php/operadores/operadoresUpdate.php',
      type: 'post',
      data: dataString,
      success: function(data) {
        $('#modificar2').modal('hide');
        $('#exito').modal('show');
        $('#inputCambiar').val('');
      }
    });
  }
}


function Validate_Lider(formId, formMsg, numeroEmpleado) {
  var flag = 0;

  $(formId).find('[data-required]').each(function() {
    var actual = $(this).val();

    if (actual === "") {
      $(this).addClass('is-invalid');
      flag = 1;
    }
  });
  if (flag == 1) {
    $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> Todos los campos son necesarios! </div>');
    return false;
  } else {
    var dataString = 'numero_empleado=' + numeroEmpleado + "&" + $(formId).serialize();

    $.ajax({
      url: '../php/operadores/operadoresLider.php',
      type: 'post',
      data: dataString,
      success: function(data) {
        $('#lider2').modal('hide');
        $('#exito').modal('show');
        resetForm(formId);
      }
    });
  }
}


function resetForm(formActual) {
  $(formActual).find('[data-required]').each(function() {
    $(this).val('');
  });
}

function Validate_NumeroEmpleado(actual) {
  var valueReturn;

  if (actual.length == 6 && Validate_Number(actual)) {
    var dataString = 'numero_empleado=' + actual;
    $.ajax({
      async: false,
      url: '../php/operadores/operadoresR.php',
      type: 'post',
      data: dataString,
      success: function(value) {
        valueReturn = (value == 0) ? true : false;
      }
    });
  } else {
    valueReturn = false;
  }

  return valueReturn;
}


function Validate_NumeroUsr(actual) {
  var valueReturn;

  if (actual.length == 6 && Validate_Number(actual)) {
    var dataString = 'numero_empleado=' + actual;
    $.ajax({
      async: false,
      url: '../php/operadores/operadoresUsuario.php',
      type: 'post',
      data: dataString,
      success: function(value) {
        valueReturn = (value == 0) ? true : false;
      }
    });
  } else {
    valueReturn = false;
  }

  return valueReturn;
}


function Validate_Number(numero){
  let isnum = /^\d+$/.test(numero);
  return isnum;
}
