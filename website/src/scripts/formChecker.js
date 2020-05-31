
var RE_PASSWORD = /^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9!.@#$%^&*]{6,16}$/;
var RE_EMAIL = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
var RE_NAME = /^[a-zA-Z ]{1,16}$/;
var RE_USERNAME = /^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/;

var errorMessage = ""; //managed by createErrorMessage function

/* 
    check if the item respects the regular expression ==> return boolean
*/
function validInput(item, reg_expr, isLogin){
    if (item.value == "" || !reg_expr.test(item.value)){
        createErrorMessage(item,isLogin);
        return false;
    } 
    else
        return true;
}

/*
    profile form validation
*/
function validateFormProfile(){
    var name = document.getElementById("name");
    var surname = document.getElementById("surname");

    if (!validInput(name, RE_NAME, false))                                  
    { 
        alert(errorMessage); 
        name.focus(); 
        return false; 
    } 
   
    if (!validInput(surname, RE_NAME, false))                               
    { 
        alert(errorMessage); 
        surname.focus(); 
        return false; 
    } 
}

/*
    login form validation
*/
function validateFormLogin() {
    var username = document.getElementById("username");
    var password = document.getElementById("password");
     
    if (!validInput(username, RE_USERNAME, true))                                  
    { 
        alert(errorMessage); 
        username.focus(); 
        return false; 
    } 
   
    if (!validInput(password, null, true))                               
    { 
        alert(errorMessage); 
        password.focus(); 
        return false; 
    } 
   
    return true; 
}

/*
    registration form validation
*/
function validateFormRegistration() {
    var name = document.getElementById("name");
    var surname = document.getElementById("surname");
    var username = document.getElementById("username");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var rpassword = document.getElementById("confirmation-password");
    
    if (!validInput(name, RE_NAME, false))                                  
    { 
        alert(errorMessage); 
        name.focus(); 
        return false; 
    } 
   
    if (!validInput(surname, RE_NAME, false))                               
    { 
        alert(errorMessage); 
        surname.focus(); 
        return false; 
    } 
    
    if (!validInput(username, RE_USERNAME, false))                                  
    { 
        alert(errorMessage); 
        username.focus(); 
        return false; 
    } 

    if (!validInput(email, RE_EMAIL, false))                                  
    { 
        alert(errorMessage); 
        email.focus(); 
        return false; 
    } 
   
    if (!validInput(password, RE_PASSWORD, false))                               
    { 
        alert(errorMessage); 
        password.focus(); 
        return false; 
    } 
   
    if (!validInput(rpassword, RE_PASSWORD, false))                               
    { 
        alert(errorMessage); 
        rpassword.focus(); 
        return false; 
    } 

    checkPasswords(password,rpassword);

    return true;
}

/*
    image format validation and preview
*/
function validateImage($previewElemId) { 
    var fileInput =  document.getElementById('file-upload'); 
    var filePath = fileInput.value; 

    if (filePath!=""){
        var allowedExtensions =  
                /(\.jpg|\.jpeg|\.png)$/i; 
                
        if (!allowedExtensions.exec(filePath)) { 
            alert("Il tipo di file selezionato non \u00E8 valido. Solo i formati JPG, JPEG e PNG sono supportati."); 
            fileInput.value = ''; 
            return false; 
        }  
        else  
        { 
            //display image preview
            if (fileInput.files && fileInput.files[0]) { 
                var reader = new FileReader(); 
                reader.onload = function(e) { 
                    document.getElementById( 
                        $previewElemId).setAttribute("src",e.target.result);
                }; 
                        
                reader.readAsDataURL(fileInput.files[0]); 
            } 
        }
    }
}

function validateComment(){
    var comment =  document.getElementById('comment-input');
    if (comment.value==""){
        alert("Inserisci un commento!");
        return false;
    }
    return true;
}

/*
    check if the confirmation password and the password are the same
*/
function checkPasswords(password, rpassword) {
    if (rpassword.value != "") {
        if (password.value != rpassword.value) {
            createErrorMessage(rpassword,false);
            alert(errorMessage); 
            rpassword.focus(); 
            return false;
        }
    }
}

/*
    creates custom error message based on the provided item
*/
function createErrorMessage(item, isLogin){
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
            case 'confirmation-password': errorMessage = "Inserisci la password di conferma.";
                break;
        }
    }
    else if (isLogin){
        switch (item.name) {
            case 'username': errorMessage = "L'username inserito non \u00E8 corretto.";
                break;
        }
    }
    else{
        switch (item.name) {
            case 'name': errorMessage = "Controlla il Nome! Il campo dev'essere composto solamente da lettere.";
                break;
            case 'surname': errorMessage = "Controlla il Cognome! Il campo dev'essere composto solamente da lettere.";
                break;
            case 'username': errorMessage = "Controlla l'username! Il campo non pu\u00F2 essere composto da caratteri speciali.";
                break;
            case 'email': errorMessage = "Controlla l'email! Il campo non rispetta la sintassi corretta.";
                break;
            case 'password': errorMessage = "Controlla la password! Dev'essere alfanumerica ed essere composta da almeno 6 caratteri.";
                break;
            case 'confirmation-password': errorMessage = "La password di conferma \u00E8 diversa dalla password!";
                break;
        }
    }
    
}


  
