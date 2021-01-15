# Directorio js

Directorio donde se guardarán estilos _js_

# Funciones útiles
```javascript
function init(formularioIds,columnasFormulario,tableBD,tableBodyId,columnas_tabla,nombreIndicePK)
```
Como la mayoría de las páginas tienen una estructura similar, esta función puede ser utilizada para cargar elementos de la base de datos y mostrarlos en la base de datos. Puede ser usada por ejemplo en los archivos `apartados.html`, `dispositivos.html`, `operadores.html`, `productos.html`.

- El argumento `formularioIds` debe ser un arreglo con los id's de los campos de los formularios hacia donde queremos que se envíen los datos cuando demos clic en algún elemento de la tabla. 
- El argumento `columnasFormulario` debe ser una cadena con los nombres de las columnas en la base de datos, separadas por comas, que se mostraran en el formulario. Estas deben tener el mismo orden que `formularioIds`.
- El argumento `tableBD` es una cadena, que debe ser el nombre de la tabla en la base de datos donde se encuentra la información que nos concierne.
- El argumento `tableBodyId` es una cadena con el `id` de la etiqueta `tbody` de la tabla en donde se mostrarán los resultados.
- El argumento `columnasTabla` es una cadena que contiene el nombre de las columnas (separados por comas) que se mostrarán en la tabla, dichos nombres deben de tener el orden en que se busca se muestren en la tabla.
- El argumento `nombreIndicePK` es un arreglo con dos elementos (cambiará en caso de una modificación a la base de datos) el primero debera ser una cadena con el nombre de la columna con la llave primaria en la base de datos y el segundo el índice de la columna en la tabla en HTML que contiene la llave primaria (veáse el ejemplo de uso).

## Ejemplo de uso
Para el archivo `apartados.html` se tiene que la llamada sería
```javascript
window.onload = init(
        ["control_id", "sku", "numero_control", "id_sucursal","apartado"],
        "control_id,sku,numero_control,id_sucursal,apartado",
        "Control",
        "serie",
        "control_id,sku,numero_control,id_sucursal,apartado",
        ["control_id",0]
    );
```
---
```javascript
function rowHandlers(camposFormulario, columnasFormulario, tableBodyId, nombreIndicePK, tableBD)
```
Esta función sirve para agregar la funcionalidad de llenar el formulario con la información de alguna fila de una tabla. Cada que se cambie una tabla haciendo uso de `innerHTML` se debe llamar a esta función para volver a agregar la funcionalidad a cada fila.
- El argumento `camposFormulario` debe ser un arreglo con los id's de los campos de los formularios hacia donde queremos que se envíen los datos cuando demos clic en algún elemento de la tabla. 
- El argumento `columnasFormulario` debe ser una cadena con los nombres de las columnas en la base de datos, separadas por comas, que se mostraran en el formulario. Estas deben tener el mismo orden que `formularioIds`.
- El argumento `tableBD` es una cadena, que debe ser el nombre de la tabla en la base de datos donde se encuentra la información que nos concierne.
- El argumento `tableBodyId` es una cadena con el `id` de la etiqueta `tbody` de la tabla en donde se mostrarán los resultados.
- El argumento `nombreIndicePK` es un arreglo con dos elementos (cambiará en caso de una modificación a la base de datos) el primero debera ser una cadena con el nombre de la columna con la llave primaria en la base de datos y el segundo el índice de la columna en la tabla en HTML que contiene la llave primaria (veáse el ejemplo de uso).

```javascript
rowHandlers(
    ["control_id", "sku", "numero_control", "id_sucursal","apartado"],
    "control_id,sku,numero_control,id_sucursal,apartado",
    "serie",
    ["control_id",0],
    "Control"
);
```