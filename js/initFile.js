function init(){
    let args = Array.from(arguments);
    for(var i = 0; i < args.length - 1; i++){
        document.getElementById(args[i]).value="";
        document.getElementById(args[i]).disabled=true;
    }
    rowHandlers(args);
}
function rowHandlers(args){
    let table = document.getElementById(args[args.length-1]);
    let rows = table.getElementsByTagName("tr");
    args.pop();
    for(let i = 0; i < rows.length; i++){
        let currentRow = table.rows[i];
        let clickHandler = function(nombres,row){
            return function(){
                let cells = row.getElementsByTagName("td");
                let fila = [];
                for(var j = 0; j < cells.length; j++){
                    fila.push(cells[j].innerHTML);
                }
                llenarFormulario(nombres,fila);
            };
        };
        if(i != 0){
            currentRow.onclick = clickHandler(args,currentRow);
        }
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