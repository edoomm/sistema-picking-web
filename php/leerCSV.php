<?php
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