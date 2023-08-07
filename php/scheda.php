<?php
session_start();
//inserire verifica accesso

?>
<html>
    <head>
        <link href='../risorse/css/stili.css' rel='stylesheet'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="../js/action.js"></script>
    </head>
    <body>
    <div class="TitleBar">
      <div>
          <span>SCHEDA STUDENTE</span>
      </div>
    </div>
    <div id="contenitore">

        <div>
            <div id="img_prof" class="">
                <img src="
                <?php 
                    if(json_decode($_POST["dati"]).Foto==null)
                    echo "http://areaverifica.altervista.org/GaleazziOnline/risorse/imgs/noimage.jpeg";
                else
                echo "http://areaverifica.altervista.org/Galeazzi/img/"+json_decode($_POST["dati"]).Foto;
  
    ?>
                "/>
            </div>
            <div id="nominativo" class="">
                <div>
                    <input type="text" value="
                    <?php     
    echo json_decode($_POST["dati"]).Nome;
    ?>
                    "/>
                </div>
                <div>
                <input type="text" value="
                    <?php     
    echo json_decode($_POST["dati"]).Cognome;
    ?>
                    "/>
                </div>
                
            </div>
            <div id="valutazioni" class="">
                
            </div>
        </div>

    <?php 
    
    var_dump($_POST["dati"]);
    ?>
        <div id="statistiche">
                        
        </div>
    </div>

    </body>
</html>
