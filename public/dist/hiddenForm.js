function openForm(id, foreign_id) {
  var x = document.getElementById(id);
  var y = foreign_id;
  console.log(foreign_id);
  if(y == 0) {
    x.style.display = "flex";
  } 
  if(y != 0) {
    var idInput = x.querySelector('.foreign_id');
    idInput.value = y;
    x.style.display = "flex";
  }
  
}

function closeForm(id) {
  var x = document.getElementById(id);
  x.style.display = "none";
}

function openError() {
  var error = document.getElementById("errorAlert");
  
  if (error.style.display = "block") {
      var form = error.parentElement;
      var container = form.parentElement;
      container.style.display = "flex";
  }
}