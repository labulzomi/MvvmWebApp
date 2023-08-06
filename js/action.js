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

function ChiamataGenerica(formData)
{
     

    $.ajax({
      url: "../../Galeazzi/elabora.php",
      type: "POST",
      data: formData,
      processData: false, // Necessario per FormData
      contentType: false, // Necessario per FormData
      success: function(response) 
      {
        // Gestisci la risposta qui
        console.log("Risposta:", response);
      },
      error: function(xhr, status, error) 
      {
        // Gestisci gli errori qui
        console.error("Errore:", status, error);
      }
    });
}
//chiamate per login.php

$(document).ready(function() 
{
    $("#bt_login").on("click", function() {     

  
      if (!CheckMail($("#tb_user").val())) {
        $("#snackbar").addClass("show");
        setTimeout(function()
        { 
            $("#snackbar").removeClass("show"); 
        }, 3000);
      }
      else
      {
        //procedo alla verifica della login
        var utente=new Utente($("#tb_user").val(),$("#tb_psw").val());
        var formData = new FormData();
        formData.append("dati",utente.displayInfo());
        ChiamataGenerica(formData);
      }
    });
  });


  