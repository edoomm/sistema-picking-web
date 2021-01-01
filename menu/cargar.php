<?php
if(isset($_FILES['file_name'])){  
    $directory = "contents/";
    $target_file = $directory . $_FILES['file_name']['name'];
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $numero_de_fila = -1;
    if($file_type == "csv"){
        if(move_uploaded_file($_FILES['file_name']['tmp_name'], $target_file)){
            if(($gestor = fopen($target_file,"r")) !== FALSE){
                $pila = array();
                while(($fila = fgetcsv($gestor)) !== FALSE){
                    $numero_de_fila++;
                    if($numero_de_fila === 0){
                        continue;
                    }
                    $pila[$numero_de_fila-1] = $fila;
                }
                echo json_encode($pila);
                fclose($gestor);
            }
            else{
                exit("Hubo un error al tratar de abrir el archivo copiado\n");
            }
            if(!unlink($target_file)){
                exit("Hubo un error al tratar de eliminar el archivo copiado\n");
            }
        }
        else{
            exit("Error al copiar el archivo subido\n");
        }
    }
    else{ 
        echo "Se debe subir un archivo csv\n";
    }
}
?>