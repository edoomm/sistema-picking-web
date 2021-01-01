<?php
if(isset($_FILES['file_name'])){  
    if(move_uploaded_file($_FILES['file_name']['tmp_name'], 'contents/' . $_FILES['file_name']['name'])){
        echo "Se cargo con exito\n";
    }
}
?>