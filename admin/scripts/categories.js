
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


function get_category(){
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/category.php", true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  xhr.onload = function(){
    document.getElementById('category_data').innerHTML = this.responseText;
}
xhr.send('get_category');
}

window.onload = function(){
  get_category();
}


function del_category(val){
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/category.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function() {
    if(this.responseText == 1){
      alert('success','Category has been deleted');
      get_category();
    }
    else{
      alert('error','Deletion failed');
    }
   
  }
  xhr.send('del_category='+val);

}

