
let add_events_form = document.getElementById('add_events_form');
add_events_form.addEventListener('submit', function(e) {
  e.preventDefault();
  add_event();
});

function add_event() {
  let data = new FormData(); //allows to send files and images to the server
  data.append('name', add_events_form.elements['event_name'].value);
  data.append('category', add_events_form.elements['event_category'].value);
  data.append('price', add_events_form.elements['event_price'].value);
  data.append('description', add_events_form.elements['event_description'].value);

  let feature = [];
  add_events_form.elements['event_feature'].forEach(e => {
    if (e.checked) {
      feature.push(e.value);
    }
  })

  data.append('feature', JSON.stringify(feature));


  data.append('add_event', '');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/event_crud.php", true);

  xhr.onload = function() {
    var myModal = document.getElementById('add_events');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if (this.responseText == 1) {
      alert('success', 'New event added');

      add_events_form.reset();
      get_event();
    } else {
      alert('error', 'correct');
    }
  }
  xhr.send(data);
}

function get_event() {

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/event_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


  xhr.onload = function() {
    document.getElementById('events_data').innerHTML = this.responseText;
  }
  xhr.send('get_event');

}

window.onload = function() {
  get_event();
}

let edit_events_form = document.getElementById('edit_events_form');


function edit_event(id) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/event_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


  xhr.onload = function() {
    let data = JSON.parse(this.responseText);
    edit_events_form.elements['event_name'].value = data.event_data.name;
    edit_events_form.elements['event_category'].value = data.event_data.category;
    edit_events_form.elements['event_price'].value = data.event_data.price;
    edit_events_form.elements['event_description'].value = data.event_data.description;
    edit_events_form.elements['event_id'].value = data.event_data.id;

    edit_events_form.elements['event_feature'].forEach(e => {
      if (data.feature.includes(Number(e.value))) {
        e.checked = true;
      }
    })



  }
  xhr.send('get_edit_event=' + id);


}

edit_events_form.addEventListener('submit', function(e) {
  e.preventDefault();
  edit_submit_event();
});


function edit_submit_event() {
  let data = new FormData(); //allows to send files and images to the server

  data.append('event_id', edit_events_form.elements['event_id'].value);
  data.append('name', edit_events_form.elements['event_name'].value);
  data.append('category', edit_events_form.elements['event_category'].value);
  data.append('price', edit_events_form.elements['event_price'].value);
  data.append('description', edit_events_form.elements['event_description'].value);

  let feature = [];
  edit_events_form.elements['event_feature'].forEach(e => {
    if (e.checked) {
      feature.push(e.value);
    }
  })

  data.append('feature', JSON.stringify(feature));


  data.append('edit_event', '');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/event_crud.php", true);

  xhr.onload = function() {
    var myModal = document.getElementById('edit_events');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if (this.responseText == 1) {
      alert('success', 'Event data edited');

      edit_events_form.reset();
      get_event();
    } else {
      alert('error', 'Failed Editing');
    }
  }
  xhr.send(data);
}



function toggleStatus(id, val) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/event_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


  xhr.onload = function() {
    if (this.responseText == 1) {
      alert('success', 'Status of event is changed');
      get_event();
    } else {
      alert('error', 'Something error occured');
    }
  }
  xhr.send('toggleStatus=' + id + '&value=' + val);


}

let add_image_form = document.getElementById('add_image_form');

add_image_form.addEventListener('submit', function(e) {
  e.preventDefault();
  add_image();
});

function add_image() {
  let data = new FormData(); 
  data.append('image', add_image_form.elements['event_image'].files[0]); 
  data.append('event_id', add_image_form.elements['event_id'].value); 
  data.append('add_image', ''); 

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/event_crud.php", true);

  xhr.onload = function() {
   

    if (this.responseText == 'inv_img') {
      alert('error', 'Invalid image format','image-alert');
    } else if (this.responseText == 'inv_size') {
      alert('error', 'Invalid image size','image-alert');
    } else if (this.responseText == 'upd_failed') {
      alert('error', 'Upload failed');
    } else {
      alert('success', 'New event image added','image_alert');
      event_images(add_image_form.elements['event_id'].value,document.querySelector("#events_images .modal-title").innerText);

      add_image_form.reset();
    }
  }
  xhr.send(data);

}


function event_images(id,rname){
  document.querySelector("#events_images .modal-title").innerText =rname;
  add_image_form.elements['event_id'].value = id;
  add_image_form.elements['event_image'].value = '';

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/event_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


  xhr.onload = function() {
    document.getElementById('event_image_data').innerHTML =this.responseText;
  }
  xhr.send('get_event_image='+id);


}

function del_image(img_id,event_id){
  let data = new FormData(); 
  data.append('image_id', img_id); 
  data.append('event_id', event_id); 
  data.append('del_image', ''); 

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/event_crud.php", true);

  xhr.onload = function() {
   

    if (this.responseText == '1') {
      alert('success', 'Image Removed','image_alert');
      event_images(event_id,document.querySelector("#events_images .modal-title").innerText);
    }  else {
      alert('error', 'Unable to remove image','image-alert');
     

    }
  }
  xhr.send(data);
  
}

function thumbnail_image(img_id,event_id){
  let data = new FormData(); 
  data.append('image_id', img_id); 
  data.append('event_id', event_id); 
  data.append('thumbnail_image', ''); 

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/event_crud.php", true);

  xhr.onload = function() {
   

    if (this.responseText == '1') {
      alert('success', 'Image Thumbnail Changed','image_alert');
      event_images(event_id,document.querySelector("#events_images .modal-title").innerText);
    }  else {
      alert('error', 'Unable to change thumbnail','image-alert');
     

    }
  }
  xhr.send(data);
  
}

function del_event(event_id){
  if(confirm("Are you sure you want to delete it?")){
    let data = new FormData(); 
  data.append('event_id', event_id); 
  data.append('del_event', ''); 
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/event_crud.php", true);

  xhr.onload = function() {
   

    if (this.responseText == '1') {
      alert('success', 'Event has been removed');
      get_event();
    }  else {
      alert('error', 'Unable to remove event');
     

    }
  }
  xhr.send(data);

  }
 

 
  
}





