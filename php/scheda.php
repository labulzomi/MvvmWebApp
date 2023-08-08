<?php
session_start();
//inserire verifica accesso


$dato=json_decode($_POST["dati"]);
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
            #img_prof 
            {
                width:300px;
            }
        </style>
    </head>
    <body>
    
        <div class="TitleBar">        
            <div>
            <span>SCHEDA STUDENTE</span>
            <span><div id="img_logout"></div></span>
            </div>
            <div></div>
        </div>
    <div class="Contenitore">

        <div class="grigliaScheda">
            
        </div>
        <div style="display:flex;justify-content: space-around;text-align:center;align-items: center;"> 
            <fieldset>
            <legend>Anagrafica:</legend>
            <div>
            <img id="img_prof" src="<?php               
                        
                            if($dato->Foto==null)
                            echo "http://areaverifica.altervista.org/GaleazziOnline/risorse/imgs/noimage.jpeg";
                        else
                        echo "http://areaverifica.altervista.org/Galeazzi/img/".$dato->Foto;
        
            ?>"/>
            </div>
            <div> <button value="">Cambia Immagine</button></div>
            <div> <button value="">Rimuovi Immagine</button></div>
            <div> <input type="text" value="<?php     
            echo trim(json_decode($_POST["dati"])->Nome);
            ?>"/></div>
            <div> <input type="text" value="<?php echo trim(json_decode($_POST["dati"])->Cognome);?>"/></div>
            </fieldset>
            <fieldset>
            <legend>Valutazioni:</legend>
            <div>
            <button value=""  >Aggiungi valutazione</button>
            </div>
            <div> 
                <ul id="studentList">
                    <?php
                        foreach($dato->Valutazioni as $val)
                        {
                            echo '<li>
                            <span><img width="30px" src="../risorse/imgs/voti.png"></span>
                            <span> <select>';
                            for($i=1;$i<=10;$i=$i+0.5){
                                $f=$i==$val->Voto?"selected":"";
                                echo "<option $f value=$i>$i</option>";
                            }
                            echo '</select></span>	                       
                            <span><img width="30px" src="../risorse/imgs/calendar.png"></span>
                            <span> <input type="date" value="'.$val->Data.'" /></span>
                            
                            <button class="delete-button"><img width="30px" src="../risorse/imgs/deleteicon.png"></button>
                            </li>';
                        }
                            
                            
                    ?>
                                            
                </ul></div>
            
        
            </fieldset>

        </div>
    <?php  
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
