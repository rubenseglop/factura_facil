$( document ).ready(function() {
    $("#seleccionar").change(function(){
        var  valor = $(this).val();
        if(valor == "facebook"){
            $("#social_networks_name").val("Facebook")
            $("#social_networks_URL").val("https://www.facebook.com/")
            $("#introduce").html("Complete aqui con su nommbre de perfil de facebook")
        }else if(valor == "twitter"){
            $("#social_networks_name").val("Twitter")
            $("#social_networks_URL").val("https://twitter.com/")
            $("#introduce").html("Complete aqui con su nommbre de perfil de twitter")
        }else if(valor == "linkedin"){
            $("#social_networks_name").val("Likedin")
            $("#social_networks_URL").val("https://www.linkedin.com/feed/")
            $("#introduce").html("Complete aqui con su nommbre de perfil de linkedin")
        }
    });
});