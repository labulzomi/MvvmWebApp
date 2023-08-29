<?php
session_start();
//include "../../Galeazzi/utility.php";

include "utilityweb.php";
//da inserire blocco se in assenza di autorizzazione
if(!CheckSession($_SESSION))
  header("Location:login.php");

$caso=rand(1,1000);
$stili="<link href='../risorse/css/stili.css?caso=".$caso."' rel='stylesheet'>
<link href='../risorse/css/headerbarra.css?caso=".$caso."' rel='stylesheet'>
<link href='../risorse/css/listitemstudenti.css?caso=".$caso."' rel='stylesheet'>
<link href='../risorse/css/listitemvalutazione.css?caso=".$caso."' rel='stylesheet'>
<link href='../risorse/css/mobile.css?caso=".$caso."' rel='stylesheet'> 
<link href='../risorse/css/fab.css?caso=".$caso."' rel='stylesheet'>
<link href='../risorse/css/menulaterale.css?caso=".$caso."' rel='stylesheet'> ";


$stat=new Statistica();
?>
<!DOCTYPE html>
<html>
  <head>
  <?php echo $stili;?>
 <!--    <link href='../risorse/css/stili.css' rel='stylesheet'> 
    <link href='../risorse/css/headerbarra.css' rel='stylesheet'>
    <link href='../risorse/css/listitemstudenti.css' rel='stylesheet'>
    <link href='../risorse/css/listitemvalutazione.css' rel='stylesheet'>
    <link href='../risorse/css/fab.css' rel='stylesheet'>
    <link href='../risorse/css/menulaterale.css' rel='stylesheet'>  -->
    
    <script src="../js/model.js"></script>
     <script>
var statocaricamento=false;
let file;
let f_iniziale;
let studente=new Studente(0,"","","",new Array());

     </script>
    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="../js/action.js"></script>
    <script src="../js/utility.js"></script>
    <script src="../js/template.js"></script>
    <script>


$(document).ready(function() 
{    
    //VANNO RESETTATI I CAMPI E I 
  //VALORI DELL'OGGETTO STUDENTE E FILE
        

        var formData = new FormData(); 
        formData.append("mode",2);
        ChiamataGenerica(formData);
        statocaricamento=true;


        GestoreAcquisizioneStudente(studente,file);
        AddValutazione(studente);


        $("#view").on("click", function() 
        {    
          
          {
            var formData = new FormData(); 
            formData.append("mode",2);
            ChiamataGenerica(formData);
            statocaricamento=true;
          }
        });
         

        $('.menu-icon').click(function() 
        {
          $('.sidebar').toggleClass('attiva');
        });

        $('.sidebar h2').click(function() 
        {
            $('.sidebar').removeClass('attiva');
        });



        $("#bt_salva").on("click", function() 
        {    
          const ValArray = [];
        

          var check=CheckValutazioni($("#studentList li"));



          if(check)                        
          {   
            /*var f=$("#img_prof").attr('src').split('\\').pop();
            if(f.includes("noimage.jpeg"))
                f=null;
            else
                if($("#bt_load_img").val()=="")
                    f="invariata";
            studente.Foto=f;*/
            SalvaStudente(JSON.stringify(studente),file);
          }
          else
            alert("si è verificato un problema, dati non corretti");
 
             
        });
  });

 
            
       
    </script>

<style>
    
  </style>
    
  </head>
  <body >
    <div style="height: 100%;width: 100%;">
    <div class="TitleBar">        
        <div>
            <span>REGISTRO VALUTAZIONI</span>
            <span><a href="./logout.php"><div id="img_logout"></div></a></span>
             <span class="menu-icon">&#9776;</span>
        </div>
        <div></div>
    </div>
    <div id="areanavigazione">
      <div class="sidebar">
        <h4  >Benvenuto<br> <?php echo $_SESSION["user"]; ?></h2>
        <h2 id="insert">Inserisci Studente</h2>
        <h2 id="view">Visualizza Studenti</h2>
        <h2 id="stats">Statistiche</h2>
      </div>
      <div class="content">
        <div id="insertContent" class="active">
          
          <div class="fieldContainer"> 
              <fieldset>
              <legend>Anagrafica:</legend>
              <div>
              <img id="img_prof" src="../risorse/imgs/studente.png"/>
              </div>
              <div> 
                    <label for="bt_load_img" class="bt_upload">Cambia Immagine</label>
                    <input type="file" id="bt_load_img" name="image" accept="image/*" style="display:none;" value=""/> 
                </div>
           <!--   <div> <input  id="bt_load_img" type="file" name="image"  accept="image/*">Carica Immagine</button></div> -->
              <div> <input class="InsertText" placeholder="Nome" id="tb_nome" type="text"  /></div>
              <div> <input class="InsertText" placeholder="Cognome" id="tb_cognome" type="text"  /></div>
              </fieldset>
              <fieldset>
              <legend>Valutazioni:</legend>
              <div>
                <div  class="fabcontainer">
                    <input type="checkbox" id="gestore_bt">
                    <label for="gestore_bt">
                        <div id="bt_add_val" class="round-button">+</div>
                    </label>
                </div>
            
            </div>
            <div class="valutazioniContainer"  > 
                  <ul id="studentList">
                      
                                              
                  </ul>
              </div>
              
          
              </fieldset>

          </div>

          
          <div class="wrap">
            <button class="button" id="bt_salva">SALVA</button>
          </div>
        </div>

        <div id="viewContent">
           
          <div id="viewData"></div>
          <ul id="elenco">

          </ul>
        </div>
        <div id="statContent" class="fieldContainer">
          <div id="statgenerali">
            <fieldset>
              <legend>Dati Generali</legend>
                <span>Voto Medio</span>
                <span class="bollino"><?php echo round($stat->getMediaVoto(),1); ?></span>
                <span>Voto Max</span>
                <span class="bollino"><?php echo $stat->getMaxVoto(); ?></span>
                <span>Voto Min</span>
                <span class="bollino"><?php echo $stat->getMinVoto(); ?></span>
            </fieldset> 
          </div>
          <div>
            <div id="graph1">
              <fieldset>
              <legend>Andamento studenti</legend>
            </fieldset> 
            </div>
            <div id="graph2">
                <fieldset>
                <legend>Distribuzione voti</legend>
              </fieldset> 
            </div>
            
          </div>
          
          
        </div>
      </div>
    </div>
    <script>
      document.getElementById("insert").addEventListener("click", function () {
        document.getElementById("insertContent").classList.add("active");
        document.getElementById("viewContent").classList.remove("active");
        document.getElementById("statContent").classList.remove("active");
      });
      document.getElementById("stats").addEventListener("click", function () {
        document.getElementById("statContent").classList.add("active");
        document.getElementById("viewContent").classList.remove("active");
        document.getElementById("insertContent").classList.remove("active");
      });

      document.getElementById("view").addEventListener("click", function () {
        document.getElementById("viewContent").classList.add("active");
        document.getElementById("insertContent").classList.remove("active");
        document.getElementById("statContent").classList.remove("active");
      });

       
    </script>
    <script>
         const imageInput = document.getElementById('bt_load_img'); 
        imageInput.addEventListener('change', function() {
             file = imageInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                   
                    $("#img_prof").attr("src",event.target.result);
                    studente.Foto= file.name;       
                };
                reader.readAsDataURL(file);
            } 
        }); 
       // GestoreCambioImmagine(studente);

        $(document).on('input', '.get', function() 
        {
            var index = $('.valutazione').index($(this).closest('.valutazione'));
            if($(this).prop('nodeName')=="INPUT")
                studente.Valutazioni[index].Data=$(this).val();
            else
                studente.Valutazioni[index].Voto=+$(this).val();
        });
      </script>

      </div>
  </body>
</html>
