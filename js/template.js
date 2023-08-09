function ListItemTemplate(studente)
{
  var template= `<li class="user-item">
  <img src="`+GetPath(studente.Foto)+`" alt="Foto utente">
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