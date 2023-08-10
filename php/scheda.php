<?php
session_start();
//inserire verifica accesso


$dato=json_decode($_POST["dati"]);
?>
<html>
    <head>
        <link href='../risorse/css/stili.css' rel='stylesheet'>
        <link href='../risorse/css/headerbarra.css' rel='stylesheet'>
        <link href='../risorse/css/listitemvalutazione.css' rel='stylesheet'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="../js/action.js"></script>
        <script src="../js/utility.js"></script>
        <script src="../js/template.js"></script>
        <style>
            
            
        </style>
        <script>
            $(document).ready(function() 
            {
                $("#bt_add_val").on("click", function() 
                {    
                    $("#studentList").append(`<li>
                            <span><img width="30px" src="../risorse/imgs/voti.png"></span>
                            <span> <select ><option value="" selected disabled hidden>?</option><option value="1">1</option><option value="1.5">1.5</option><option value="2">2</option><option value="2.5">2.5</option><option value="3">3</option><option value="3.5">3.5</option><option value="4">4</option><option value="4.5">4.5</option><option value="5">5</option><option value="5.5">5.5</option><option value="6">6</option><option value="6.5">6.5</option><option value="7">7</option><option value="7.5">7.5</option><option value="8">8</option><option value="8.5">8.5</option><option value="9">9</option><option value="9.5">9.5</option><option value="10">10</option></select></span>	                       
                             <span><img width="30px" src="../risorse/imgs/calendar.png"></span>
                            <span> <input type="date" ></span>
                            
                            <button class="delete-button"  style=""></button>
                            </li>`);
                });

                $("#bt_default_img").on("click", function() 
                {    
                    $("#img_prof").attr('src',"http://areaverifica.altervista.org/GaleazziOnline/risorse/imgs/noimage.jpeg")
                });

            });
        </script>
    </head>
    <body>
    
        <div class="TitleBar">        
            <div>
                <span>SCHEDA STUDENTE</span>
                <div>
                    <span><a href="./Studenti.php"><div id="img_back"></div></a></span>
                    <span><a href="./logout.php"><div id="img_logout"></div></a></span>
                </div>
            </div>
            <div></div>
        </div>
    <div class="Contenitore">

        <div class="grigliaScheda">
            
        </div>
        <div style="display:flex;justify-content: space-around;text-align:center;align-items: center;padding: 20px;"> 
            <fieldset>
            <legend>Anagrafica:</legend>
            <div>
            <img id="img_prof" src="<?php if($dato->Foto==null)
                            echo "http://areaverifica.altervista.org/GaleazziOnline/risorse/imgs/noimage.jpeg";
                        else
                        echo "http://areaverifica.altervista.org/Galeazzi/img/".$dato->Foto;?>"/>
            </div>
            <div> <input type="file" id="bt_load_img" value="">Cambia Immagine</input></div>
            <div> <button id="bt_default_img" value="">Rimuovi Immagine</button></div>
            <div> <input class="InsertText" type="text" value="<?php     
            echo trim(json_decode($_POST["dati"])->Nome);
            ?>"/></div>
            <div> <input class="InsertText" type="text" value="<?php echo trim(json_decode($_POST["dati"])->Cognome);?>"/></div>
            </fieldset>
            <fieldset>
            <legend>Valutazioni:</legend>
            <div>
                <div>
                    <input type="checkbox" id="gestore_bt">
                    <label for="gestore_bt">
                        <div class="round-button">+</div>
                    </label>
                </div>
            <button id="bt_add_val" value=""  >Aggiungi valutazione</button>
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
                            
                            <button class="delete-button"  style=""></button>
                            </li>';
                        }
                            
                            
                    ?>
                                            
                </ul></div>
            
        
            </fieldset>

        </div>
    <?php  
    ?>
        <div class="wrap">
            <button class="button" id="bt_salva">SALVA</button>
          </div>

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
    </body>
</html>
