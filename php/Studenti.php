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
    .user-item .edit-btn,
    .user-item .delete-btn
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
      background-color: trasparent;
       
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
            <span><div id="img_logout"></div></span>
        </div>
        <div></div>
    </div>
    
    <div class="sidebar">
      <h2  >Benvenuto <?php echo $_SESSION["user"]; ?></h2>
      <h2 id="insert">Inserisci Studente OOO</h2>
      <h2 id="view">Visualizza Studenti PPP</h2>
    </div>
    <div class="content">
      <div id="insertContent" class="active">
        <h2>Inserisci Studente</h2>
        <form
          action="elabora.php"
          method="POST"
          enctype="multipart/form-data"
          style="display: flex; flex-direction: row; gap: 20px"
        >
          <div style="flex: 1">
            <label for="photo">Foto:</label>
            <br />
            <img
              id="preview"
              src="../risorse/imgs/se_de_ri.jpg"
              alt="Image preview"
            />
            <input
              type="file"
              id="photo"
              name="photo"
              accept="image/*"
              onchange="previewFile()"
            />
            <br />

            <br />
            <label for="firstname">Nome:</label><br />
            <input type="text" id="firstname" name="firstname" required /><br />
            <label for="lastname">Cognome:</label><br />
            <input type="text" id="lastname" name="lastname" required /><br />
          </div>

          <div style="flex: 1">
            <label for="grade">Voto:</label><br />
            <select id="grade" name="grade">
              <option value="">--Seleziona un voto--</option>
              <!-- Using JavaScript or a server-side language, you could generate these options in a loop. -->
              <option value="1">1</option>
              <option value="1.5">1.5</option>
              <!-- Add more options up to 10 here. -->
            </select>
            <br />
            <label for="date">Data:</label><br />
            <input type="date" id="date" name="date" /><br />
          </div>
          <!-- <div style="width: 100%; text-align: center; padding-top: 20px">
            <input type="submit" value="Salva" />
          </div> -->
        </form>
        <br />
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
