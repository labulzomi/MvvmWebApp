<?php
session_start();
//inserire verifica accesso

?>
<html>
    <head>
        <link href='../risorse/css/stili.css' rel='stylesheet'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="../js/action.js"></script>
        <style>
            ul {
            list-style: none;
            padding: 0;
            }

            li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
            }

            .delete-button {
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            }
        </style>
    </head>
    <body>
    <div class="TitleBar">
      <div>
          <span>SCHEDA STUDENTE</span>
      </div>
    </div>
    <div class="Contenitore">

        <div class="grigliaScheda">
            <div id="img_prof" class="">
                <img src="
                <?php 
                $img=json_decode($_POST["dati"]);
                var_dump($img);
                    if($img->Foto==null)
                    echo "http://areaverifica.altervista.org/GaleazziOnline/risorse/imgs/noimage.jpeg";
                else
                echo "http://areaverifica.altervista.org/Galeazzi/img/"+$img->Foto;
  
    ?>
                "/>
            </div>
            <div id="nominativo" class="">
                <div>
                    <input type="text" value="
                    <?php     
    echo json_decode($_POST["dati"])->Nome;
    ?>
                    "/>
                </div>
                <div>
                <input type="text" value="
                    <?php     
    echo json_decode($_POST["dati"])->Cognome;
    ?>
                    "/>
                </div>
                
            </div>
            <div id="valutazioni" class="">
                <ul id="studentList">
                    <?php
                    foreach($val as  json_decode($_POST["dati"])->Valutazioni)
                    {
                        echo "<li>                       
                        <span>Voto: $val->Voto</span>
                        <span>Data: $val->Data</span>
                        <button class="delete-button">Elimina</button>
                        </li>";
                    }
                    
                    
                    ?>
                    
                </ul>
                
            </div>
        </div>

    <?php 
    
    var_dump($_POST["dati"]);
    ?>
        <div id="statistiche">
                        
        </div>
    </div>
    <script>
        // Aggiungi event listener per eliminare un elemento
        document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('delete-button')) {
            const listItem = e.target.closest('li');
            if (listItem) {
            listItem.remove();
            }
        }
        });
    </script>
    </body>
</html>
