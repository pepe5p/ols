function next(nr) {
    document.getElementById("m" + nr).style.display = "none";
    if(nr==11) nr = -1;
    if(nr==4) nr = 7;
    document.getElementById("m" + (nr + 1)).style.display = "block";
}

function previous(nr) {
    document.getElementById("m" + nr).style.display = "none";
    if(nr==0) nr = 12;
    if(nr==8) nr = 5;
    document.getElementById("m" + (nr - 1)).style.display = "block";
}