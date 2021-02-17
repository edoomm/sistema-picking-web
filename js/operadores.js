$(document).ready(function() {
  resetForm('#Registrar', '#operadoresMsg');
  $('#Dm1').html("Pickup");
  $('#Dm2').html("Día");
  let temp = get_Interval('Día');
  let inicial = temp.condicionI;
  let fin = temp.condicionF;
  graphic_Change('P', inicial, fin)
  Filtro("activo=1");
});

function get_Interval(intervalo) {
  var dateObj = new Date();
  var month = dateObj.getUTCMonth() + 1;

  if (month < 10) {
    var temp = "0" + month;
    month = temp;
  }

  var day = dateObj.getUTCDate();

  if (day < 10) {
    var temp = "0" + day;
    day = temp;
  }

  var year = dateObj.getUTCFullYear();

  var condicionI;
  var condicionF;

  var horaI = "00:00:00.000";
  var horaF = "23:59:59.000";

  if (intervalo == "Día") {
    condicionI = year + "-" + month + "-" + day + " " + horaI;
    condicionF = year + "-" + month + "-" + day + " " + horaF;
  } else if (intervalo == "Semana") {
    var first = dateObj.getDate() - dateObj.getDay();
    var last = first + 6;

    first = (first < 10) ? "0"+first : first;
    last = (last < 10) ? "0"+last : last;

    condicionI = year + "-" + month + "-" + first + " " + horaI;
    condicionF = year + "-" + month + "-" + last + " " + horaF;

  } else if (intervalo == "Mes") {
    condicionI = year + "-" + month + "-01 " + horaI;
    condicionF = year + "-" + month + "-31 " + horaF;
    
  } else {
    condicionI = year + "-01-01 " + horaI;
    condicionF = year + "-12-31 " + horaF;
  }

    console.log(condicionI);
    console.log(condicionF);
    console.log("  ");

  return {
    condicionI,
    condicionF
  };

}

function update_Action(accion) {
  $('#Dm1').html(accion);
  var opcion = (accion == "Pickup") ? "P" : "R";
  var condicion = get_Interval($('#Dm2').text());

  let inicial = condicion.condicionI;
  let fin = condicion.condicionF;

  graphic_Change(opcion, inicial, fin);
}

function update_Interval(intervalo) {
  $('#Dm2').html(intervalo);
  var condicion = get_Interval(intervalo);

  var accion = $('#Dm1').text();
  var opcion = (accion == "Pickup") ? "P" : "R";

  let inicial = condicion.condicionI;
  let fin = condicion.condicionF;

  graphic_Change(opcion, inicial, fin);
}

// La siguiente función funciona para el dibujo de la
// gráfica en primer parametro es referencia a la opción
// de pickeo o reabasto y la condición hace referencía
// la condición a mandar a la query dentro de sql
function graphic_Change(opcion, inicial, fin) {

  let empleado = new Array();
  let accion = new Array();

  var dataString = 'tipo_movimiento=' + opcion + "&condicionI=" + inicial + "&condicionF=" + fin;


  $.ajax({
    url: '../php/operadores/operadoresGrafica.php',
    type: 'post',
    data: dataString,
    dataType: "json",
    success: function(data) {
      empleado = data.numero;
      cantidad = data.cantidad;

      Graphic(empleado.length, empleado, cantidad, opcion);
    },
    error: function(error) {
      Graphic(0, [], [], "P");
    }
  });

  return false;

}



var grafico;

function Graphic(total, nombres, datos, opcion) {
  var pos;
  var accion;

  if (grafico) {
    pos = $(document).scrollTop();
    grafico.destroy();
  }

  if (opcion == 'P') accion = "Pickeos";
  else accion = "Reabastos";


  var coloR = [];
  var dataLabel = "# de " + accion + " realizados por empleados activos";

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
      responsive: true,
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
        var numero = Validate_Number(actual);
        var sz = (actual.length == 6) ? true : false;
        var existe = Validate_NumeroEmpleado(actual);
        if (!numero || !sz || !existe) flag = 2;
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
  } else {
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
    },
    error: function(error) {
      alert("No fue posible realizar esa acción");
    }
  });
}

function liderButton(opcion) {

  $('#liderOpcion').modal('hide');

  if (opcion == "registrar") {
    $('#numeroLider').val('');
    $('#lider1').modal('show');
  } else {
    $('#numeroLider2').val('');
    $('#lider3').modal('show');
  }
}


function Validate_Delete(formId, formMsg, numeroEmpleado) {
  var valido = Validate_NumeroEmpleado(numeroEmpleado);

  if (valido) {
    $(formMsg).html('<div class="text-danger"> No existe el número de empleado! </div>');
    $(formId).find('[data-required]').each(function() {
      $(this).addClass('is-invalid');
    });
  } else {
    var usr = Validate_NumeroUsr(numeroEmpleado);

    if (usr == false) {
      $(formMsg).html('<div class="text-danger"> El número de usuario es líder de almacén! </div>');
    } else {
      $('#eliminar1').modal('hide');
      $('#eliminar2').modal('show');
      $('#SE').html('<h5> Seguro que desea eliminar a: <b>' + numeroEmpleado + '</b> ? </h5>');
    }
  }
}

function DeleteOperador(numeroEmpleado) {
  var dataString = 'numero_empleado=' + numeroEmpleado;
  $.ajax({
    url: '../php/operadores/operadoresDelete.php',
    type: 'post',
    data: dataString,
    success: function(data) {
      $('#eliminar2').modal('hide');
      $('#exito').modal('show');
      $('#inputEliminar').val('');
    },
    error: function(error) {
      alert("No fue posible realizar esa acción");
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

  if (num) {
    $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> No existe el número de empleado! </div>');
    $(formId).find('[data-required]').each(function() {
      $(this).addClass('is-invalid');
    });
  } else {
    var usr = Validate_NumeroUsr(numeroEmpleado);

    if (!usr) {
      $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> El número de empleado ya es líder de almacén! </div>');
    } else {
      resetForm('#lider2Form', '#lider2Msg');
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

      if (data[1] == 1) {
        $("#modificarActivo1").prop("checked", true);
        $("#modificarActivo2").prop("checked", false);
      } else {
        $("#modificarActivo1").prop("checked", false);
        $("#modificarActivo2").prop("checked", true);
      }
    },
    error: function(error) {
      alert("No fue posible realizar esa acción");
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

    var actividad = "&actividad_usr=";

    if (document.getElementById('modificarActivo1').checked) {
      actividad += "1";
    } else {
      actividad += "0";
    }

    var dataString = 'numero_empleado=' + numeroEmpleado + actividad + "&" + $(formId).serialize();
    $.ajax({
      url: '../php/operadores/operadoresUpdate.php',
      type: 'post',
      data: dataString,
      success: function(data) {
        $('#modificar2').modal('hide');
        $('#exito').modal('show');
        $('#inputCambiar').val('');
      },
      error: function(error) {
        alert("No fue posible realizar esa acción");
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

  var pwd2 = $('#lider2Password').val();
  var pwd1 = $('#lider2Password2').val();

  if (pwd1 != pwd2) flag = 2;

  if (flag == 1) {
    $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> Todos los campos son necesarios! </div>');
    return false;
  } else if (flag == 2) {
    $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> La contraseña no es la misma! </div>');
    $('#lider2Password2').addClass('text-danger');
  } else {
    var dataString = 'numero_empleado=' + numeroEmpleado + "&" + $(formId).serialize();
    $.ajax({
      url: '../php/operadores/operadoresLider.php',
      type: 'post',
      data: dataString,
      success: function(data) {
        $('#lider2').modal('hide');
        $('#exito').modal('show');
        resetForm(formId, formMsg);
      },
      error: function(error) {
        alert("No fue posible realizar esa acción");
      }
    });
  }
}


function Validate_Lider2(formId, formMsg, numeroEmpleado) {
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
    var usr = Validate_NumeroUsr(numeroEmpleado);

    if (usr) {
      $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> El número de empleado no es líder de almacén! </div>');
    } else {
      $('#lider3').modal('hide');
      $('#lider4Msg').html('<b>' + numeroEmpleado + '</b>');
      $('#lider4').modal('show');
      //onclick="return DeleteOperador($('#inputEliminar').val());"
    }
  }
}


function resetForm(formActual, formMsg) {
  $(formMsg).html('');

  if (formMsg == "#lider1Msg") {
    $(formMsg).html('<div class="text-secondary"> El número de empleado debe ser parte de los operadores</div>');
  } else {
    $(formMsg).html('');
  }

  $(formActual).find('[data-required]').each(function() {
    $(this).removeClass('is-invalid');
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
  }
  else valueReturn = true;

  return valueReturn;
}

function DeleteLider(numeroEmpleado) {
  var posible = Validate_Cantidad(numeroEmpleado);

  if (posible > 1) {

    var dataString = 'numero_empleado=' + numeroEmpleado;
    $.ajax({
      url: '../php/operadores/operadoresDeleteLider.php',
      type: 'post',
      data: dataString,
      success: function(value) {
        $('#lider4').modal('hide');
        $('#numeroLider2').val('');
        $('#exito').modal('show');
      }
    });
  } else {
    $('#lider4').modal('hide');
    resetForm('#numeroLiderForm2', '#lider3Msg');
    alert("No es posible borrar al líder de almacén");
  }
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
      dataType: "json",
      success: function(value) {
        valueReturn = (value[0] == 0) ? true : false;
      }
    });
  } else {
    valueReturn = true;
  }

  return valueReturn;
}


function Validate_Cantidad(actual) {
  var valueReturn;

  var dataString = 'numero_empleado=' + actual;
  $.ajax({
    async: false,
    url: '../php/operadores/operadoresUsuario.php',
    type: 'post',
    data: dataString,
    dataType: "json",
    success: function(value) {
      if (value[1] == 0) value[1] += 2;
      valueReturn = value[1];
    }
  });

  return valueReturn;
}

function Validate_Number(numero) {
  let isnum = /^\d+$/.test(numero);
  return isnum;
}
