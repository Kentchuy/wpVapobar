function safe(){
    console.log("log: fonction safe ");
    // une fois le doc chargé lance le tout

if(lireUnCookie('eu-disclaimer-vapobar') != "ejD86j7ZXF3x"){
    $("#monModal").modal({
        escapeClose: false,
        clickClose: false,
        showClose: false
    });
}
// S'il n'y a pas le cookie, cela active le disclaimer qui bloque la page

function creerUnCookie(nomCookie, valeurCookie, dureeJours){
    console.log("log: fonction creerUnCookie ");
    // Si le nombre de jours est spécifié
    if(dureeJours){
        var date = new Date();
        // Converti le nombre de jours spécifiés en ms
        date.setTime(date.getTime()+(dureeJours*24*60*60*1000));
        var expire = "; expire=" + date.toGMTString();
    }
    // Si aucune valeur de jour n'est spécifiée
    else{
        var expire = "";
    }
    document.cookie = nomCookie + "=" + valeurCookie + expire + "; path=/";
}

function lireUnCookie(nomCookie){
    console.log("log: fonction lireUnCookie " + nomCookie);
    // Ajoute le signe égal virgule au nom pour la recherche dans le tableau contenant tous les cookies
    var nomFormate = nomCookie + "=";
    // Tableau contenant tous les cookies
    var tableauCookies = document.cookie.split(';');
    // Recherche dans le tableau le cookie en question
    console.log(tableauCookies);
    for(var i=0; i < tableauCookies.length; i++){
        var cookieTrouve = tableauCookies[i];
        // Tant que l'on trouve un espace on le supprime
        while (cookieTrouve.charAt(0) == ' '){
            cookieTrouve = cookieTrouve.substring(1, cookieTrouve.length);
        }
        // Et si il n'y a plus d'espace devant on retourne le résultat qui devrait être le mix des deux paramètres
        if(cookieTrouve.indexOf(nomFormate) == 0){
            return cookieTrouve.substring(nomFormate.length, cookieTrouve.length);
        }
    }
    // On retourne une valeur null dans le cas où aucun cookie n'est trouvé
    console.log("log: fonction lireUnCookie echec aucun cookie trouvé");
    return null;
}

document.getElementById("actionDisclaimer").addEventListener("click", accepterLeDisclaimer);

// Création d'une fonction que l'on va associer au bouton Oui de notre modal par le biais de onclick
function accepterLeDisclaimer(){
    console.log("log: fonction accepterLeDisclaimer");
    creerUnCookie('eu-disclaimer-vapobar', "ejD86j7ZXF3x", 1);
    var cookie = lireUnCookie('eu-disclaimer-vapobar');
    alert(cookie);
}

}
$(document).ready(safe);