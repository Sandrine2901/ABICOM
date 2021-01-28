$(document).ready(function() {


    $("#submit").on("click", function()  {
        console.log($('#form').serialize())
        $.ajax({
            type: "post",
            url: "connexion.php",
            data:
                // 'username' : $("#login").val(),
                // 'password' : $("#password").val(),
                $('#form').serialize(),
                
             
            success: function(data){
                if(data == "Success"){
                
                window.location.replace("liste.php");
                }else{
                // Le membre n'a pas été connecté. (data vaut ici "faux")
                $("#resultat").css("color", "red").html(data);
                }
            }
        });
        return false;
    });
});


    
    
        