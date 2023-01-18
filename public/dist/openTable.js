function openTable(id) {
    var x = document.getElementById(id);

    if(x.style.display === "none") {
        x.style.display = "table-row";
    } else if( x.style.display === "table-row") {
        x.style.display = "none";
    }
}
