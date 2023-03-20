function openForm(id, foreign_id) {
  var x = document.getElementById(id);
  var y = foreign_id;
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

function openDeleteForm(formID, elementID, routeName) {
  var x = document.getElementById(formID);
  x.style.display = "flex";
  route = "https://megaelectrical-hospitalstesting.co.uk/" + routeName + "/" + elementID;
  x.querySelector("form").action = route;
}

function editDefectForm(formID, remedialID, remedialName, remedialPrice) {
  var x = document.getElementById(formID);
  x.style.display = "flex";

  var ID = x.querySelector('#price_id');
  ID.value = remedialID;

  var name = x.querySelector('#defect');
  name.value = remedialName;

  var price = x.querySelector('#price');
  price.value = remedialPrice.toFixed(2);
}