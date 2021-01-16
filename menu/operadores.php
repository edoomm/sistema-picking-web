<?php
  include_once "../php/db.php";
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Operadores</title>
  <meta name='viewport' content='width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no' />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <style>
    .navbar-custom {
      background-color: #1e4f9e;
    }

    .margin-custom {
      margin-top: 120px;
      margin-left: 10px;
      margin-right: 10px;
    }
  </style>

</head>

<body>
  <header>

  </header>

  <main>
    <nav class="navbar  navbar-expand-lg navbar-custom fixed-top">
      <div class="collapse navbar-collapse container-fluid">
        <img src="./resources/grand_vision.jpg" alt="" width="100" class="d-inline-block align-top">
        <h1 style="color:beige">Operadores</h1>
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link nav-brand" href="menuPrincipal.html" style="color:beige">Menú principal</a></li>
          <li class="nav-item"><a class="nav-link nav-brand" href="../index.html" style="color:beige">Cerrar sesión</a></li>
        </ul>
      </div>
    </nav>
    <div class="row margin-custom">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            Lista de operadores
          </div>
          <div class="card-body">
            <div class="container">
              <input class="form-control mb-4" id="busqueda" onkeyup="filtrar()" type="text" placeholder="Ingresa el número de empleado" pattern="^[0-9]{6}$">
              <table class="table table-hover" id="tablaOperadores">
                <thead>
                  <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Número de empleado</th>
                  </tr>
                </thead>
                <tbody id="operador">
                  <?php
                        $link = open_database();
                        foreach ($link->query('SELECT * from operador') as $row){
                  ?>
                  <tr>
                    <td><?php echo $row['nombre'] ?></td>
                    <td><?php echo $row['num_empleado'] ?></td>
                  </tr>
                  <?php
                      }
                      $link->close();
                  ?>

                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-4">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#registro">Registrar</button>
              </div>
              <div class="col-sm-4">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modificar1">Modificar</button>
              </div>
              <div class="col-sm-4">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#eliminar1"> Eliminar </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            <div class="text-center">
              <img src="./resources/example.png" alt="" width="150" class="img-fluid" style="padding:1%">
              <h2>
                Información del empleado seleccionado
              </h2>
            </div>
          </div>
          <div class="card-body">
            <form>
              <div class="mb-3">
                <label for="nombre_operador" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre_operador">
              </div>
              <div class="mb-3">
                <label for="numero_empleado" class="form-label">Número de empleado</label>
                <input type="text" class="form-control" id="numero_empleado">
              </div>
              <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="email" class="form-control" id="usuario">
              </div>
              <div class="row">
                <div class="mb-3 col-sm-6">
                  <label for="horario_entrada" class="form-label">Horario entrada</label>
                  <input type="time" class="form-control" id="horario_entrada">
                </div>
                <div class="mb-3 col-sm-6">
                  <label for="horario_salida" class="form-label">Horario salida</label>
                  <input type="time" class="form-control" id="horario_salida">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" name="registro" id="registro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Registro de operador</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
          </div>
          <div class="modal-body">
            <em id="operadoresMsg"></em>
            <form class="row g-3" name="Registrar" id="Registrar" method="POST" onSubmit="return false;">
              <div class="col-12">
                <label for="inputNombre" class="form-label">Nombre <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre completo del empleado" data-required>
              </div>
              <div class="col-12">
                <label for="inputNumeroEmpleado" class="form-label">Número del empleado <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" id="inputNumeroEmpleado" name="inputNumeroEmpleado" placeholder="Número del empleado" data-required>
              </div>
              <div class="col-md-12">
                <label for="inputCorreo" class="form-label"> Correo <span class="text-danger">*</span> </label>
                <input class="form-control" id="inputCorreo" name="inputCorreo" placeholder="Correo">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onClick="resetForm('#Registrar')">Cerrar</button>
            <button type="button" name="submit2" id="submit2" class="btn btn-primary" onClick="return formValidate('#Registrar','#operadoresMsg',$('#inputNumeroEmpleado').val());">Guardar</button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="exito" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Anuncio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            <h5 class="modal-title text-center" id="exampleModalLabel"> Operación realizada con exito </h5>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick=" location.reload();">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" name="modificar1" id="modificar1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modificar operador</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
          </div>
          <div class="modal-body">
            <em id="CambiarMsg"></em>
            <form class="row g-3" name="Cambiar" id="Cambiar" method="POST" onSubmit="return false;">
              <div class="col-md-12">
                <label for="inputCambiar" class="form-label"> Número de empleado <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" id="inputCambiar" name="inputCambiar" placeholder="Número de empleado" data-required>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onClick="resetForm('#Cambiar')">Cerrar</button>
            <button type="button" name="submit4" id="submit4" class="btn btn-primary" onClick="return Validate_Modify('#Cambiar','#CambiarMsg',$('#inputCambiar').val());"> Buscar </button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" name="modificar2" id="modificar2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modificación o de operador</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
          </div>
          <div class="modal-body">
            <em id="ModificarMsg2"></em>
            <form class="row g-3" name="Modificar" id="Modificar" method="POST" onSubmit="return false;">
              <div class="col-md-12">
                <label for="modificarCorreo" class="form-label"> Correo <span class="text-danger">*</span> </label>
                <input type="email" class="form-control" id="modificarCorreo" name="modificarCorreo" placeholder="Correo">
              </div>
              <div class="col-12">
                <label for="modificarNombre" class="form-label">Nombre <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" id="modificarNombre" name="modificarNombre" placeholder="Nombre completo del empleado" data-required>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onClick="resetForm('#Modificar')">Cerrar</button>
            <button type="button" name="submit5" id="submit5" class="btn btn-primary" onClick="return Validate_Form2('#Modificar','#ModificarMsg2',$('#inputCambiar').val());">Guardar</button>
          </div>
        </div>
      </div>
    </div>




    <div class="modal fade" name="eliminar1" id="eliminar1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Eliminar operador</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
          </div>
          <div class="modal-body">
            <em id="EliminarMsg"></em>
            <form class="row g-3" name="Eliminar" id="Eliminar" method="POST" onSubmit="return false;">
              <div class="col-md-12">
                <label for="inputEliminar" class="form-label"> Número de empleado <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" id="inputEliminar" name="inputEliminar" placeholder="Número de empleado" data-required>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onClick="resetForm('#Eliminar')">Cerrar</button>
            <button type="button" name="submit3" id="submit3" class="btn btn-primary" onClick="return Validate_Delete('#Eliminar','#EliminarMsg',$('#inputEliminar').val());"> Eliminar </button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="eliminar2" name="eliminar1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <form name="ChangeSubject" id="ChangeSubject" method="post">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Eliminar operador</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>

            <div class="modal-body">
              <div class="col-md-12">
                <h5> Seguro que desea eliminar al operador : <em id="SE" name="SE"></em> </h5>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button class="btn btn-primary" type="button" onclick="return DeleteOperador($('#inputEliminar').val());"> Borrar </button>
            </div>
          </div>
        </div>
      </form>
    </div>



    <div class="col align-self-center container ">
      <canvas id="miGrafico"></canvas>
    </div>


  </main>

  <footer>

  </footer>

  <!-- For better performance this script should go at the very bottom of the body -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"> </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="../js/operadores.js"></script>

  <script>
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

    function init() {
      document.getElementById("numero_empleado").value = "";
      document.getElementById("numero_empleado").disabled = true;
      document.getElementById("nombre_operador").value = "";
      document.getElementById("nombre_operador").disabled = true;
      document.getElementById("usuario").value = "";
      document.getElementById("usuario").disabled = true;
      document.getElementById("horario_entrada").value = ""
      document.getElementById("horario_entrada").disabled = true;
      document.getElementById("horario_salida").value = ""
      document.getElementById("horario_salida").disabled = true;
      document.getElementById("busqueda").value = "";
      rowHandlers();
    }
    /*
        usuario
        horario_entrada
        horario_salida
    */

    function llenarFormulario(row) {
      console.log(row[0]);
      console.log(row[1]);
      document.getElementById("numero_empleado").value = row[0];
      document.getElementById("numero_empleado").disabled = true;
      document.getElementById("nombre_operador").value = row[1];
      document.getElementById("nombre_operador").disabled = true;
      document.getElementById("usuario").value = "Juanito"
      document.getElementById("usuario").disabled = true;
      document.getElementById("horario_entrada").value = "15:30"
      document.getElementById("horario_entrada").disabled = true;
      document.getElementById("horario_salida").value = "18:30"
      document.getElementById("horario_salida").disabled = true;
    }

    function rowHandlers() {
      //cleanForm();
      var table = document.getElementById("tablaOperadores");
      var rows = table.getElementsByTagName("tr");
      for (var i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var clickHandler = function(row) {
          return function() {
            var cells = row.getElementsByTagName("td");
            var fila = [];
            for (var j = 0; j < cells.length; j++) {
              console.log(cells[j].innerHTML);
              fila.push(cells[j].innerHTML);
            }
            llenarFormulario(fila);
          };
        };
        currentRow.onclick = clickHandler(currentRow);
      }
    }
    window.onload = init();
  </script>

  <script>
    $(document).ready(function() {
      var datosTotal = 6;
      var coloR = [];

      for (var i = 0; i < datosTotal; i++) {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        coloR.push("rgb(" + r + "," + g + "," + b + ")");
      }

      $.ajax({
        url: "../php/operadores/operadoresGrafica.php",
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "POST",
        success: function(data) {
          var mostrar = $("#miGrafico");
          var grafico = new Chart(mostrar, {
            type: 'bar',
            data: {
              labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
              datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: coloR,
                borderColor: coloR,
                borderWidth: 1
              }]
            },
            options: {
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
        }
      });
    });
  </script>

</body>

</html>