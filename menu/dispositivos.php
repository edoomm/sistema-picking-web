<?php
  include_once "../php/db.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Dispositivos</title>
    <meta name='viewport'
        content='width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no' />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <style>
        .navbar-custom{
            background-color:#1e4f9e;
        }
        .margin-custom{
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
            <img src="./resources/grand_vision.png" alt="" width="100" class="d-inline-block align-top">
                <h1 style="color:beige">Dispositivos</h1>
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
                        Lista de dispositivos
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <input class="form-control mb-4" id="busqueda" onkeyup="filtrar()" type="text" placeholder="Ingresa el numero de serie del dispositivo " required
                            pattern="^[0-9]{1,17}$">
                            <table class="table table-hover" id="tablaDispositivos">
                                <thead>
                                    <tr>
                                        <th scope="col">Número de serie</th>
                                        <th scope="col">Encargado</th>
                                        <th scope="col">Activo</th>
                                    </tr>
                                </thead>
                                <tbody id="dispositivo"></tbody>
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
                            <h2>
                                    Información del dispositivo seleccionado
                            </h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo</label>
                                <input type="text" class="form-control" id="tipo" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="numeroSerie" class="form-label">Número de Serie</label>
                                <input type="text" class="form-control" id="numeroSerie" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="encargado" class="form-label">Encargado</label>
                                <input type="text" class="form-control" id="encargado" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Activo</label>
                                <input type="text" class="form-control" id="estado" disabled>
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
                  <h5 class="modal-title" id="exampleModalLabel">Registro de dispositivos</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                  <em id="dispositivosMsg"></em>
                  <form class="row g-3" name="Registrar" id="Registrar" method="POST" onSubmit="return false;">
                    <div class="col-12">
                      <label for="inputNumeroSerie" class="form-label">Número de serie del dispositivo<span class="text-danger">*</span> </label>
                      <input type="text" class="form-control" id="inputNumeroSerie" name="inputNumeroSerie" placeholder="Número de serie del dispositivo" data-required>
                    </div>
                    <div class="col-12">
                      <label for="inputEncargado" class="form-label">Número del empleado encargado.<span class="text-danger">*</span> </label>

                      <label><select class="form-select" id="inputEncargado" name="inputEncargado" type="text" data-required>
                        <option value="">Seleccione al encargado de este dispositivo.</option>
                        <?php
                              $link = open_database();
                              foreach ($link->query('SELECT * from operador') as $row){
                        ?>

                              <option value="<?php echo $row['num_empleado'] ?>"><?php echo $row['num_empleado'] ?>
                                <label> Operador: </label><?php echo $row['nombre'] ?>
                              </option>
                        <?php
                            }
                            $link->close();
                        ?>
                      </select> </label>
                    </div>
                    <div class="col-12">
                      <label for="inputEncargado" class="form-label">Tipo (Seleccione una opción)<span class="text-danger">*</span> </label>
                      <select class="form-select" id="inputTipo" name="inputTipo" type="text" data-required>
                        <option value="">Seleccione el tipo del dispositivo</option>
                        <option selected>Escáner</option>
                        <option selected>Tablet</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <label for="inputEstado" class="form-label">Activo (Seleccione una opción)<span class="text-danger">*</span> </label>
                      <select class="form-select" id="inputEstado" name="inputEstado" type="text" data-required>
                        <option value="">Seleccione el estado del dispositivo</option>
                        <option selected>1 <label for="">SI</label></option>
                        <option selected>0 <label for="">NO</label></option>
                      </select>
                    </div>

                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onClick="resetForm('#Registrar')">Cerrar</button>
                  <button type="button" name="submit2" id="submit2" class="btn btn-primary" onClick="return formValidate('#Registrar','#dispositivosMsg',$('#inputNumeroSerie').val());">Guardar</button>
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
                            <h5 class="modal-title" id="exampleModalLabel">Modificación de Dispositivos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                          <em id="ModificarMsg"></em>
                          <form class="row g-3" name="Cambiar" id="Cambiar" method="POST" onSubmit="return false;">
                            <div class="col-md-12">
                              <label for="inputCambiar" class="form-label"> Número de serie del dispositivo <span class="text-danger">*</span> </label>
                              <input type="text" class="form-control" id="inputCambiar" name="inputCambiar" placeholder="Número de serie" data-required>
                            </div>
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onClick="resetForm('#Cambiar')">Cerrar</button>
                          <button type="button" name="submit4" id="submit4" class="btn btn-primary" onClick="return Validate_Modify('#Cambiar','#ModificarMsg',$('#inputCambiar').val());"> Buscar </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" name="modificar2" id="modificar2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modificación de dispositivos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                  </div>
                  <div class="modal-body">
                    <em id="ModificarMsg2"></em>
                    <form class="row g-3" name="Modificar" id="Modificar" method="POST" onSubmit="return false;">
                      <!--<div class="col-md-12">
                        <label for="modificarEncargado" class="form-label">Encargado del dispositivo<span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" id="modificarEncargado" name="modificarEncargado" placeholder="Encargado del dispositivo">
                      </div>-->
                      <div class="col-md-12">
                        <label for="modificarEncargado" class="form-label">Número del nuevo encargado.<span class="text-danger">*</span> </label>

                        <label><select class="form-select" id="modificarEncargado" name="modificarEncargado" type="text" data-required>
                          <option value="">Seleccione al encargado de este dispositivo.</option>
                          <?php
                                $link = open_database();
                                foreach ($link->query('SELECT * from operador') as $row){
                          ?>

                                <option value="<?php echo $row['num_empleado'] ?>"><?php echo $row['num_empleado'] ?>
                                  <label> Operador: </label><?php echo $row['nombre'] ?>
                                </option>
                          <?php
                              }
                              $link->close();
                          ?>
                        </select> </label>
                      </div>
                    
                      <div class="col-md-12">
                        <label for="modificarEstado" class="form-label">Activo (Seleccione una opción)<span class="text-danger">*</span> </label>
                        <select class="form-select" id="modificarEstado" name="modificarEstado" type="text" data-required>
                          <option value="">Seleccione el estado del dispositivo</option>
                          <option selected>1 <label for="">SI</label></option>
                          <option selected>0 <label for="">NO</label></option>
                        </select>
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
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar dispositivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                  </div>
                  <div class="modal-body">
                    <em id="EliminarMsg"></em>
                    <form class="row g-3" name="Eliminar" id="Eliminar" method="POST" onSubmit="return false;">
                      <div class="col-md-12">
                        <label for="inputEliminar" class="form-label"> Número de serie del dispositivo <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" id="inputEliminar" name="inputEliminar" placeholder="Número de serie" data-required>
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
                  <h5 class="modal-title" id="exampleModalLabel">Eliminar dispositivo</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>

                <div class="modal-body">
                  <div class="col-md-12">
                    <h5> ¿Seguro que desea eliminar este dispositivo? : <em id="SE" name="SE"></em> </h5>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  <button class="btn btn-primary" type="button" onclick="return DeleteDispositivo($('#inputEliminar').val());"> Borrar </button>
                </div>
              </div>
            </div>
          </form>
        </div>
    </main>

    <footer>

    </footer>

    <!-- For better performance this script should go at the very bottom of the body -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"> </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/dispositivos1.js"></script>
    <script src="../js/initFile.js"></script>

<script>
    $.post("../php/mostrarElementosBD.php", {
          variable: "Dispositivo",
          columnas: "dispositivo_id,operador_num_empleado,activo",
          condicion: "dispositivo_id=dispositivo_id"
        },
        function(data) {
          document.getElementById("dispositivo").innerHTML = data;
          rowHandlers(
            ["tipo", "numeroSerie","encargado","estado"],
            "tipo,dispositivo_id,operador_num_empleado,activo",
            "dispositivo",
            ["dispositivo_id", 0],
            "Dispositivo"
          );
        }
      );
      /*window.onload = init(
      ["tipo", "numeroSerie","encargado","estado"],
      "tipo,dispositivo_id,operador_num_empleado",
      "Dispositivo",
      "dispositivo",
      "tipo,dispositivo_id,operador_num_empleado",
      ["dispositivo_id", 0]
      );*/
</script>

</body>
</html>