<?php
session_start();
//inserire verifica accesso
$stili='../risorse/css/stili.css';
$url.=$stili."?caso=".rand(1,1000);
echo $url;

$html="<link href=$url rel='stylesheet'>";


$dato=json_decode($_POST["dati"]);
?>
<html>
    <head>
        <link href='../risorse/css/stili.css' rel='stylesheet'>
        <?php echo $html;?>
        <link href='../risorse/css/headerbarra.css' rel='stylesheet'>
        <link href='../risorse/css/listitemvalutazione.css' rel='stylesheet'>
        <link href='../risorse/css/fab.css' rel='stylesheet'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="../js/action.js"></script>
        <script src="../js/utility.js"></script>
        <script src="../js/template.js"></script>
        <script src="../js/model.js"></script>
        <style>
            
            
        </style>
        <script>

            let studente=JSON.parse($_POST["dati"]);
            const file;
            $(document).ready(function() 
            {
                $('#tb_nome').on('input', function() 
                {
                     studente.Nome=$(this).val();
                });
                $('#tb_cognome').on('input', function() 
                {
                     studente.Cognome=$(this).val();
                });
                $("#bt_load_img").change(function()
                {
           
                    file = $("#bt_load_img")[0].files[0]; 
                });





                $("#bt_add_val").on("click", function() 
                {    
                    $("#studentList").append(ListItemValutazioneTemplate());
                    $("#gestore_bt").prop( "checked", false );
                });

                $("#bt_default_img").on("click", function() 
                {    
                    $("#img_prof").attr('src',"http://areaverifica.altervista.org/GaleazziOnline/risorse/imgs/noimage.jpeg");
                    $("#bt_load_img")[0].files[0]=null;
                });

                $("#bt_salva").on("click", function() 
                {    
                    var check=true;
                    const ValArray = [];

                   /// $('.my-button').prop('disabled', true)
                    //estraggo tutti le valutazioni
                  $("#studentList li").each(function( index ) 
                    {                       
                            var v=$(this).find("select option:selected")[0].text;
                            var d=$(this).find("input")[0].value;
                            if(v=="?"||d=="")
                                check=false;
                            else
                                ValArray.push(new Valutazione($(this).attr("Id"),v,d));
                    });
                    studente.Valutazioni=ValArray;



                  /*  var n=$("#tb_nome").val();
                    var c=$("#tb_cognome").val();
                    var f=$("#img_prof").attr('src').split('\\').pop();
                    if(f.includes("noimage.jpeg"))
                        f=null;
                    else
                        if($("#bt_load_img").val()=="")
                            f="invariata";                  


                    let s=new Studente($("#tb_id").val(),n,c,f,ValArray);

                    const file = $("#bt_load_img")[0].files[0]; 

                    if(n==""||c=="")
                        check=false;*/

                    if(check)
                        //AggiornaStudente(JSON.stringify(s),file);  
                        AggiornaStudente(JSON.stringify(studente),file);  
                    else
                        alert("si è verificato un problema, dati non corretti");
        
                    
                });

            });
        </script>
    </head>
    <body>
        <div style="height: 100%;width: 100%;">
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
                <div> <input style="display:none;" id="tb_id" type="text" value="<?php echo $dato->ID;?>"/></div>
                <div> <input class="InsertText" id="tb_nome" type="text" value="<?php echo $dato->Nome;?>"/></div>
                <div> <input class="InsertText"id="tb_cognome" type="text" value="<?php echo $dato->Cognome;?>"/></div>
                </fieldset>
                <fieldset>
                <legend>Valutazioni:</legend>
                <div>
                    <div style="display: flex;justify-content: center;align-items: center;">
                        <input type="checkbox" id="gestore_bt">
                        <label for="gestore_bt">
                            <div id="bt_add_val" class="round-button">+</div>
                        </label>
                    </div>
                
                </div>
                <div style="margin-top:15px;"> 
                    <ul id="studentList">
                        <?php
                            foreach($dato->Valutazioni as $val)
                            {
                                echo '<li id='.$val->ID.'>
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
        </div>



        <script>
            // Aggiungi event listener per eliminare un elemento
            document.addEventListener('click', function(e) 
            {
            if (e.target && e.target.classList.contains('delete-button')) {
                const listItem = e.target.closest('li');
                if (listItem) 
                {
                  /*  if(listItem.id!="0")
                    {
                        
                        listItem.style.display="none";
                        listItem.listItem.childNodes[3].childNodes[1].value=-1;
                    }
                    else
                        listItem.remove();  */
                    if(listItem.id!="0")
                    {
                        for(const item in studente.Valutazioni)
                        {
                            if(studente.Valutazioni[item].ID==listItem.id){
                                studente.Valutazioni[item].Voto=-1; 
                                listItem.remove();
                            }
                        }
                    }
                    else
                    {
                        for(const item in studente.Valutazioni)
                        {
                            if(studente.Valutazioni[item].Voto==childNodes[3].childNodes[1].value
                                &&studente.Valutazioni[item].Voto==childNodes[6].childNodes[1].value)
                                {
                                    delete studente.Valutazioni[item];
                                    listItem.remove();
                                }
                        }
                    }
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
