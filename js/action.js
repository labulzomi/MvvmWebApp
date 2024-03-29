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
              $("#elenco").empty();
              dati.forEach(function(studente) 
              {
                $("#elenco").append(ListItemTemplate(studente));
              });
              break;
        case "4"://delete studente
              alert("Studente rimosso");
              location.reload();
              break;
        case "1"://insert studente
            if(!isNaN(response))
            {
              alert("Studente inserito correttamente");
              //cleanArea(studente);
              //reset img
                $("#img_prof").attr('src',"../risorse/imgs/studente.png");
                $("#bt_load_img")[0].files[0]=null;
                file=null;
                studente.Foto="";
              //reset testi
                $('#tb_nome').val("");studente.Nome="";
                $('#tb_cognome').val("");studente.Cognome="";
              //reset valutazioni
              $("#studentList").empty();studente.Valutazioni=[];
              //studente=new Studente(0,"","","",new Array());
            }
            else 
              alert("Si è verificato un errore "); 
            break;
        case "3"://ypdate studente
            if(response!="-1")
            {
              
              studente=JSON.parse(response);

              $("#studentList li").each(function( index ) 
              {          
                if($(this).attr('id')==0)
                  $(this).attr('id',studente.Valutazioni[index].ID);             
                       
              });
              alert("Studente aggiornato correttamente");
                //devono esser aggiornati i dati restituitcon quelli  presenti
                //o altrimenti si cambia pagina


            }
            else
            {  
              alert("Studente NON aggiornato correttamente");
            }
        
              
             
            break;
    }
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
  var t=dati.find((o) => { return o.ID === id});
  var formData = new FormData();
  formData.append("dati",JSON.stringify(t));
  formData.append("mode",4);
  formData.append("online",1);
  ChiamataGenerica(formData);
}

function SalvaStudente(st,file)
{
  
  var formData = new FormData();
  formData.append("dati",st);
  formData.append('image', file);
  formData.append("mode",1);
  formData.append("online",1);
  ChiamataGenerica(formData);
}
function AggiornaStudente(st,file)
{
  
  var formData = new FormData();
  formData.append("dati",st);
  formData.append('image', file);
  formData.append("mode",3);
  formData.append("online",1);
  ChiamataGenerica(formData);
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
    .attr("value", JSON.stringify(oggetto))
    .appendTo(form);
  

  // Aggiungi il form alla pagina e sottometti
  form.appendTo("body").submit();
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


function AddValutazione(studente)
{

  $("#bt_add_val").on("click", function() 
    {    
        setTimeout(function(){
              $("#studentList").append(ListItemValutazioneTemplate());
            }, 450);
        
        studente.Valutazioni.push(new Valutazione(0,0,""));
        $("#gestore_bt").prop( "checked", false );
    });
}

function GestoreAcquisizioneStudente(studente,file)
{
  $('#tb_nome').on('input', function() 
    {
          studente.Nome=$(this).val();
    });
    $('#tb_cognome').on('input', function() 
    {
          studente.Cognome=$(this).val();
    });
  /*  $("#bt_load_img").change(function()
    {

        file = $("#bt_load_img")[0].files[0]; 
    });*/
}


 

  