//qui inserire le chiamate js
function GestioneResponse(mode,response)
{
    switch(mode)
    {
        case "5"://login
            if(response=="0")
                ShowSnackBar();
            else
                location.href = "./Studenti.php";
            break;
        case "6"://reg
            if(response=="-1")
              ShowSnackBar("Dati di registrazione non corretti");
            else
              ShowSnackBar("Registrazione avvenuta con successo");
            break;
    }
}

function CheckMail(email)
{
     
    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (emailPattern.test(email)) {
      return true;
    } else {
      return false;
    }
}
function ShowSnackBar(msg="I dati inseriti non sono corretti")
{
    $("#snackbar").text(msg);
    $("#snackbar").addClass("show");
    setTimeout(function()
    { 
        $("#snackbar").removeClass("show"); 
    }, 3000);
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
        GestioneResponse(formData.get("mode"),response);
         

      },
      error: function(xhr, status, error) 
      {
        // Gestisci gli errori qui
        console.error("Errore:", status, error);
      }
    });
}




//chiamate per login.php
/*
$(document).ready(function() 
{
    $("#bt_login").on("click", function() {     

      if (!CheckMail($("#tb_user").val())) {
        ShowSnackBar();
      }
      else
      {
        //procedo alla verifica della login
        var utente=new Utente($("#tb_user").val(),$("#tb_psw").val());
        var formData = new FormData();
        formData.append("dati",utente.displayInfo());
        formData.append("mode",5);
        formData.append("online",1);
        ChiamataGenerica(formData);
      }
    });

    $("#bt_reg").on("click", function() {     

        if (!CheckMail($("#tb_user").val())) {
          ShowSnackBar();
        }
        else
        {
          //procedo alla verifica della disponibilità
          var utente=new Utente($("#tb_user").val(),$("#tb_psw").val());
          var formData = new FormData();
          formData.append("dati",utente.displayInfo());
          formData.append("mode",6);
          formData.append("online",1);
          ChiamataGenerica(formData);
        }
      });
  });*/


  