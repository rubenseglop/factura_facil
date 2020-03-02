function validarformulario(miform) {
    var env=true;
    var misInputs = document.getElementsByTagName('input');
    var inputsSinRellenar = new Array();
    for(var i=0;i<misInputs.length;i++){
        if(misInputs[i].type == "text"){
            if(misInputs[i].value == ""){
                var place = misInputs[i].placeholder
                alert("El campo "+place+" está sin rellenar .Rellenelo");
                misInputs[i].style.backgroundColor = 'orange';
                misInputs[i].style.borderColor = 'red';
                    misInputs[i].style.borderWidth = '6px';
                misInputs[i].focus();
                env=false;
            }else{
                misInputs[i].style.backgroundColor = '#FFFFFF';
                misInputs[i].style.border = 'none';
            }


        }
    }
    return env;
}
