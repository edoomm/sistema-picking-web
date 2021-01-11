Directorio que servirá para meter archivos php que lleguen a tener un uso común.

# [db.php](db.php)
El archivo [db.php](db.php) en principio sirve como **conexión para la base de datos**, es mejor tener **un solo archivo** a en todos los archivos php incluir la conexión a la base de datos (principalmente para poder cambiar la contraseña más facilmente).

```php
$user = "root";
$pwd = ""; // Acá dependerá de como tengamos configurados nuestros MySQLs
$db = "pickingdb";
```

## Utilización

```php
include '../php/db.php'
$conn = open_database(); // Y ya acá estará abierta la conexión con la base de datos
/*
    Operaciones con la base de datos abierta
*/

// No olviden cerrar la conexión cuando hayan terminado de utilizar la base de datos
mysqli_close($conn);
```