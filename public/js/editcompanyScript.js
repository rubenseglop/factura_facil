$( document ).ready(function() {
    $("#seleccionar").change(function(){
        var  valor = $(this).val();
        if(valor == "facebook"){
            $("#url").val("https://www.facebook.com/")
            $("#introduce").html("Complete aqui con su nommbre de perfil de facebook")
        }else if(valor == "twitter"){
            $("#url").val("https://twitter.com/")
            $("#introduce").html("Complete aqui con su nommbre de perfil de twitter")
        }else if(valor == "linkedin"){
            $("#url").val("https://www.linkedin.com/feed/")
            $("#introduce").html("Complete aqui con su nommbre de perfil de linkedin")
        }else if(valor == "tuenti"){
            $("#url").val("https://www.tuenti.es/")
            $("#introduce").html("Complete aqui con su nommbre de perfil de tuenti")
        }

    });
});