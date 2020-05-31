function validateFormAddArticle(){
    var brand = document.getElementById("brand");
    var model = document.getElementById("model");
    var price = document.getElementById("price");
    var date = document.getElementById("date");
    var amazonLink = document.getElementById("amazon-link");
    var description = document.getElementById("description");

    if (brand.value=="")                                 
    {
        alert("Il campo \"marca\" non può essere vuoto."); 
        brand.focus(); 
        return false; 
    } 
    if (model.value=="")                                 
    {
        alert("Il campo \"modello\" non può essere vuoto."); 
        model.focus(); 
        return false; 
    } 
    if (price.value=="")                                 
    {
        alert("Il campo \"prezzo di lancio\" non può essere vuoto."); 
        price.focus(); 
        return false; 
    } 
    if (date.value=="")                                 
    {
        alert("Il campo \"data di lancio\" non può essere vuoto."); 
        date.focus(); 
        return false; 
    } 
    if (amazonLink.value=="")                                 
    {
        alert("Il campo \"link amazon\" non può essere vuoto."); 
        amazonLink.focus(); 
        return false; 
    } 
    if (description.value=="")                                 
    {
        alert("Il campo \"descrizione prodotto\" non può essere vuoto."); 
        description.focus(); 
        return false; 
    } 
    return true;
}

