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
