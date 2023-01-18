function openForm(id, foreign_id) {
  var x = document.getElementById(id);
  var id = x.querySelector('.foreign_id');
  id.value = foreign_id;
  console.log(id);
  x.style.display = "flex";
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