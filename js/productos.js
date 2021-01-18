function limpiarFormulario(id)
{
    console.log(id);
    document.getElementById(id).reset();

}

function validarFomulario()
{

}

function filtrar() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("busqueda");
    filter = input.value.toUpperCase();
    table = document.getElementById("producto");
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

function llenarFormularioMod()
{
    let sku = document.getElementById("sku").value;
    let ubicacion = document.getElementById("ubicacion").value;
    let descripcion = document.getElementById("descripcion").value;
    let stock = document.getElementById("stock").value;
    let medida = document.getElementById("medida").value;
    let id_linea = document.getElementById("id_linea").value;
    let generico = document.getElementById("generico").value;
    console.log(sku);
    console.log(ubicacion);
    console.log(descripcion);
    console.log(stock);
    console.log(medida);
    console.log(id_linea);
    console.log(generico);
    document.getElementById("modificarSKU").value = sku;
    document.getElementById("modificarUbicacion").value = ubicacion;
    document.getElementById("modificarDescripcion").value = descripcion;
    document.getElementById("modificarStock").value = stock;
    document.getElementById("modificarMedida").value = medida;
    document.getElementById("modificarLinea").value = id_linea;
    document.getElementById("modificarGenerico").value = generico;
}