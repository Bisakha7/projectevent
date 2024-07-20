
      let categories_form = document.getElementById('categories_form');
      categories_form.addEventListener('submit', function(e) {
      e.preventDefault();
      add_category();
    })

function add_category(){
  let data = new FormData();  //allows to send files and images to the server
  data.append('name',categories_form.elements['category_name'].value);
  data.append('add_category','');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/category.php", true);

  xhr.onload = function() {
    var myModal = document.getElementById('categories');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

   if(this.responseText == 1){
    alert('success','New category added');
    
    categories_form.elements['category_name'].value = '';
    get_category();
   }
   else{
    alert('error','Invalid operation');
   }
  }
  xhr.send(data);
}  


function get_category() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/category.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function() {
    if (this.status === 200) {
      document.getElementById('category_data').innerHTML = this.responseText;
    }
  };
  xhr.send('get_category');
}

window.onload = function() {
  get_category();
}


window.onload = function(){
  get_category();
}


function del_category(val) {
  // Open the confirmation modal
  let confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'), {
    backdrop: 'static',
    keyboard: false
  });
  confirmModal.show();

  // Set up the confirmation button
  document.getElementById('confirmDeleteButton').onclick = function() {
    let data = new FormData();
    data.append('del_category', val);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/category.php", true);
    xhr.onload = function() {
      confirmModal.hide();
      if (this.responseText.trim() === '1') {
        alert('success', 'Category has been deleted');
        get_category(); // Refresh the categories table
      } else {
        alert('error', 'Deletion failed');
      }
    };

    xhr.onerror = function() {
      confirmModal.hide();
      alert('An error occurred. Please try again.');
    };

    xhr.send(data);
  };
}


