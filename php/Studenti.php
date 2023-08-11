<?php
session_start();
//da inserire blocco se in assenza di autorizzazione

?>
<!DOCTYPE html>
<html>
  <head><?php//parte con rand per forzare aggiornamento css
   echo" <link href='../risorse/css/stili.css?".rand(1,1000)."' rel='stylesheet'>
    <link href='../risorse/css/headerbarra.css?".rand(1,1000)."' rel='stylesheet'>
    <link href='../risorse/css/listitemstudenti.css?".rand(1,1000)."' rel='stylesheet'>
    <link href='../risorse/css/listitemvalutazione.css?".rand(1,1000)."' rel='stylesheet'>
    <link href='../risorse/css/fab.css?".rand(1,1000)."' rel='stylesheet'>
    <link href='../risorse/css/menulaterale.css?".rand(1,1000)."' rel='stylesheet'>  ";?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="../js/action.js"></script>
    <script src="../js/utility.js"></script>
    <script src="../js/template.js"></script>
    <script src="../js/model.js"></script>
    <script>

var statocaricamento=false;

$(document).ready(function() 
{    
        var formData = new FormData(); 
        formData.append("mode",2);
        ChiamataGenerica(formData);
        statocaricamento=true;

        $("#bt_add_val").on("click", function() 
        {    
            $("#studentList").append(`<li id="0">
                    <span><img width="30px" src="../risorse/imgs/voti.png"></span>
                    <span> <select ><option value="" selected disabled hidden>?</option><option value="1">1</option><option value="1.5">1.5</option><option value="2">2</option><option value="2.5">2.5</option><option value="3">3</option><option value="3.5">3.5</option><option value="4">4</option><option value="4.5">4.5</option><option value="5">5</option><option value="5.5">5.5</option><option value="6">6</option><option value="6.5">6.5</option><option value="7">7</option><option value="7.5">7.5</option><option value="8">8</option><option value="8.5">8.5</option><option value="9">9</option><option value="9.5">9.5</option><option value="10">10</option></select></span>	                       
                    <span><img width="30px" src="../risorse/imgs/calendar.png"></span>
                    <span> <input type="date" ></span>
                    
                    <button class="delete-button"  style=""></button>
                    </li>`);
        });
        $("#insert").on("click", function() 
        {    
          var formData = new FormData(); 
          formData.append("mode",2);
          ChiamataGenerica(formData);
          statocaricamento=true;
        });
         
        $("#bt_salva").on("click", function() 
        {    
          const ValArray = [];

          
          //estraggo tutti le valutazioni
          $("#studentList li").each(function( index ) 
          {
                var v=$(this).find("select option:selected")[0].text;
                var d=$(this).find("input")[0].value;
                ValArray.push(new Valutazione(0,v,d));
          });
          var n=$("#bt_nome").val();
          var c=$("#bt_cognome").val();
          var f=$("#bt_load_img").val().split('\\').pop()=="../risorse/imgs/studente.png"?null:$("#bt_load_img").val().split('\\').pop();

          let s=new Studente(0,n,c,f,ValArray);

          const file = $("#bt_load_img")[0].files[0];

          SalvaStudente(JSON.stringify(s),file);
 
             
        });
  });

 
            
       
    </script>

<style>
    
  </style>
    <style>
       
      
      #preview {
        border-radius: 50%; /* Fai in modo che l'immagine appaia come un cerchio */
        width: 100px; /* Imposta la larghezza dell'immagine a 100px */
        height: 100px; /* Imposta l'altezza dell'immagine a 100px */
        object-fit: cover; /* Fai in modo che l'immagine copra l'intero spazio, ritagliandola se necessario */
      }
      

      
    </style>
  </head>
  <body >
    <div style="height: 100%;width: 100%;">
    <div class="TitleBar">        
        <div>
            <span>REGISTRO VALUTAZIONI</span>
            <span><a href="./logout.php"><div id="img_logout"></div></a></span>
        </div>
        <div></div>
    </div>
    <div id="areanavigazione">
      <div class="sidebar">
        <h4  >Benvenuto<br> <?php echo $_SESSION["user"]; ?></h2>
        <h2 id="insert">Inserisci Studente</h2>
        <h2 id="view">Visualizza Studenti</h2>
      </div>
      <div class="content">
        <div id="insertContent" class="active">
          <h2>Inserisci Studente</h2>
          <div style="display:flex;justify-content: space-around;text-align:center;align-items: center;padding: 20px;"> 
              <fieldset>
              <legend>Anagrafica:</legend>
              <div>
              <img id="img_prof" src="../risorse/imgs/studente.png"/>
              </div>
              <div> <input  id="bt_load_img" type="file" name="image"  accept="image/*">Carica Immagine</button></div> 
              <div> <input class="InsertText" placeholder="Nome" id="bt_nome" type="text"  /></div>
              <div> <input class="InsertText" placeholder="Cognome" id="bt_cognome" type="text"  /></div>
              </fieldset>
              <fieldset>
              <legend>Valutazioni:</legend>
              <div>
              <button id="bt_add_val"   >Aggiungi valutazione</button>
              </div>
              <div> 
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
          <h2>Visualizza Studenti</h2>
          <div id="viewData"></div>
          <ul id="elenco">

          </ul>
        </div>
      </div>
    </div>
    <script>
      document.getElementById("insert").addEventListener("click", function () {
        document.getElementById("insertContent").classList.add("active");
        document.getElementById("viewContent").classList.remove("active");
      });

      document.getElementById("view").addEventListener("click", function () {
        document.getElementById("viewContent").classList.add("active");
        document.getElementById("insertContent").classList.remove("active");
      });

      /*function previewFile() {
        const preview = document.querySelector("#preview");
        const file = document.querySelector("#photo").files[0];
        const reader = new FileReader();

        reader.addEventListener(
          "load",
          function () {
            // convert image file to base64 string
            preview.src = reader.result;
          },
          false
        );

        if (file) {
          reader.readAsDataURL(file);
        }
      }*/
    </script>
    <script>
         const imageInput = document.getElementById('bt_load_img');
       

        imageInput.addEventListener('change', function() {
            const file = imageInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                   
                    $("#img_prof").attr("src",event.target.result);
                
                };
                reader.readAsDataURL(file);
            } 
        });
      </script>

      </div>
  </body>
</html>
