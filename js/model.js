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
      this.ID=i;
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
      
      this.Voto = v;
      this.Data = d; 
      this.ID = i;
    }
 
  
    
  
    getVoto() {
      return this.Voto;
    }
    getData() {
      return this.Data;
    }
    getId() {
      return this.Id;
    }
    
    
  
    displayInfo() {
      return JSON.stringify(this);
    }
  }
  