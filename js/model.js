class Utente {
    constructor( email,password) {
      this.Password = password;
      this.Mail = email;
    }
  
    getPassword() {
      return this.Password;
    }
  
    getEmail() {
      return this.Mail;
    }
  
    displayInfo() {
      return JSON.stringify(this);
    }
  }

  class Studente {
    constructor( i,n,c,f,v) {
      this.Id=i;
      this.Nome = n;
      this.Cognome = c;
      this.Foto = f;
      this.Valutazioni = v;
    }
  
    getNome() {
      return this.Nome;
    }
  
    getCognome() {
      return this.Cognome;
    }
    getFoto() {
      return this.Foto;
    }
    getValutazioni() {
      return this.Valutazioni;
    }
    getId() {
      return this.Id;
    }
    displayInfo() {
      return JSON.stringify(this);
    }
  }

  class Valutazione {
    constructor(i,v,d) {
      this.Id = i;
      this.Voto = v;
      this.Data = d; 
    }
  
    getId() {
      return this.Id;
    }
  
    getVoto() {
      return this.Voto;
    }
    getData() {
      return this.Data;
    }
    
  
    displayInfo() {
      return JSON.stringify(this);
    }
  }
  