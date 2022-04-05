
//druzyny
function dodajd() {
    document.getElementById("new").style.display = "block";
    document.getElementById("newtab").style.display = "none";
}

function edytujd(numer, nrdruzyny, nazwa, kategoria, grupa, wygrane, przegrane, setywyg, setyprzg, punktyzd, punktystr) {
    document.getElementById("img" + numer).innerHTML = '<div class="tilestatspanel"><input type="file" name="teamimg"/></div>';
    document.getElementById("edytuj" + numer).innerHTML = '<div class="tilestatspanel"><input type="submit" name="update_button" value="Zaktualizuj" /></div>';
    document.getElementById("usun" + numer).innerHTML = '<div class="tilestatspanel"><a href="admd.php">Anuluj</a></div>';
    document.getElementById("nrdruzyny" + numer).innerHTML = '<input type="number" name="nrdruzyny" min="1" value="' + nrdruzyny + '" />';
    document.getElementById("nazwa" + numer).innerHTML = '<input type="text" name="nazwa" value="' + nazwa + '" />';

    if(kategoria=="OLS1"){
        document.getElementById("kategoria" + numer).innerHTML = '<select style="height: 50px; background-color: #ccc;" name="kategoria"><option>OLS1</option><option>OLS2</option></select>';
    } else {
        document.getElementById("kategoria" + numer).innerHTML = '<select style="height: 50px; background-color: #ccc;" name="kategoria"><option>OLS2</option><option>OLS1</option></select>';
    }
    document.getElementById("grupa" + numer).innerHTML = '<input type="text" name="grupa" value="' + grupa + '" />';
    document.getElementById("wygrane" + numer).innerHTML = '<input class="dr" type="number" name="wygrane" min="0" value="' + wygrane + '" />';
    document.getElementById("przegrane" + numer).innerHTML = '<input class="dr" type="number" name="przegrane" min="0" value="' + przegrane + '" />';
    document.getElementById("setywyg" + numer).innerHTML = '<input class="dr" type="number" name="setywyg" min="0" value="' + setywyg + '" />';
    document.getElementById("setyprzg" + numer).innerHTML = '<input class="dr" type="number" name="setyprzg" min="0" value="' + setyprzg + '" />';
    document.getElementById("punktyzd" + numer).innerHTML = '<input class="dr" type="number" name="punktyzd" min="0" value="' + punktyzd + '" />';
    document.getElementById("punktystr" + numer).innerHTML = '<input class="dr" type="number" name="punktystr" min="0" value="' + punktystr + '" />';
}

function usund(numer) {
    document.getElementById("edytuj" + numer).innerHTML = '<div class="tilestatspanel"><input type="submit" name="delete_button" value="Usuń" /></div>';
    document.getElementById("usun" + numer).innerHTML = '<div class="tilestatspanel"><a href="admd.php">Anuluj</a></div>';
}



//mecze
function pokazkat() {
    var kat = document.getElementById("kategoria").value;

    if (kat != "all") {
        if(kat == "OLS1i") {
            document.getElementById("idols1").style.display = "block";
            document.getElementById("idols2").style.display = "none";
        } else {
            document.getElementById("idols1").style.display = "none";
            document.getElementById("idols2").style.display = "block";
        }
    } else {
        document.getElementById("idols1").style.display = "none";
        document.getElementById("idols2").style.display = "none";
    }
}

function pokazkatn() {
    var katn = document.getElementById("kategorian").value;

    if (katn == "OLS1") {
        document.getElementById("idgoscols1").style.display = "block";
        document.getElementById("idgoscols2").style.display = "none";
        document.getElementById("idgospols1").style.display = "block";
        document.getElementById("idgospols2").style.display = "none";
        document.getElementById("versus").style.backgroundColor = "#223a5e";
    } else if (katn == "OLS2") {
        document.getElementById("idgoscols1").style.display = "none";
        document.getElementById("idgoscols2").style.display = "block";
        document.getElementById("idgospols1").style.display = "none";
        document.getElementById("idgospols2").style.display = "block";
        document.getElementById("versus").style.backgroundColor = "#dd6062";
    }
}

function dodajm() {
    document.getElementById("new").style.display = "block";
}

function edytujm(numer, data, godzina, gosc1s, gosp1s, gosc2s, gosp2s, gosc3s, gosp3s) {
    document.getElementById("edytuj" + numer).innerHTML = '<div class="tilestatspanel" style="width: 50%; margin: 0 0 2px 0; float: left;"><input type="submit" name="update_button" value="Zaktualizuj" /></div>';
    document.getElementById("usun" + numer).innerHTML = '<div class="tilestatspanel" style="width: 50%; margin: 0 0 2px 0; float: left;"><a href="admm.php">Anuluj</a></div>';
    document.getElementById("data" + numer).innerHTML = '<input type="date" name="data" value="' + data + '" />';
    document.getElementById("godzina" + numer).innerHTML = '<input type="text" name="godzina" value="' + godzina + '" />';
    document.getElementById("gosc1s" + numer).innerHTML = '<input class="m" type="number" name="gosc1s" value="' + gosc1s + '" min="0" />';
    document.getElementById("gosp1s" + numer).innerHTML = '<input class="m" type="number" name="gosp1s" value="' + gosp1s + '" min="0" />';
    document.getElementById("gosc2s" + numer).innerHTML = '<input class="m" type="number" name="gosc2s" value="' + gosc2s + '" min="0" />';
    document.getElementById("gosp2s" + numer).innerHTML = '<input class="m" type="number" name="gosp2s" value="' + gosp2s + '" min="0" />';
    document.getElementById("gosc3s" + numer).innerHTML = '<input class="m" type="number" name="gosc3s" value="' + gosc3s + '" min="0" />';
    document.getElementById("gosp3s" + numer).innerHTML = '<input class="m" type="number" name="gosp3s" value="' + gosp3s + '" min="0" />';
}

function usunm(numer) {
    document.getElementById("edytuj" + numer).innerHTML = '<div class="tilestatspanel" style="width: 50%; margin: 0 0 2px 0; float: left;"><input type="submit" name="delete_button" value="Usuń" /></div>';
    document.getElementById("usun" + numer).innerHTML = '<div class="tilestatspanel" style="width: 50%; margin: 0 0 2px 0; float: left;"><a href="admm.php">Anuluj</a></div>';
}

//TABELE
function dodajt() {
    document.getElementById("newtab").style.display = "block";
    document.getElementById("new").style.display = "none";
}