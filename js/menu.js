$(document).ready(function(){
    cargarApartados();
});

function cargarApartados() {
    // se obtienen datos
    $.ajax({
        url: "../php/menu.php",
        method: "GET",
        cache: false,
        success: function (respax) {
            var apartados = JSON.parse(respax);
            
            // se cargan los datos
            $("#pendientes").html(apartados.pendientes);
            $("#enprogres").html(apartados.enprogres);
            $("#terminados").html(apartados.terminados);
        }
    });
}