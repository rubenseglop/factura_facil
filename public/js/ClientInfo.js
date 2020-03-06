$(document).ready(function(){
        $("#oneClient").click(function(e){
             e.preventDefault();
            let url=$(this).attr("href");
            $("#sect").load(url + " #info");
           
        })
});




