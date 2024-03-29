<?php
session_start();

$caso=rand(1,1000);
$stili="<link href='../risorse/css/headerbarra.css?caso=".$caso."' rel='stylesheet'>
<link href='../risorse/css/snackbar.css?caso=".$caso."' rel='stylesheet'>";



?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
 
<?php echo $stili;?>
<script src="../js/model.js"></script>
<script src="../js/action.js"></script>
<script src="../js/utility.js"></script>
<script>
//chiamate per login.php

$(document).ready(function() 
{
    $("#bt_login").on("click", function() {     

      if (!CheckMail($("#tb_user").val())) {
        ShowSnackBar();
      }
      else
      {
        //procedo alla verifica della login
        var utente=new Utente($("#tb_user").val(),$("#tb_psw").val());
        var formData = new FormData();
        formData.append("dati",utente.displayInfo());
        formData.append("mode",5);
        formData.append("online",1);
        ChiamataGenerica(formData);
      }
    });

    $("#bt_reg").on("click", function() {     

        if (!CheckMail($("#tb_user").val())) {
          ShowSnackBar();
        }
        else
        {
          //procedo alla verifica della disponibilità
          var utente=new Utente($("#tb_user").val(),$("#tb_psw").val());
          var formData = new FormData();
          formData.append("dati",utente.displayInfo());
          formData.append("mode",6);
          formData.append("online",1);
          ChiamataGenerica(formData);
        }
      });
  });


    </script>

<link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
<link href='../risorse/css/stili.css' rel='stylesheet'>
</head>
<body>
<div>
    
    <div class="TitleBar">        
        <div>
            <span>LOGIN</span>
        </div>
        <div></div>
    </div>
    <div class="Contenitore Login">
        <div class="LoginArea">
            <span> <input class="InsertText" type="text" id="tb_user" placeholder="Mail" value="mail@paologaleazzi.com"/></span><br>
            <span> <input class="InsertText" type="password" id="tb_psw" placeholder="Password" value="PaoloPassword"/></span><br>
            <div class="Centra"><input class="GenericButton" id="bt_login" type="button" value="Login"/></div>
            <div class="Centra"><input class="GenericButton" id="bt_reg" type="button" value="Registrati"/> </div>
        </div>
    </div>
     
   
    <div id="snackbar"></div>
</div>
</body>
</html>