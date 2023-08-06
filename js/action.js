//qui inserire le chiamate js


function CheckMail(email)
{
     
    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (emailPattern.test(email)) {
      return true;
    } else {
      return false;
    }
}


//chiamate per login.php

$(document).ready(function() 
{
    $("#bt_login").on("click", function() {
       

  
      if (!CheckMail()) {
        $("#bt_login").addClass("show");
        setTimeout(function()
        { 
            $("#bt_login").removeClass("show"); 
        }, 3000);
      }  
    });
  });


  