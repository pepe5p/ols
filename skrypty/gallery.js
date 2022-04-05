function show(path) {
    document.getElementsByTagName("body")[0].style.overflow = "hidden";
    document.getElementById("container").style.display = "block";
    document.getElementById("foto").innerHTML = "<img src='" + path + "'/>";
}

function hide() {
    document.getElementsByTagName("body")[0].style.overflow = "";
    document.getElementById("container").style.display = "none";
}