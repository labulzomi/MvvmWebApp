<?php
session_start();
//da inserire blocco se in assenza di autorizzazione

?>
<!DOCTYPE html>
<html>
  <head>
    <link href='../risorse/css/stili.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="../js/action.js"></script>
    <script>


$(document).ready(function() 
{
    
        var formData = new FormData(); 
        formData.append("mode",2);
        ChiamataGenerica(formData);
  });


    </script>

<style>
    /* Stili di base per il listitem */
    .user-item {
      display: flex;
      align-items: center;
      color: white;
      padding: 10px;
      justify-content: space-around;
      border-bottom: 1px solid #ccc;
    }

    /* Stili per l'immagine utente */
    .user-item>img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-right: 10px;
    }
    .user-item .edit-btn img,
    .user-item .delete-btn img
    {
      width: 30px;
      height: 30px;
    }
    


    /* Stili per il nome e cognome utente */
    .user-item .user-name,
    .user-item .user-surname {
      font-size: 18px;
      font-weight: bold;
    }

    /* Stili per i bottoni */
    .user-item button {
      background-color: transparent;
       
      border: none;
      border-radius: 5px;
      padding: 5px 10px;
      margin-left: 10px;
      cursor: pointer;
    }

    /* Stili per gli spazi tra elementi */
    .user-item > *:not(:last-child) {
      margin-right: 10px;
    }
  </style>
    <style>
      body {
        font-family: Arial, sans-serif;
      }
      .sidebar {
        width: 200px;
        height: 100vh;
        position: fixed;
        background-color: #333;
        color: #fff;
        padding: 20px;
      }
      .sidebar h2 {
        cursor: pointer;
        transition: color 0.3s, background-color 0.3s;
        padding: 10px;
        border-radius: 5px;
      }
      .sidebar h2:hover {
        color: #333;
        background-color: #ddd;
      }
      .content {
        background-color: #191949;
        margin-left: 220px;
        padding: 20px;
      }
      .content > div {
        display: none;
      }
      .content > .active {
        display: block;
      }
      #preview {
        border-radius: 50%; /* Fai in modo che l'immagine appaia come un cerchio */
        width: 100px; /* Imposta la larghezza dell'immagine a 100px */
        height: 100px; /* Imposta l'altezza dell'immagine a 100px */
        object-fit: cover; /* Fai in modo che l'immagine copra l'intero spazio, ritagliandola se necessario */
      }
      html,
      body {
        height: 100%;
      }

      .wrap {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .button {
        width: 140px;
        height: 45px;
        font-family: "Roboto", sans-serif;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 2.5px;
        font-weight: 500;
        color: #000;
        background-color: #fff;
        border: none;
        border-radius: 45px;
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease 0s;
        cursor: pointer;
        outline: none;
      }

      .button:hover {
        background-color: #2ee59d;
        box-shadow: 0px 15px 20px rgba(46, 229, 157, 0.4);
        color: #fff;
        transform: translateY(-7px);
      }
    </style>
  </head>
  <body>
    <div class="TitleBar">        
        <div>
            <span>REGISTRO VALUTAZIONI</span>
            <span><a href="./logout.php"><div id="img_logout"></div></a></span>
        </div>
        <div></div>
    </div>
    
    <div class="sidebar">
      <h4  >Benvenuto <?php echo $_SESSION["user"]; ?></h2>
      <h2 id="insert">Inserisci Studente OOO</h2>
      <h2 id="view">Visualizza Studenti PPP</h2>
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
            <div> <button value="">Carica Immagine</button></div> 
            <div> <input type="text" value=""/></div>
            <div> <input type="text" value=""/></div>
            </fieldset>
            <fieldset>
            <legend>Valutazioni:</legend>
            <div>
            <button id="bt_add_val" value="" >Aggiungi valutazione</button>
            </div>
            <div> 
                <ul id="studentList">
                    
                                            
                </ul></div>
            
        
            </fieldset>

        </div>

        
        <div class="wrap">
          <button class="button">SALVA</button>
        </div>
      </div>

      <div id="viewContent">
        <h2>Visualizza Studenti</h2>
        <div id="viewData"></div>
        <ul id="elenco">

        </ul>
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

      function previewFile() {
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
      }
    </script>
  </body>
</html>
