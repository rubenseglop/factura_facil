
$(function() {

    
    $(".form").off().on("submit", function() {

        var today = new Date();
        var date = $("#profile_extraUserData_birthDate_month").val() +"/" +$("#profile_extraUserData_birthDate_day").val() +"/" +$("#profile_extraUserData_birthDate_year").val();
        var form_date = new Date(date);

        if(form_date > today) {
            alert("La fecha introducida no es válida");
            event.preventDefault();
        }

    });

});