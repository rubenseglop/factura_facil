
$(function() {

    
    $("#menu-user-toggle").click(function() {
        console.log("hola 1");
        $(".nav-acount").toggle('slow', function(){
            console.log("hola");
         });
    });
    
});