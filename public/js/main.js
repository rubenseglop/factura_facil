
$(function() {

    /* Método para ocultar y mostrar el menú del usuario */
    $("#menu-user-toggle").off().click(function() {
        $(".nav-acount").toggle(325);
    });

    $("#searchDate").on("submit", function(event) {
        event.preventDefault();
        console.log($(this));
    });
    
});