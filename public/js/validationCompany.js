$(document).ready(function() {
    $("#register-submit-btn").click(function( event ) {
        //console.log("primero");
        //console.log("Contenido 1 "+$("#add_company_NIF").val)

        var valorEmail=$("#add_company_email").val()
        var silabasEmail = new Array();

        for(var j=0;i<valorEmail.length;j++){
            var letraSacada1 = valorEmail.substring(j,j+1);
            silabasEmail.push(letraSacada1);
        }

        var variable = false ;
        if(valorEmail.indexOf(".") == -1){
            alert("Formato de Email Incorrecto")
            variable=false;
            event.preventDefault();
        }else{
            variable=true;
        }

        if(variable){
            var posicionPunto = valorEmail.indexOf(".")
            posicionPunto++
            var totalCadena = valorEmail.length
            var operacion = totalCadena-posicionPunto
            if(operacion<2){
                alert("Formato de Correo no valido")
                event.preventDefault();
            }

        }

        if($("#add_company_NIF").val() == ""){
            //console.log("Contenido"+$("#add_company_NIF").val)
            alert("Campo de NIF vacio")
            $("#add_company_NIF").focus()
            event.preventDefault();
        }else{
            var valorNIF = $("#add_company_NIF").val()
            //console.log(valorNIF.length)
            var silabas = new Array();

            for(var i=0;i<valorNIF.length;i++){
                var letraSacada = valorNIF.substring(i,i+1);
                silabas.push(letraSacada);
            }

            if(silabas.length < 9 || silabas.length > 9){
                alert("El NIF no es correcto por su tamaño")
                event.preventDefault();
            }else if(parseInt(silabas[0])){
                alert("El NIF no es correcto por su formato (I). No comienza por una letra")
                event.preventDefault();
            }
        }
    });
});