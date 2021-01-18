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
                console.log(xhr.responseText);
                if(xhr.responseText == "ERROR_CSV"){
                    alert("Se debe subir un archivo CSV");
                }
                else if(xhr.responseText == "ERROR_TIPO"){
                    alert("Verifica que el archivo sea del control de distribución");
                }
                location.reload();
        }
    };
    fd.append('file_name', archivo);
    fd.append('num_cols',3);
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
function initModal(){
    document.getElementById("btn-archivo").disabled=true;
    document.getElementById("targetLayer").innerHTML = document.getElementById("modalInicio").innerHTML;
}