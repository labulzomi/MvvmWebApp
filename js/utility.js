function GetPath(img)
{
  if(img==null)
    return "http://areaverifica.altervista.org/GaleazziOnline/risorse/imgs/noimage.jpeg";
  else
  return "http://areaverifica.altervista.org/Galeazzi/img/"+img;
}
function CheckMail(email)
{
     
    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (emailPattern.test(email)) {
      return true;
    } else {
      return false;
    }
}


function CheckValutazioni(valutazioni)
{
  var check=true;
  valutazioni.each(function( index ) 
  {                       
          var v=$(this).find("select option:selected")[0].text;
          var d=$(this).find("input")[0].value;
          if(v=="?"||d==""){
              check=false;
               
          }
          
  });
  return check;
}


function GestoreCambioImmagine(studente,file)
{
  const imageInput = document.getElementById('bt_load_img');
        imageInput.addEventListener('change', function() {
            const file = imageInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                   
                    $("#img_prof").attr("src",event.target.result);
                    studente.Foto= file.name;       
                };
                reader.readAsDataURL(file);
            } 
        });
}

function cleanArea(studente)
{
  //reset img
   $("#img_prof").attr('src',"http://areaverifica.altervista.org/GaleazziOnline/risorse/imgs/noimage.jpeg");
    $("#bt_load_img")[0].files[0]=null;
    
//reset testi
    $('#tb_nome').val("");
    $('#tb_cognome').val("");
//reset valutazioni
  $("#studentList").empty();
  studente=new Studente(0,"","","",new Array());
}

function checkValidPath(path)
{
  var estensione=path.split('.').pop();
  if(estensione==null)
  return false;
else
return true;
}