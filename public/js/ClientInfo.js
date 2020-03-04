$(document).ready(function(){
        $("#oneClient a").click(function(e){
             e.preventDefault();
            let url=$(this).attr("href");
            $("#sect").load(url + " #info");
           
        })
});




