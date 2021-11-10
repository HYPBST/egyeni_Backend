if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
function validateForm(){
    let gyarto_hiba=false;
    let modell_hiba=false;
    let tarhely_hiba=false;
    let memoria_hiba=false;
    let hiba_uzenet="";
    let gyarto = document.forms["form"]["gyarto"].value;
    let modell = document.forms["form"]["modell"].value;
    let tarhely = document.forms["form"]["tarhely"].value;
    let memoria = document.forms["form"]["memoria"].value;
    if(gyarto==""){
        gyarto_hiba=true;
        hiba_uzenet+="A gyártó mezőt ki kell tölteni\n"
    }
    if(modell==""){
        modell_hiba=true;
        hiba_uzenet+="A modell mezőt ki kell tölteni\n"
    }
    if(tarhely<1){
        tarhely_hiba=true;
        hiba_uzenet+="A tárhely nem lehet kisebb, mint 1.\n"
    }
    if(memoria<1){
        memoria_hiba=true;
        hiba_uzenet+="A memória nem lehet kisebb, mint 1.\n"
    }
    if(memoria_hiba||tarhely_hiba||modell_hiba||gyarto_hiba){
        alert(hiba_uzenet);
        return false;
    }
    else{
        return true;
    }
}
