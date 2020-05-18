
const RE_PASSWORD = /^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9!.@#$%^&*]{6,16}$/;
const RE_EMAIL = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
const RE_NAME = /^[a-zA-Z ]{1,16}$/;
const RE_USERNAME = /^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/;

var errorMessage = ""; //gestita da createErrorMessage


/* 
    controlla se l'item rispetta l'espressione regolare ==> ritorna booleano
    type è una stringa, specifica se si deve validare la form di "login" o di "registration"
*/
function validInput(item, reg_expr = null, type){
    if (item.value == "" || !reg_expr.test(item.value)){
        createErrorMessage(item,type);
        return false;
    } 
    else
        return true;
}

/*
    validazione form login
*/
function validateFormLogin() {
    var type = "login"
    var username = document.getElementById("username");
    var password = document.getElementById("password");
     
    if (!validInput(username, RE_USERNAME, type))                                  
    { 
        alert(errorMessage); 
        username.focus(); 
        return false; 
    } 
   
    if (!validInput(password, type))                               
    { 
        alert(errorMessage); 
        password.focus(); 
        return false; 
    } 
   
    return true; 
}

/*
    validazione form registrazione
*/
function validateFormRegistration() {
    var type = "registration"
    var name = document.getElementById("name");
    var surname = document.getElementById("surname");
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var rpassword = document.getElementById("confirmationPassword");
    
    if (!validInput(name, RE_NAME, type))                                  
    { 
        alert(errorMessage); 
        name.focus(); 
        return false; 
    } 
   
    if (!validInput(surname, RE_NAME, type))                               
    { 
        alert(errorMessage); 
        surname.focus(); 
        return false; 
    } 
    
    if (!validInput(username, RE_USERNAME, type))                                  
    { 
        alert(errorMessage); 
        username.focus(); 
        return false; 
    } 

    if (!validInput(email, RE_EMAIL, type))                                  
    { 
        alert(errorMessage); 
        email.focus(); 
        return false; 
    } 
   
    if (!validInput(password, RE_PASSWORD, type))                               
    { 
        alert(errorMessage); 
        password.focus(); 
        return false; 
    } 
   
    if (!validInput(rpassword, RE_PASSWORD, type))                               
    { 
        alert(errorMessage); 
        rpassword.focus(); 
        return false; 
    } 
   
    return true; 
}

/*
  se una password ripetuta non è corretta segnala un errore
*/
function checkRepeatPassword(password, rpassword) {
    if (!rpassword.value == '') {
      if (!(password.value == rpassword.value)) {
        return false;
      }
    }
}

/*
  crea messaggio di errore personalizzato in base all'item passato
  type è una stringa, specifica se si deve creare un errore per la form di "login" o di "registration"
*/
function createErrorMessage(item, type){
    if (item.value == ""){
        switch (item.name) {
            case 'name': errorMessage = "Inserisci il nome.";
                break;
            case 'surname': errorMessage = "Inserisci il cognome.";
                break;
            case 'username': errorMessage = "Inserisci l'username.";
                break;
            case 'email': errorMessage = "Inserisci l'email.";
                break;
            case 'password': errorMessage = "Inserisci la password.";
                break;
            case 'confirmationPassword': errorMessage = "Inserisci la password di conferma.";
                break;
        }
    }
    else if (type == "login"){
        switch (item.name) {
            case 'username': errorMessage = "L'username inserito non è corretto.";
                break;
        }
    }
    else if(type == "registration"){
        switch (item.name) {
            case 'name': errorMessage = "Controlla il Nome! Il campo dev'essere composto solamente da lettere.";
                break;
            case 'surname': errorMessage = "Controlla il Cognome! Il campo dev'essere composto solamente da lettere.";
                break;
            case 'username': errorMessage = "Controlla l'username! Il campo non può essere composto da caratteri speciali.";
                break;
            case 'email': errorMessage = "Controlla l'email! Il campo non rispetta la sintassi corretta.";
                break;
            case 'password': errorMessage = "Controlla la password! Dev'essere alfanumerica ed essere composta da almeno 6 caratteri.";
                break;
            case 'confirmationPassword': errorMessage = "La password di conferma è diversa dalla password!";
                break;
        }
    }

    
}


  
