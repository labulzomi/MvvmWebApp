<?php


?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="../js/model.js"></script>
<script src="../js/action.js"></script>

<link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
<link href='../risorse/css/stili.css' rel='stylesheet'>
</head>
<body>
<div>
    
    <div class="TitleBar">
        <div>
            <span>LOGIN</span>
        </div>
    </div>
    <div class="Contenitore">
        <div class="LoginArea">
            <span> <input type="text" id="tb_user" placeholder="Mail" value="mail@paologaleazzi.com"/></span><br>
            <span> <input type="password" id="tb_psw" placeholder="Password" value="PaoloPassword"/></span><br>
            <div class="Centra"><input class="GenericButton" id="bt_login" type="button" value="Login"/></div>
            <div class="Centra"><input class="GenericButton" id="bt_reg" type="button" value="Registrati"/> </div>
        </div>
    </div>
     
   
    <div id="snackbar">I dati inseriti non sono corretti</div>
</div>
</body>
</html>