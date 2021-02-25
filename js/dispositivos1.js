function filtrar() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("busqueda");
  filter = input.value.toUpperCase();
  table = document.getElementById("dispositivo");
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

function formValidate(formId, formMsg, numeroDeSerie) {
  var flag = 0;

  $(formId).find('[data-required]').each(function() {
    var actual = $(this).val();

    if (actual === "") {
      $(this).addClass('is-invalid');
      flag = 1;
    } else {
      if (actual == numeroDeSerie) {
        if (!Validate_NumeroDeSerie(actual)) flag = 2;
      }
    }
  });

  if (flag == 1) {
    $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> Todos los campos son necesarios! </div>');
    return false;
  } else if (flag == 2) {
    $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> Error con el número de serie del dispositivo! </div>');
    $(inputNumeroSerie).addClass('is-invalid');
    return false;
  } else {
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
    url: '../php/dispositivos/dispositivosInsert1.php',
    data: $(formID).serialize(),
    success: function(data) {
      console.log(data);
      $('#registro').modal('hide');
      $('#exito').modal('show');
    }
    
  });
}


function Validate_Delete(formId, formMsg, numeroDeSerie) {
  var valido = Validate_NumeroDeSerie(numeroDeSerie);

  if (valido) {
    $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> ¡No existe el número de serie del dispositivo! </div>');
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
    $('#SE').html('<b>' + numeroDeSerie + '</b>');
  }
  return false;
}

function DeleteDispositivo(numeroDeSerie) {
  var dataString = 'numeroSerie=' + numeroDeSerie;
  $.ajax({
    url: '../php/dispositivos/dispositivosDelete1.php',
    type: 'post',
    data: dataString,
    success: function(value) {
      $('#eliminar2').modal('hide');
      $('#exito').modal('show');
    }
  });
}


function Validate_Modify(formId, formMsg, numeroDeSerie) {
  var valido = Validate_NumeroDeSerie(numeroDeSerie);
  // of validao == false i can work with it
  if (valido) {
    $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> ¡No existe el número de serie del dispositivo! </div>');
    $(formId).find('[data-required]').each(function() {
      $(this).addClass('is-invalid');
    });
  } else {
    $('#modificar1').modal('hide');
    fillForm(formId, formMsg, numeroDeSerie);
  }
  return false;
}

//Aqui lleno el formulario con los datos que ya tengo
function fillForm(formID, formMsg, numeroDeSerie) {
  var dataString = 'numeroSerie=' + numeroDeSerie;
  $.ajax({
    url: '../php/dispositivos/dispositivosModify1.php',
    type: 'post',
    data: dataString,
    dataType: "json",
    success: function(data) {
      $('#modificarEncargado').val(data[0]);
      $('#modificarEstado').val(data[2]);
    }
  });
  $('#modificar2').modal('show');
}

//Aqui tengo que hacer el update de el usuario en la base de datos
function Validate_Form2(formId, formMsg, numeroDeSerie) {
  var flag = 0;

  $(formId).find('[data-required]').each(function() {
    var actual = $(this).val();

    if (actual === "") {
      $(this).addClass('is-invalid');
      flag = 1;
    }
  });
  if (flag == 1) {
    $(formMsg).html('<div class="text-danger"><i class="fa fa-exclamation-circle"></i> ¡Todos los campos son necesarios! </div>');
    return false;
  } else {
    var dataString = 'numeroSerie=' + numeroDeSerie + "&" + $(formId).serialize();
    $.ajax({
      url: '../php/dispositivos/dispositivosUpdate1.php',
      type: 'post',
      data: dataString,
      success: function(data) {
        $('#modificar2').modal('hide');
        $('#exito').modal('show');
        console.log(data);
      }
    });
  }
}

function resetForm(formActual) {
  $(formActual).find('[data-required]').each(function() {
    $(this).val('');
  });
}

function Validate_NumeroDeSerie(actual) {
  var valueReturn;

  if (actual.length >=10 && actual.length <=17 && !isNaN(actual)) {

    var dataString = 'numeroSerie=' + actual; 
    $.ajax({
      async: false,
      url: '../php/dispositivos/dispositivosR1.php',
      type: 'post',
      data: dataString,
      success: function(value) {
        valueReturn = (value) ? true : false;
      }
    });
  } else {
    valueReturn = false;
  }

  return valueReturn;
}
