

let gallerySettings_form = document.getElementById('gallerySettings_form');
let gallery_picture_inp = document.getElementById('gallery_picture_inp');

gallerySettings_form.addEventListener('submit',function(e){
  e.preventDefault();
  
  add_picture();
})


function add_picture(){
  let data = new FormData();  //allows to send files and images to the server
  data.append('picture',gallery_picture_inp.files[0]); //files[0] select first picture selected
  data.append('add_picture',''); // sends index

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/images_crud.php", true);

  xhr.onload = function() {
    var myModal = document.getElementById('gallerySettings');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

   if(this.responseText == 'inv_img'){
    alert('error','Invalid image format');
   }
   else if(this.responseText == 'inv_size'){
    alert('error','Invalid image size');
   }
   else if(this.responseText == 'upd_failed'){
    alert('error','Upload failed');
   }
   else{
    alert('success','New image added');
    
    gallery_picture_inp.value = '';
    get_picture();
   }



  }
  xhr.send(data);



}

function get_picture(){
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/images_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function() {
    document.getElementById('gallery_data').innerHTML = this.responseText;
   

  }
  xhr.send('get_picture');

}

function del_picture(val){
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/images_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function() {
    if(this.responseText == 1){
      alert('success','Image has been deleted');
      get_picture();
    }
    else{
      alert('error','Deletion failed');
    }
   
  }
  xhr.send('del_picture='+val);

}

window.onload = function() {
  

  get_picture();
}
