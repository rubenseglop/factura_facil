
$(function() {

    /* Método para ocultar y mostrar el menú del usuario */
    $("#menu-user-toggle").off().click(function() {
        $(".nav-acount").toggle(325);
    });

    $("#searchDate").on("submit", function(event) { 
        if($(this).find("#end-search").val() == "" || $(this).find("#start-search").val() == "") {
            event.preventDefault();
        }
    });
    
});