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

function limpiarFormulario(id)
{
    document.getElementById(id).reset();

}

function iniciarCargaArchivo(tipo)
{
  if(tipo == 1)
  {
    document.getElementById("btn-archivoInventario").disabled=true;
    document.getElementById("targetLayerInventario").innerHTML = document.getElementById("modalInicioInventario").innerHTML;
  }
  else
  {
    document.getElementById("btn-archivoUbicacion").disabled=true;
    document.getElementById("targetLayerUbicacion").innerHTML = document.getElementById("modalInicioUbicacion").innerHTML;
  }
  
}

function validarFormulario()
{
  console.log("hola");
  let sku = document.getElementById("inputSKU").value;
  let ubicacion = document.getElementById("inputUbicacion").value;
  let descripcion = document.getElementById("inputDescripcion").value;
  let stock = document.getElementById("inputStock").value;
  let medida = document.getElementById("inputMedida").value;
  let id_linea = document.getElementById("inputLinea").value;
  let generico = document.getElementById("inputGenerico").value;
  
}

function removeDragData(event){
  if(event.dataTransfer.items)
  {
    event.dataTransfer.items.clear();
  }
  else
  {
    event.dataTransfer.clearData();
  }
}

var archivo;

function sendFile(ubicacion,tipo){
  if($('#subirArchivoInventario').is(':visible'))
  {
    console.log("Entra");
    document.getElementById("targetLayerInventario").innerHTML = document.getElementById("cargandoInventario").innerHTML;
    document.getElementById("btn-archivoInventario").disabled = true;
    document.getElementById("btn-cancelarInventario").disabled = true;
  }
  else
  {
    document.getElementById("targetLayerUbicacion").innerHTML = document.getElementById("cargandoUbicacion").innerHTML;
    document.getElementById("btn-archivoUbicacion").disabled = true;
    document.getElementById("btn-cancelarUbicacion").disabled = true;
  }
  const uri = ubicacion;
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
              if(tipo == 1)
                  alert("Verifica que el archivo sea del inventario");
              else
                  alert("Verifica que el archivo sea de las ubicaciones");
          }
          location.reload();
      }
  };
  fd.append('file_name', archivo);
  fd.append('tipo',tipo);
  xhr.send(fd);
}

function dropHandler(event){
  event.preventDefault();
  if($('#subirArchivoInventario').is(':visible'))
  {
    console.log("Entra");
    document.getElementById("btn-archivoInventario").disabled = false;
  }
  else
    document.getElementById("btn-archivoUbicacion").disabled = false;
  var nombreDeArchivos = [];
  if(event.dataTransfer.items)
  {
      for(var i = 0; i < event.dataTransfer.items.length; i++){
          if(event.dataTransfer.items[i].kind == 'file'){
              var file = event.dataTransfer.items[i].getAsFile();
              archivo = event.dataTransfer.items[i].getAsFile();
              nombreDeArchivos.push(file.name);
          }
      }
      if($('#subirArchivoInventario').is(':visible'))
      {
        
        for(var i = 0; i < nombreDeArchivos.length; i++)
        {
          document.getElementById("mostrarNombreArchivoInventario").textContent += nombreDeArchivos[i] + " ";
        }
        document.getElementById("targetLayerInventario").innerHTML = document.getElementById("archivoCargadoInventario").innerHTML;
        removeDragData(event);
      }
      else
      {
        
        for(var i = 0; i < nombreDeArchivos.length; i++)
        {
            document.getElementById("mostrarNombreArchivoUbicacion").textContent += nombreDeArchivos[i] + " ";
        }
        document.getElementById("targetLayerUbicacion").innerHTML = document.getElementById("archivoCargadoUbicacion").innerHTML;
        removeDragData(event);
      }
      removeDragData(event);
  }
}

function llenarFormularioMod()
{
    let sku = document.getElementById("sku").value;
    let ubicacion = document.getElementById("ubicacion").value;
    let descripcion = document.getElementById("descripcion").value;
    let stock = document.getElementById("stock").value;
    let medida = document.getElementById("medida").value;
    let id_linea = document.getElementById("id_linea").value;
    let generico = document.getElementById("generico").value;
    document.getElementById("modificarSKU").value = sku;
    document.getElementById("modificarUbicacion").value = ubicacion;
    document.getElementById("modificarDescripcion").value = descripcion;
    document.getElementById("modificarStock").value = stock;
    document.getElementById("modificarMedida").value = medida;
    document.getElementById("modificarLinea").value = id_linea;
    document.getElementById("modificarGenerico").value = generico;
}