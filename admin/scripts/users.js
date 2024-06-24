




function get_users() {

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/users_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


  xhr.onload = function() {
    document.getElementById('users_data').innerHTML = this.responseText;
  }
  xhr.send('get_users');

}

window.onload = function() {
  get_users();
}

let edit_events_form = document.getElementById('edit_events_form');










function toggleStatus(id, val) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/users_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


  xhr.onload = function() {
    if (this.responseText == 1) {
      alert('success', 'Status  is changed');
      get_users();
    } else {
      alert('error', 'Something error occured');
    }
  }
  xhr.send('toggleStatus=' + id + '&value=' + val);
}

let add_image_form = document.getElementById('add_image_form');


function delete_user(user_id){
  if(confirm("Are you sure you want to delete user?")){
    let data = new FormData(); 
  data.append('user_id', user_id); 
  data.append('delete_user', ''); 
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/users_crud.php", true);

  xhr.onload = function() {
   

    if (this.responseText == '1') {
      alert('success', 'User has been removed');
      get_users();
    }  else {
      alert('error', 'Unable to remove user');
     

    }
  }
  xhr.send(data);

  }
 

 
  
}





