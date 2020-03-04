

/* Método para seleccionar la sección activa del menú de empresa */
function activeElement() {
    let url = window.location.pathname;
    let sections = document.getElementsByClassName("menu-company-elements")[0].getElementsByTagName("li");
    var element = "option-invoice";

    if(url.includes("facturas")) {
        element = "option-invoice";
    }else if(url.includes("clientes")) {
        element = "option-clients";
    }else if(url.includes("productos")) {
        element = "option-products";
    }else if(url.includes("empresa")) {
        element = "option-company";
    }

    for(let i = 0; i < sections.length; i++) {
        if(sections[i].id == element) {
            sections[i].className = "active";
        }else {
            sections[i].className = "";
        }
    }
}

window.onload = function() {

    activeElement();

}