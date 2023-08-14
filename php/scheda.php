<?php
session_start();
//inserire verifica accesso


$caso=rand(1,1000);

 

$stili="<link href='../risorse/css/stili.css?caso=".$caso."' rel='stylesheet'>
<link href='../risorse/css/headerbarra.css?caso=".$caso."' rel='stylesheet'>
<link href='../risorse/css/listitemvalutazione.css?caso=".$caso."' rel='stylesheet'>
<link href='../risorse/css/fab.css?caso=".$caso."' rel='stylesheet'>";

$dato=json_decode($_POST["dati"]);
?>
<html>
    <head>
      
        <?php echo $stili;?>
         
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="../js/action.js"></script>
        <script src="../js/utility.js"></script>
        <script src="../js/template.js"></script>
        <script src="../js/model.js"></script>
        <style>
            
            
        </style>
        <script>
            //per l'acquisizione delle modifiche da lista valutazione
            $(document).on('input', '.get', function() 
            {
                var index = $('.valutazione').index($(this).closest('.valutazione'));
                if($(this).prop('nodeName')=="INPUT")
                    studente.Valutazioni[index].Data=$(this).val();
                else
                    studente.Valutazioni[index].Voto=+$(this).val();
            });


            let studente=JSON.parse('<?php echo $_POST["dati"];?>');
            let file;
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
                    studente.Valutazioni.push(new Valutazione(0,0,""));
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
                           // else
                           //     ValArray.push(new Valutazione($(this).attr("Id"),v,d));
                    });
                    //studente.Valutazioni=ValArray;



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
                     {   var f=$("#img_prof").attr('src').split('\\').pop();
                        if(f.includes("noimage.jpeg"))
                            f=null;
                        else
                            if($("#bt_load_img").val()=="")
                                f="invariata";
                        studente.Foto=f;
                        AggiornaStudente(JSON.stringify(studente),file);  
                     }
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
                                echo '<li id='.$val->ID.' class="valutazione">
                                <span><img width="30px" src="../risorse/imgs/voti.png"></span>
                                <span> <select class="get">';
                                for($i=1;$i<=10;$i=$i+0.5){
                                    $f=$i==$val->Voto?"selected":"";
                                    echo "<option $f value=$i>$i</option>";
                                }
                                echo '</select></span>	                       
                                <span><img width="30px" src="../risorse/imgs/calendar.png"></span>
                                <span> <input class="get" type="date" value="'.$val->Data.'" /></span>
                                
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

                    var index = $('.valutazione').index(listItem);
                    if(listItem.id!="0")
                    { 
                        studente.Valutazioni[index].Voto=-1; 
                        listItem.style.display="none";

                    }
                    else{
                        studente.Valutazioni.splice(index,1);
                        listItem.remove();
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
