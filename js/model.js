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
  