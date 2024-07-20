




function get_users() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/users_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function() {
    if (this.status === 200) {
      document.getElementById('users_data').innerHTML = this.responseText;
    }
  };
  xhr.send('get_users');
}

window.onload = function() {
  get_users();
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


function delete_user(user_id) {
  // Open the confirmation modal
  let confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'), {
    backdrop: 'static',
    keyboard: false
  });
  confirmModal.show();

  // Set up the confirmation button
  document.getElementById('confirmDeleteButton').onclick = function() {
    let data = new FormData(); 
    data.append('user_id', user_id); 
    data.append('delete_user', ''); 

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users_crud.php", true);

    xhr.onload = function() {
      confirmModal.hide();
      if (this.responseText.trim() === '1') {
        alert('success', 'User has been removed');
        get_users(); // Refresh the users table
      } else {
        alert('error', 'Unable to remove user');
      }
    };

    xhr.onerror = function() {
      confirmModal.hide();
      alert('An error occurred. Please try again.');
    };

    xhr.send(data);
  };
}






