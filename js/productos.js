var sku = document.getElementById("inputSKU");
var ubicacion = document.getElementById("inputUbicacion");
var descripcion = document.getElementById("inputDescripcion");
var stock = document.getElementById("inputStock");
var medida = document.getElementById("inputMedida");
var id_linea = document.getElementById("inputLinea");
var generico = document.getElementById("inputGenerico");
var skuMod = document.getElementById("modificarSKU");
var ubicacionMod = document.getElementById("modificarUbicacion");
var descripcionMod = document.getElementById("modificarDescripcion");
var stockMod = document.getElementById("modificarStock");
var medidaMod = document.getElementById("modificarMedida");
var id_lineaMod = document.getElementById("modificarLinea");
var genericoMod = document.getElementById("modificarGenerico");
var skuVal;
var ubicacionVal;
var descripcionVal;
var stockVal;
var medidaVal;
var id_lineaVal;
var genericoVal;

function filtrar() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("busqueda");
  filter = input.value.toUpperCase();
  table = document.getElementById("producto");
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

function generarUbicaciones()
{
  console.log(skuVal);
  var numCasillas = document.getElementById("numeroUbicaciones").value;
  if(numCasillas > 0 && !isNaN(numCasillas))
  {
    console.log(numCasillas);
    var casillas = "";
    for (i = 1; i <= numCasillas; i++) {
      casillas += '<div class="form-label-group"> <label for="ubicacion' + i + '">Ubicacion ' + i + '</label> <input type="text" id="ubicacion' + i + '" class="form-control" placeholder="A.01.01.0' + i + '" required autofocus></div> <div id="ubicacionError'+ i +'" class="invalid-feedback" style="margin-bottom: 0px;"><p></p></div>';
    }
    console.log(casillas);
    document.getElementById("ubicaciones").innerHTML = casillas;
  }
  else
  {
    swal({
      icon: "error",
      title: "El numero de casillas debe ser mayor a 0"
    });
  }
}

function validarUbicacion(ubicacionInput,ubicacionID,ubicacionErrorID)
{
  ubicacionID = document.getElementById(ubicacionID);
  let patron = /[A-Z]\.[0-9][0-9]\.0[1-4]\.0[2-8]$/;
  if(patron.test(ubicacionInput))
  {
    ubicacionID.classList.add('is-valid');
    return true;
  }
  else
  {
    ubicacionID.classList.add('is-invalid'); 
    document.getElementById(ubicacionErrorID).getElementsByTagName('p')[0].innerHTML = "Verifica el formato de la ubicación";
    return false;
  }
}

function llenarFormularioUbicacion()
{
  skuVal = document.getElementById("sku").value;
  document.getElementById("skuUbicacion").value = skuVal;
}

function limpiarFormularioUbicacion()
{
  document.getElementById("ubicacionForm").reset();
  document.getElementById("ubicaciones").innerHTML = "";
}

function ingresarUbicacion()
{
  var numeroUbicaciones = parseInt(document.getElementById("numeroUbicaciones").value);
  var ubicaciones = [];
  var bandera = true;
  var repetido = false;
  var repetidotemp = false; 
  if(numeroUbicaciones > 0 && !isNaN(numeroUbicaciones))
  {
    for(var i = 1;i<=numeroUbicaciones;i++)
    {
      var ubicacionID = "ubicacion" + i.toString();
      var ubicacionErrorID = "ubicacionError" + i.toString();
      var ubicacion = document.getElementById(ubicacionID).value;
      if(!validarUbicacion(ubicacion,ubicacionID,ubicacionErrorID))
      {
        bandera = false;
        continue;
      }
      for(var y=i-1;y>=1;y--)
      {
        if(ubicacion === ubicaciones[y-1])
        {
          repetido = true;
          repetidotemp = true;
        }
      }
      if(!repetidotemp)
        ubicaciones.push(ubicacion);
      repetidotemp = false;
    }
    if(bandera)
    {
      if(!repetido)
      {
        const uri = '../php/productos/productosUbicacion.php';
        const xhr  = new XMLHttpRequest();
        const fd = new FormData();
        xhr.open("POST", uri, true);
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
              console.log(xhr.responseText);
              if(xhr.responseText === "La operación se realizo con éxito")
              {
                swal({
                  icon: "success",
                  title: "Se realizo con éxito la operación"
                });
                location.reload();
              }
              else
              {
                swal({
                  icon: "error",
                  title: "Hubo un error al realizar la operación",
                  text: xhr.responseText,
                });
                location.reload();
              }
            }
        };
        fd.append('numeroUbicaciones',numeroUbicaciones);
        fd.append("sku",skuVal)
        for(var i=0;i<ubicaciones.length;i++)
        {
          var ubicacionID = "ubicacion" + i.toString();
          fd.append(ubicacionID,ubicaciones[i]);
        }
        xhr.send(fd);
      }
      else
      {
        swal({
          icon: "error",
          title: "Verificalo los datos ingresados, hay datos repetidos"
        });
      }
    }
    else
    {
      swal({
        icon: "error",
        title: "Hay errores en los datos ingresados, verificalos"
      });
    }
  }
  else
  {
    swal({
      icon: "error",
      title: "El numero de casillas debe ser mayor a 0"
    });
  }
}

function limpiarErrores()
{
  sku.classList.remove('is-valid');
  sku.classList.remove('is-invalid');
  descripcion.classList.remove('is-valid');
  descripcion.classList.remove('is-invalid');
  stock.classList.remove('is-valid');
  stock.classList.remove('is-invalid');
  medida.classList.remove('is-valid');
  medida.classList.remove('is-invalid');
  id_linea.classList.remove('is-valid');
  id_linea.classList.remove('is-invalid');
  generico.classList.remove('is-valid');
  generico.classList.remove('is-invalid');
  skuMod.classList.remove('is-valid');
  skuMod.classList.remove('is-invalid');
  ubicacionMod.classList.remove('is-valid');
  ubicacionMod.classList.remove('is-invalid');
  descripcionMod.classList.remove('is-valid');
  descripcionMod.classList.remove('is-invalid');
  stockMod.classList.remove('is-valid');
  stockMod.classList.remove('is-invalid');
  medidaMod.classList.remove('is-valid');
  medidaMod.classList.remove('is-invalid');
  id_lineaMod.classList.remove('is-valid');
  id_lineaMod.classList.remove('is-invalid');
  genericoMod.classList.remove('is-valid');
  genericoMod.classList.remove('is-invalid');
}

function limpiarFormulario(id)
{
  document.getElementById(id).reset();
  limpiarErrores();
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

function validarCamposLlenos(tipo)
{
  var flag = true;
  if(tipo == 1)
  {
    if(skuVal === "")
    {
      sku.classList.add('is-invalid');
      document.getElementById('invalid_sku').getElementsByTagName('p')[0].innerHTML = "Ingresa el SKU";
      flag = false;
    }
    if(stockVal === "")
    {
      stock.classList.add('is-invalid');
      document.getElementById('invalid_stock').getElementsByTagName('p')[0].innerHTML = "Ingresa el stock";
      flag = false;
    }
    if(descripcionVal === "")
    {
      descripcion.classList.add('is-invalid');
      document.getElementById('invalid_descripcion').getElementsByTagName('p')[0].innerHTML = "Ingresa la descripción";
      flag = false;
    }
    if(medidaVal === "")
    {
      medida.classList.add('is-invalid');
      document.getElementById('invalid_medida').getElementsByTagName('p')[0].innerHTML = "Ingresa la medida";
      flag = false;
    }
    if(id_lineaVal === "")
    {
      id_linea.classList.add('is-invalid');
      document.getElementById('invalid_linea').getElementsByTagName('p')[0].innerHTML = "Ingresa el ID de linea";
      flag = false;
    }
    if(genericoVal === "")
    {
      generico.classList.add('is-invalid');
      document.getElementById('invalid_generico').getElementsByTagName('p')[0].innerHTML = "Ingresa el generico";
      flag = false;
    }
  }
  else 
  {
    if(skuVal === "")
    {
      skuMod.classList.add('is-invalid');
      document.getElementById('invalid_skuMod').getElementsByTagName('p')[0].innerHTML = "Ingresa el SKU";
      flag = false;
    }
    if(descripcionVal === "")
    {
      descripcionMod.classList.add('is-invalid');
      document.getElementById('invalid_descripcionMod').getElementsByTagName('p')[0].innerHTML = "Ingresa la descripción";
      flag = false;
    }
    if(stockVal === "")
    {
      stockMod.classList.add('is-invalid');
      document.getElementById('invalid_stockMod').getElementsByTagName('p')[0].innerHTML = "Ingresa el stock";
      flag = false;
    }
    if(medidaVal === "")
    {
      medidaMod.classList.add('is-invalid');
      document.getElementById('invalid_medidaMod').getElementsByTagName('p')[0].innerHTML = "Ingresa la medida";
      flag = false;
    }
    if(id_lineaVal === "")
    {
      id_lineaMod.classList.add('is-invalid');
      document.getElementById('invalid_lineaMod').getElementsByTagName('p')[0].innerHTML = "Ingresa el ID de linea";
      flag = false;
    }
    if(genericoVal === "")
    {
      genericoMod.classList.add('is-invalid');
      document.getElementById('invalid_genericoMod').getElementsByTagName('p')[0].innerHTML = "Ingresa el generico";
      flag = false;
    }
  }
  return flag;
}

function validarSKU(idInput,idError)
{
  if(Number.isInteger(parseFloat(skuVal)))
  {
    if(parseFloat(skuVal) > 0)
    {
      console.log("Valido");
      idInput.classList.add('is-valid');
      return true;
    }
    else
    {
      idInput.classList.add('is-invalid');
      document.getElementById(idError).getElementsByTagName('p')[0].innerHTML = "El SKU debe ser un número entero positivo";
      return false; 
    }
  }
  else
  {
    idInput.classList.add('is-invalid');
    document.getElementById(idError).getElementsByTagName('p')[0].innerHTML = "El SKU debe ser un número entero";
    return false;
  }
}

function validarDescripcion(idInput,idError)
{
  if(descripcionVal.length > 0 && descripcionVal.length <=100)
  {
    idInput.classList.add('is-valid');
    return true;
  }
  else
  {
    idInput.classList.add('is-invalid');
    document.getElementById(idError).getElementsByTagName('p')[0].innerHTML = "La longitud mínima de la descripción es 1 y la mayor es 100";
    return false;
  }
}

function validarStock(idInput,idError)
{
  if(Number.isInteger(parseFloat(stockVal)))
  {
    if(parseFloat(stockVal) > 0)
    {
      idInput.classList.add('is-valid');
      return true;
    }
    else
    {
      idInput.classList.add('is-invalid');
      document.getElementById(idError).getElementsByTagName('p')[0].innerHTML = "El stock debe ser un número entero positivo";
      return false; 
    }
  }
  else
  {
    idInput.classList.add('is-invalid');
    document.getElementById(idError).getElementsByTagName('p')[0].innerHTML = "El stock debe ser un número entero";
    return false;
  }
}

function validarUnidadMedida(idInput,idError)
{
  if(Number.isInteger(parseFloat(medidaVal)))
  {
    if(parseFloat(medidaVal) > 0)
    {
      idInput.classList.add('is-valid');
      return true;
    }
    else
    {
      idInput.classList.add('is-invalid');
      document.getElementById(idError).getElementsByTagName('p')[0].innerHTML = "La unidad de medida debe ser un número entero positivo";
      return false; 
    }
  }
  else
  {
    idInput.classList.add('is-invalid');
    document.getElementById(idError).getElementsByTagName('p')[0].innerHTML = "La unidad de medida debe ser un número entero";
    return false;
  }
}

function validarIDLinea(idInput,idError)
{
  let patron = /[A-Z][A-Z][A-Z]$/;
  if(patron.test(id_lineaVal))
  {
    idInput.classList.add('is-valid');
    return true;
  }
  else
  {
    idInput.classList.add('is-invalid');
    document.getElementById(idError).getElementsByTagName('p')[0].innerHTML = "Verifica el formato del ID de Linea";
    return false;
  }
}

function validarGenerico(idInput,idError)
{
  let patron = /[A-Z]$/;
  if(patron.test(genericoVal))
  {
    idInput.classList.add('is-valid');
    return true;
  }
  else
  {
    idInput.classList.add('is-invalid');
    document.getElementById(idError).getElementsByTagName('p')[0].innerHTML = "Verifica el formato del genérico";
    return false;
  }
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

function insertarProducto()
{
  const uri = '../php/productos/productosIngresar.php';
  const xhr  = new XMLHttpRequest();
  const fd = new FormData();
  xhr.open("POST", uri, true);
  xhr.onreadystatechange = function(){
      if(xhr.readyState == 4 && xhr.status == 200){
          if(xhr.responseText == "EXITO")
          {
            mensaje(1,"success","Se realizó la operación con éxito","");
          }
          else
          {
            mensaje(2,"error","Hubo un error al realizar la operación",xhr.responseText);
          }
      }
  };
  fd.append('sku',skuVal);
  fd.append('id_linea',id_lineaVal);
  fd.append('generico',genericoVal);
  fd.append('descripcion',descripcionVal);
  fd.append('stock',stockVal);
  fd.append('medida',medidaVal);
  xhr.send(fd);
}

function modificarProducto()
{
  const uri = '../php/productos/productosModificar.php';
  const xhr  = new XMLHttpRequest();
  const fd = new FormData();
  xhr.open("POST", uri, true);
  xhr.onreadystatechange = function(){
      if(xhr.readyState == 4 && xhr.status == 200){
        if(xhr.responseText == "EXITO")
        {
          mensaje(1,"success","Se realizó la operación con éxito","");
        }
        else
        {
          mensaje(2,"error","Hubo un error al realizar la operación",xhr.responseText);
        }
      }
  };
  fd.append('sku',skuVal);
  fd.append('id_linea',id_lineaVal);
  fd.append('generico',genericoVal);
  fd.append('descripcion',descripcionVal);
  fd.append('stock',stockVal);
  fd.append('medida',medidaVal);
  xhr.send(fd);
}

function validarFormulario(tipo)
{
  limpiarErrores();
  var valido = true;
  if(tipo == 1)
  {
    skuVal = sku.value;
    descripcionVal = descripcion.value;
    stockVal = stock.value;
    medidaVal = medida.value;
    id_lineaVal = id_linea.value;
    genericoVal = generico.value; 
    if(!validarCamposLlenos(tipo))
    {
      valido = false;
    }
    if(!validarSKU(sku,"invalid_sku"))
    {
      valido = false;
    }
    if(!validarDescripcion(descripcion,"invalid_descripcion"))
    {
      valido = false;
    }
    if(!validarStock(stock,"invalid_stock"))
    {
      valido = false;
    }
    if(!validarUnidadMedida(medida,"invalid_medida"))
    {
      valido = false;
    }
    if(!validarIDLinea(id_linea,"invalid_linea"))
    {
      valido = false;
    }
    if(!validarGenerico(generico,"invalid_generico"))
    {
      valido = false;
    }
    if(valido)
    {
      insertarProducto();
    }
  }
  else if(tipo == 2)
  {
    skuVal = skuMod.value;
    descripcionVal = descripcionMod.value;
    stockVal = stockMod.value;
    medidaVal = medidaMod.value;
    id_lineaVal = id_lineaMod.value;
    genericoVal = genericoMod.value;
    if(!validarCamposLlenos(tipo))
    {
      return false;
    }
    if(!validarSKU(skuMod,"invalid_skuMod"))
    {
      valido = false;
    }
    if(!validarDescripcion(descripcionMod,"invalid_descripcionMod"))
    {
      valido = false;
    }
    if(!validarStock(stockMod,"invalid_stockMod"))
    {
      valido = false;
    }
    if(!validarUnidadMedida(medidaMod,"invalid_medidaMod"))
    {
      valido = false;
    }
    if(!validarIDLinea(id_lineaMod,"invalid_lineaMod"))
    {
      valido = false;
    }
    if(!validarGenerico(genericoMod,"invalid_genericoMod"))
    {
      valido = false;
    }
    if(valido)
    {
      modificarProducto();
    }
  }
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
          if(xhr.responseText == "ERROR_CSV")
          {
            mensaje(1,"error","Se debe subir un archivo CSV","");
          }
          else if(xhr.responseText == "ERROR_TIPO"){
              if(tipo == 1)
                mensaje(1,"error","Verifica que el archivo sea del inventario","");
              else
                mensaje(1,"error","Verifica que el archivo sea de la ubicación","");
          }
          else if(xhr.responseText == "ERROR_ABRIR")
          {
            mensaje(1,"error","Hubo un error al tratar de abrir el archivo copiado","");
          }
          else if(xhr.responseText == "ERROR_BORRAR")
          {
            mensaje(1,"error","Hubo un error al tratar de eliminar el archivo","");
          }
          else if(xhr.responseText == "ERROR_COPIA")
          {
            mensaje(1,"error","Error al copiar el archivo subido","");
          }
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
        console.log(nombreDeArchivos);        
        for(var i = 0; i < nombreDeArchivos.length; i++)
        {
          document.getElementById("mostrarNombreArchivoInventario").textContent = "Se cargó correctamente el archivo: \n" + nombreDeArchivos[i] + " ";
        }
        document.getElementById("targetLayerInventario").innerHTML = document.getElementById("archivoCargadoInventario").innerHTML;
        removeDragData(event);
      }
      else
      {
        
        for(var i = 0; i < nombreDeArchivos.length; i++)
        {
            document.getElementById("mostrarNombreArchivoUbicacion").textContent = "Se cargó correctamente el archivo: \n" +nombreDeArchivos[i] + " ";
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
