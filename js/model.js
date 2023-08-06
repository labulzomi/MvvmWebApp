class Utente {
    constructor( email,password) {
      this.password = password;
      this.email = email;
    }
  
    getPassword() {
      return this.password;
    }
  
    getEmail() {
      return this.email;
    }
  
    displayInfo() {
      return JSON.stringify(this);
    }
  }
  