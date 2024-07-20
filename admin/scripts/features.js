

   
   let features_form = document.getElementById('features_form');
    let services_form = document.getElementById('services_form');
    features_form.addEventListener('submit', function(e) {
      e.preventDefault();
      add_feature();
    })

    function add_feature() {
      let data = new FormData();
      data.append('name', features_form.elements['feature_name'].value);
      data.append('add_feature', '');
  
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/features_crud.php", true);
      xhr.onload = function() {
          var myModal = document.getElementById('features');
          var modal = bootstrap.Modal.getInstance(myModal);
          modal.hide();
  
          if (this.responseText == 1) {
              alert('success', 'New feature added');
              features_form.elements['feature_name'].value = '';
              get_feature();
          } else {
              alert('error', 'Invalid operation');
          }
      }
      xhr.send(data);
  }
  
  function get_feature() {
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/features_crud.php", true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
          if (this.responseText) {
              document.getElementById('features_data').innerHTML = this.responseText;
          } else {
              alert('error', 'Failed to load features');
          }
      }
      xhr.send('get_feature');
  }
  
  function del_feature(val) {
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/features_crud.php", true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
          if (this.responseText == 1) {
              alert('success', 'Feature has been deleted');
              get_feature();
          } else if (this.responseText == 'event_added') {
              alert('error', 'Feature is added in the existing event');
          } else {
              alert('error', 'Deletion failed');
          }
      }
      xhr.send('del_feature=' + val);
  }

    window.onload = function() {
      get_feature();
    }
   

    services_form.addEventListener('submit', function(e) {
      e.preventDefault();
      add_service();
    })

    function add_service() {
      let data = new FormData(); //allows to send files and images to the server
      data.append('name', services_form.elements['service_name'].value);
      data.append('image', services_form.elements['service_image'].files[0]);
      data.append('description', services_form.elements['service_description'].value);
      data.append('add_service', '');

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/features_crud.php", true);

      xhr.onload = function() {
        var myModal = document.getElementById('services');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 'inv_img') {
          alert('error', 'Invalid image format');
        } else if (this.responseText == 'inv_size') {
          alert('error', 'Invalid image size');
        } else if (this.responseText == 'upd_failed') {
          alert('error', 'Upload failed');
        } else {
          alert('success', 'New service added');
          services_form.reset();

          get_service();
        }
      }
      xhr.send(data);
    }
  
    function get_service() {
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/features_crud.php", true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        document.getElementById('services_data').innerHTML = this.responseText;
      }
      xhr.send('get_service');
    }

    function del_service(val) {
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/features_crud.php", true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      xhr.onload = function() {
        if (this.responseText == 1) {
          alert('success', 'Service has been deleted');
          get_service();
        } else if (this.responseText == 'event_added') {
          alert('error', 'Feature is added in the existing event');
        } else {
          alert('error', 'Deletion failed');
        }

      }
      xhr.send('del_service=' + val);

    }
   
   
    window.onload = function() {
      get_service();
      get_feature();
    }
  
  