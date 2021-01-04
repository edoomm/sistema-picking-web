/*
    camposFormulario : un arreglo de strings con el id de los elementos del formulario
    tableId : id de la tabla de elementos
    tableBD : nombre de la tabla en la BD de la que se cargan los archivos
    tableBodyId : id del body en donde se van a poner los elementos de la base de datos
*/

async function init(camposFormulario, tableBD, tableBodyId){
    await load_table(tableBD, tableBodyId);
    for(var i = 0; i < camposFormulario.length; i++){
        document.getElementById(camposFormulario[i]).value="";
        document.getElementById(camposFormulario[i]).disabled=true;
    }
    rowHandlers(camposFormulario, tableBodyId);
}
function aux(){
    console.log(this);
}
function rowHandlers(camposFormulario, tableBodyId){
    let table = document.getElementById(tableBodyId);
    console.log(tableBodyId);
    console.log(table.innerHTML);
    let rows = table.getElementsByTagName("tr");
    console.log(rows.length);
    for(var index = 0; index < rows.length; index++){
        rows[index].addEventListener("click", function(){
            let cells = this.getElementsByTagName("td");
            console.log(cells);
            let fila = [];
            for(let j = 0; j < cells.length; j++){
                fila.push(cells[j].innerHTML);
            }
            llenarFormulario(camposFormulario, fila);
        });
    }
}
function llenarFormulario(nombres, row){
    for(let i = 0; i < nombres.length; i++){
        if(i >= row.length){
            document.getElementById(nombres[i]).value = "";
        }
        else{
            document.getElementById(nombres[i]).value = row[i];
        }
        document.getElementById(nombres[i]).disabled = true;
    }
}
async function load_table(table_db, table_name){
    if($(table_db).val() != 0){
        await $.post("../php/mostrarElementosBD.php", {
                variable: table_db
            },
            function(data){
                if(data != ""){
                    console.log(table_name);
                    document.getElementById(table_name).innerHTML = data;
                }
            }
        );
    }
}