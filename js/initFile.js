/*
    camposFormulario : un arreglo de strings con el id de los elementos del formulario
    tableBD : nombre de la tabla en la BD de la que se cargan los archivos
    tableBodyId : id del body en donde se van a poner los elementos de la base de datos
*/

async function init(formularioIds, columnasFormulario, tableBD, tableBodyId, columnasTabla, nombreIndicePK){
    await load_table(tableBD, tableBodyId,columnasTabla,1);
    for(var i = 0; i < formularioIds.length; i++){
        document.getElementById(formularioIds[i]).value="";
        document.getElementById(formularioIds[i]).disabled=true;
    }
    rowHandlers(formularioIds, columnasFormulario, tableBodyId, nombreIndicePK, tableBD);
}
function rowHandlers(camposFormulario, columnasFormulario, tableBodyId, nombreIndicePK, tableBD){
    let table = document.getElementById(tableBodyId);
    let rows = table.getElementsByTagName("tr");

    for(var index = 0; index < rows.length; index++){
        rows[index].addEventListener("click", function(){
            let cells = this.getElementsByTagName("td");
            let pk = cells[nombreIndicePK[1]].innerHTML;
            let query = "SELECT " + columnasFormulario + " FROM " + tableBD + " WHERE " + nombreIndicePK[0] + " = " + pk; 
            $.post("../php/queryFila.php", {
                    query : query
                },
                function(data){
                    console.log(JSON.parse(data));
                    llenarFormulario(camposFormulario,JSON.parse(data)[0]);
                }
            );
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
/*
    columnas_query: columnas que se busca que la base de datos devuelva
    condicion_query:    si se realiza una busqueda debe ser del tipo "WHERE columna=algo"
                        si se quieren obtener todas las columnas enviar un 1
*/
async function load_table(table_db, table_name, columnas_query, condicion_query){
    if($(table_db).val() != 0){
        await $.post("../php/mostrarElementosBD.php", {
                variable: table_db,
                columnas : columnas_query,
                condicion : condicion_query,
            },
            function(data){
                if(data != ""){
                    document.getElementById(table_name).innerHTML = data;
                }
            }
        );
    }
}