
function pokaz() {
    document.getElementById("navig").style.display = "block";
    document.getElementById("options").innerHTML = "<i class='icon-cancel'></i>";
    document.getElementById("options").setAttribute("onclick", "schowaj()");
}
function schowaj() {
    document.getElementById("navig").style.display = "none";
    document.getElementById("options").innerHTML = "<i class='icon-th-list'></i>";
    document.getElementById("options").setAttribute("onclick", "pokaz()");
}