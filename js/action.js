//qui inserire le chiamate js
var dati=null;
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
        case "2"://visualizza
              dati=JSON.parse(response);
              dati.forEach(function(studente) 
              {
                $("#elenco").append(ListItemTemplate(studente));
              });
             
        break;
    }
}

function ListItemTemplate(studente)
{
  var template= `<li class="user-item">
  <img src="`+GetPath(studente.Foto)+`" alt="Foto utente">
  <span class="user-name">`+studente.Nome+`</span>
  <span class="user-surname">`+studente.Cognome+`</span>
  <button class="edit-btn" onclick="editUser(`+studente.ID+`)">
   <img src="../risorse/imgs/voti.png">
  </button>
  <button class="delete-btn" onclick="deleteUser(`+studente.ID+`)">
  <img src="../risorse/imgs/delete.png">
  </button>
</li>`;
return template;
}
function editUser(id)
{

  //decido di passare l'intero oggetto ,senza interpellare di nuovo il server
  var t=dati.find((o) => { return o.ID === id});
 // window.location.href="../php/scheda.php?dati="+JSON.stringify(t);

 GenerazioneFormDinamica(t);
    
}
function deleteUser(id)
{

}

function GenerazioneFormDinamica(oggetto)
{ 
  var form = $("<form>")
.attr("method", "POST")
.attr("action", "../php/scheda.php") // Cambia con l'URL della nuova pagina
.css("display", "none"); // Nascondi il form

// Aggiungi i campi dati al form
 
$("<input>")
  .attr("type", "hidden")
  .attr("name", "dati")
  .attr("value", JSON.stringify(t))
  .appendTo(form);
 

// Aggiungi il form alla pagina e sottometti
form.appendTo("body").submit();
}

function GetPath(img)
{
  if(img==null)
    return "http://areaverifica.altervista.org/GaleazziOnline/risorse/imgs/noimage.jpeg";
  else
  return "http://areaverifica.altervista.org/Galeazzi/img/"+img;
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


  