function ListItemTemplate(studente)
{
  var template= `<li class="user-item">
  <img src="`+GetPath(studente.Foto)+`" onerror="this.onerror=null; this.src='../imgs/noimage.jpeg'" alt="Foto utente">
  <span class="user-name">`+studente.Nome+`</span>
  <span class="user-surname">`+studente.Cognome+`</span>
  <button class="edit-btn" onclick="editUser(`+studente.ID+`)">
   <img src="../risorse/imgs/modify.png">
  </button>
  <button class="delete-btn" onclick="deleteUser(`+studente.ID+`)">
  <img src="../risorse/imgs/deleteicon.png">
  </button>
</li>`;
return template;
}

function ListItemValutazioneTemplate()
{
  return `<li id=0 class="valutazione">
      <span><img width="30px" src="../risorse/imgs/voti.png"></span>
      <span> <select  class="get"><option value="" selected disabled hidden>?</option><option value="1">1</option><option value="1.5">1.5</option><option value="2">2</option><option value="2.5">2.5</option><option value="3">3</option><option value="3.5">3.5</option><option value="4">4</option><option value="4.5">4.5</option><option value="5">5</option><option value="5.5">5.5</option><option value="6">6</option><option value="6.5">6.5</option><option value="7">7</option><option value="7.5">7.5</option><option value="8">8</option><option value="8.5">8.5</option><option value="9">9</option><option value="9.5">9.5</option><option value="10">10</option></select></span>	                       
        <span><img width="30px" src="../risorse/imgs/calendar.png"></span>
      <span> <input type="date" class="get"></span>
      
      <button class="delete-button"  style=""></button>
      </li>`;
}