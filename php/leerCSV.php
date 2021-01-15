<?php
/*
    tipo 1 -> cargar inventario
    tipo 2 -> cargar ubicaciones
    tipo 3 -> cargar control de distribucion
    **Ver layout**
*/

function verificarFormato($fila,$tipo)
{
    $numFilas = count($fila);
    if($tipo == 1)
    {
        if($numFilas == 5)
        {
            if(strcmp($fila[0], "SKU") == 0)
                if(strcmp($fila[1],"LINEA") == 0)
                    if(strcmp($fila[2], "GENERICO") == 0)
                        if(strcmp($fila[3], "DESCRIPCION") == 0)
                            if(strcmp($fila[4], "STOCK") == 0)
                                return TRUE;
        }
    }
    else if($tipo == 2)
    {
        if($numFilas == 6)
        {
            if(strcmp($fila[0], "UBICACION") == 0)
                if(strcmp($fila[1],"SKU") == 0)
                    if(strcmp($fila[2], "PASILLO") == 0)
                        if(strcmp($fila[3], "RACK") == 0)
                            if(strcmp($fila[4], "COLUMNA") == 0)
                                if(strcmp($fila[5], "NIVEL") == 0)
                                    return TRUE;
        }
    }
    else
    {
        if($numFilas == 4)
        {
            if(strcmp($fila[0],"ALMACEN") == 0)
                if(strcmp($fila[1],"SKU") == 0)
                    if(strcmp($fila[2],"CONTROL_DIST") == 0)
                        if(strcmp($fila[3],"CANT_CONTROL") == 0)
                            return TRUE;
        }
    }
    return FALSE;
}

function obtener_contenido(){
    $directory = getcwd().DIRECTORY_SEPARATOR;
    $target_file = $directory . basename($_FILES['file_name']['name']);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $numero_de_fila = -1;
    $num_cols = $_POST['num_cols'];
    $datos = array();
    $cols_equal = TRUE;
    if($file_type == "csv"){
        if(@move_uploaded_file($_FILES['file_name']['tmp_name'], $target_file)){
            if(($gestor = fopen($target_file,"r")) !== FALSE){
                while(($fila = fgetcsv($gestor)) !== FALSE){
                    if(count($fila) != $num_cols){
                        $cols_equal = FALSE;
                        break;
                    }
                    $numero_de_fila++;
                    if($numero_de_fila === 0){
                        continue;
                    }
                    $datos[$numero_de_fila - 1] = $fila;
                }
                fclose($gestor);
            }
            else{
                echo "ERROR_ABRIR";
                exit("Hubo un error al tratar de abrir el archivo copiado\n");
                return FALSE;
            }
            if(!unlink($target_file)){
                echo "ERROR_BORRAR";
                exit("Hubo un error al tratar de eliminar el archivo copiado\n");
                return FALSE;
            }
            if(!$cols_equal){
                echo "ERROR_COLUMNAS";
                return FALSE;
            }
        }
        else{
            exit("Error al copiar el archivo subido\n");
            echo "ERROR_COPIA";
            return FALSE;
        }
        return $datos;
    }
    else{ 
        echo "ERROR_CSV";
        return FALSE;
    }
}
?>