function filtrar() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("busqueda");
    filter = input.value.toUpperCase();
    table = document.getElementById("serie");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3];
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
function removeDragData(event){
    if(event.dataTransfer.items){
        event.dataTransfer.items.clear();
    }
    else{
        event.dataTransfer.clearData();
    }
}

function limpiarFormularioContenedores()
{
    document.getElementById("contenedorForm").reset();
}

function mensaje(tipo,icono,titulo,texto)
{
  if(tipo == 1)
  {
    swal({
      icon: icono,
      title: titulo,
    }).then(function()
    {
      window.location.reload();
    });
  }
  else
  {
    swal({
      icon: icono,
      title: titulo,
      text: texto
    }).then(function()
    {
      window.location.reload();
    });
  }
}

function generarContenedores()
{
    var numeroContenedores = document.getElementById("numeroContenedores").value;
    if(!isNaN(numeroContenedores) && numeroContenedores > 0)
    {
        numeroContenedores = parseInt(numeroContenedores);
        const uri = '../php/apartados/generarContenedores.php';
        const xhr  = new XMLHttpRequest();
        const fd = new FormData();
        xhr.open("POST", uri, true);
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                if(!isNaN(xhr.responseText))
                {
                    swal({
                        icon: "success",
                        title: "Se realizo la operación con exito",
                        text: "Crea los contenedores desde el "+xhr.responseText,
                      }).then(function()
                      {
                        window.open("https://barcode.tec-it.com/en/Code128?");
                        window.location.reload();
                      });
                }
                else
                {
                    mensaje(2,"error","Hubo un error al realizar la operación",xhr.responseText);
                }
            }
        };
        fd.append('num',numeroContenedores);
        xhr.send(fd);
    }
    else
    {
        mensaje(1,"error","El número de contenedores debe ser un número mayor a 0","");
    }
}

var archivo;
function sendFile(){
    document.getElementById("targetLayer").innerHTML = document.getElementById("cargando").innerHTML;
    document.getElementById("btn-archivo").disabled = true;
    document.getElementById("btn-cancelar-archivo").disabled = true;
    const uri = "../php/apartados/cargarApartado.php";
    const xhr  = new XMLHttpRequest();
    const fd = new FormData();
    xhr.open("POST", uri, true);
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
                let res = JSON.parse(xhr.responseText);
                let hay_errores = false;
                let msg_error = String();
                let faltan = String();
                /*
                if(res['error_archivo']){
                    mensaje(1,"error","No se pudo cargar el archivo");
                    return;
                }*/
                if(res['error_sku_no_existe'].length > 0){
                    hay_errores = true;
                    msg_error += "Los siguientes SKU no se encuentran registrados:\n";
                    for(let i = 0; i < res['error_sku_no_existe'].length; i+=5){
                        for(let j = i; j < Math.min(i+5, res['error_sku_no_existe'].length); j++)
                            msg_error += (res['error_sku_no_existe'][j] + "\t\t\t");
                        msg_error += "\n";
                    }
                }
                if(res['error'] != null){
                    msg_error += res['error'] + "\n";
                }
                if(res['stock'].length > 0){
                    faltan += "Los siguientes SKU necesitan reabastecerse:\n";
                    for(let i = 0; i < res['stock'].length; i++)
                        faltan += "SKU: " + res['stock'][i][0] + " Faltan: " + res['stock'][i][1] + "\n"
                }
                if(hay_errores){
                    mensaje(2,"error", "Error", msg_error + faltan);
                }
                else{
                    if(faltan.length > 0){
                        mensaje(2,"success", "El archivo se ha cargado con éxito", faltan)
                    }
                    else{
                        mensaje(1,"success","El archivo se ha cargado con éxito");
                    }
                }
        }
    };
    fd.append('file_name', archivo);
    fd.append('tipo',3);
    xhr.send(fd);
}
function dropHandler(event){
    event.preventDefault();
    document.getElementById("btn-archivo").disabled = false;
    var nombreDeArchivos = [];
    if(event.dataTransfer.items){
        for(var i = 0; i < event.dataTransfer.items.length; i++){
            if(event.dataTransfer.items[i].kind == 'file'){
                var file = event.dataTransfer.items[i].getAsFile();
                archivo = event.dataTransfer.items[i].getAsFile();
                nombreDeArchivos.push(file.name);
            }
        }
        for(var i = 0; i < nombreDeArchivos.length; i++){
            document.getElementById("mostrarNombreArchivo").textContent += nombreDeArchivos[i] + " ";
        }
        document.getElementById("targetLayer").innerHTML = document.getElementById("archivoCargado").innerHTML;
        removeDragData(event);
    }
}
const op_act = new Set();
function mostrarOperadores(){
    document.getElementById("asignarApartadosBoton").disabled = true;
    document.getElementById("asignarApartadosBotonCancelar").disabled = false;
    $.post("../php/apartados/cargarOperadores.php", function(data){
        document.getElementById("zonaCheckBoxesEmpleados").innerHTML = data;
        document.getElementById("asignarApartadosMensaje").innerHTML = document.getElementById("checkBoxesEmpleados").innerHTML;
    }).fail(function(){
        alert('Hubo un error con la Base de Datos')
    }).done(function(){
        let checkboxes = document.querySelectorAll("input[name=operadores]");
        checkboxes.forEach(function(checkbox){
            checkbox.addEventListener('change',function(){
                if(this.checked){
                    op_act.add($(this).val());
                    document.getElementById("asignarApartadosBoton").disabled=false;
                }
                else{
                    op_act.delete($(this).val());
                }
                if(op_act.size == 0){
                    document.getElementById("asignarApartadosBoton").disabled=true;
                }
            });
        });
    });
}
function asignacionAutomatica(){
    document.getElementById("asignarApartadosMensaje").innerHTML = document.getElementById("cargando").innerHTML;
    document.getElementById("asignarApartadosBoton").disabled = true;
    document.getElementById("asignarApartadosBotonCancelar").disabled = true;
    let operadores = [];
    for(let item of op_act){
        operadores.push(item);
    }
    op_act.clear();
    console.log(operadores);
    $.post("../php/apartados/asignacionAutomatica.php", {
        operadores : JSON.stringify(operadores)
    },
    function(data){
        console.log(data);
    }
    ).fail(function(){
        alert('Hubo un error')
    }).done(function(){
        document.getElementById("asignarApartadosMensaje").innerHTML="<p> Se han asignado con éxito</p>";
        document.getElementById("asignarApartadosBotonCancelar").disabled = false;
    })
}
    
async function mostrarAsignadas(){        
    await $.post("../php/mostrarElementosBD.php", {
            variable: "Control",
            columnas : "control_id,sku,numero_control,id_sucursal,apartado",
            condicion : "estado=1",
        },
        function(data){
            if(data==""){
                alert("No hay apartados asignados");
            }
            else{
                document.getElementById("serie").innerHTML = data;
                rowHandlers(
                    ["control_id", "sku", "numero_control", "id_sucursal","apartado"],
                    "control_id,sku,numero_control,id_sucursal,apartado",
                    "serie",
                    ["control_id",0],
                    "Control"
                );
            }
        }
    );

}
async function mostrarSinAsignar(){
    await $.post("../php/mostrarElementosBD.php", {
            variable: "Control",
            columnas : "control_id,sku,numero_control,id_sucursal,apartado",
            condicion : "estado=0",
        },
        function(data){
            if(data==""){
                alert("No hay apartados sin asignar");
            }
            else{
                document.getElementById("serie").innerHTML = data;
                rowHandlers(
                    ["control_id", "sku", "numero_control", "id_sucursal","apartado"],
                    "control_id,sku,numero_control,id_sucursal,apartado",
                    "serie",
                    ["control_id",0],
                    "Control"
                );
            }
        }
    );
}
function download(filename, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);

    element.style.display = 'none';
    document.body.appendChild(element);

    element.click();

    document.body.removeChild(element);
}
function generarReporte(){
    $.post("../php/apartados/generarReporte.php",{},
      function(data){
          data = JSON.parse(data);
          if(data['error'] != null && data['error'].length > 0){
              mensaje(1,"error","Hubo un error al generar el archivo", "");
          }
          else{
            mensaje(1,"success","Archivo generado con exito", "");
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); 
            var yyyy = today.getFullYear();
            today = mm + '-' + dd + '-' + yyyy;
            download('reporte' + today + '.csv', data['archivo']);
          }
      }  
    );
}
function initModal(){
    document.getElementById("btn-archivo").disabled=true;
    document.getElementById("targetLayer").innerHTML = document.getElementById("modalInicio").innerHTML;
}

function showOperators() {
    $.get("../php/apartados/getOperadores.php").done(e=>{
        var array = JSON.parse(e);
        array = array.reverse();
        array.push("Selecciona Operador");
        array = array.reverse();
        const options = [];
        for (const e of array) {
            options.push(`<option>${e}</option>`)
        }
        document.getElementById("zonaSelectEmpleados").innerHTML = options.join();
    }).fail((xhr,status,error)=>{
        alert("Error al listar operadores")
    })
}

function onchangeSelectOperators() {

    var idEmpleado = document.getElementById("zonaSelectEmpleados").value;
    var divControls = document.getElementById("numControl");
    var tableControls = document.getElementById("assignedControls");

    if (idEmpleado == "Selecciona Operador") {
        divControls.innerHTML = `Numero de controles asignados`
        tableControls.innerHTML = ``
        return;
    }

    idEmpleado = idEmpleado.split("-")[0];


    //obtener número de controles
    //var nControles = 25;

    

    divControls.innerHTML = `Numero de controles asignados: ${idEmpleado}` //prueba para probar función 
    showControls();
}

function showControls(){
        $.post("../php/mostrarElementosBD.php", {
        variable: "Control",
        columnas : "control_id,numero_control,id_sucursal",
        condicion : "estado=1",
    },
    function(data){
        if(data==""){
            alert("No hay apartados asignados");
        }
        else{
            document.getElementById("assignedControls").innerHTML = data;
            rowHandlers(
                ["control_id", "numero_control", "id_sucursal"],
                "control_id,numero_control,id_sucursal",
                "assignedControls",
                ["control_id",0],
                "Control"
            );
        }
    }
    );
}
//me falta hacer un post para pintar en pantalla cuando se seleccione un operador y calcular el numero de apartados que le fueron asignados
