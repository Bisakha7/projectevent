
    let general_data, contact_data;

    let generalSettings_form = document.getElementById('generalSettings_form');
    let website_title_inp = document.getElementById('website_title_inp');
    let website_info_inp = document.getElementById('website_info_inp');

    let contactSettings_form = document.getElementById('contactSettings_form');
   


    function get_general() {
      let website_title = document.getElementById('website_title');
      let website_info = document.getElementById('website_info');



      let shutdown_toggle = document.getElementById('shutdown-toggle');


      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/settings_crud.php", true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      xhr.onload = function() {
        general_data = JSON.parse(this.responseText);

        website_title.innerText = general_data.website_title;
        website_info.innerText = general_data.website_info;

        website_title_inp.value = general_data.website_title;
        website_info_inp.value = general_data.website_info;

        if (general_data.shutdown == 0) {
          shutdown_toggle.checked = false;
          shutdown_toggle.value = 0;
        } else {
          shutdown_toggle.checked = true;
          shutdown_toggle.value = 1;
        }


      }
      xhr.send('get_general');
    }

    generalSettings_form.addEventListener('submit', function(e) {
      e.preventDefault();
      update_general(website_title_inp.value, website_info_inp.value);

    })


    function update_general(website_title_val, website_info_val) {

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/settings_crud.php", true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      xhr.onload = function() {
        var myModal = document.getElementById('generalSettings');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
          alert('success', 'Changes Made Successfully');
          get_general();
        } else {
          alert('danger', 'No changes Made');
        }


      }
      xhr.send('website_title=' + website_title_val + '&website_info=' + website_info_val + '&update_general');
    }

    function update_shutdown(val) {
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/settings_crud.php", true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      xhr.onload = function() {

        if (this.responseText == 1 && general_data.shutdown == 0) {
          alert('success', 'Site has been shut down ');

        } else {
          alert('success', 'Shutdown mode is off');
        }
        get_general();


      }
      xhr.send('update_shutdown=' + val);

    }


    function get_contact() {

      let contact_p_id = ['location', 'map', 'ph1', 'ph2', 'email', 'insta', 'fb', 'twitter'];
      let iframe = document.getElementById('iframe');

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/settings_crud.php", true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      xhr.onload = function() {
        contact_data = JSON.parse(this.responseText);
        contact_data = Object.values(contact_data);

        for (i = 0; i < contact_p_id.length; i++) {
          document.getElementById(contact_p_id[i]).innerText = contact_data[i + 1];
        }
        iframe.src = contact_data[9];

        contact_inp(contact_data);


      }
      xhr.send('get_contact');
    }

    function contact_inp(contact_data) {
      let contact_inp_id = ['location_inp', 'map_inp', 'ph1_inp', 'ph2_inp', 'email_inp', 'insta_inp', 'fb_inp', 'twitter_inp', 'iframe_inp'];

      for (i = 0; i < contact_inp_id.length; i++) {
        document.getElementById(contact_inp_id[i]).value = contact_data[i + 1];
      }
    }

    function update_contact() {
      let index = ['location', 'map', 'ph1', 'ph2', 'email', 'insta', 'fb', 'twitter', 'iframe'];

      let contact_inp_id = ['location_inp', 'map_inp', 'ph1_inp', 'ph2_inp', 'email_inp', 'insta_inp', 'fb_inp', 'twitter_inp', 'iframe_inp'];

      let data_str = "";
      for (i = 0; i < index.length; i++) {
        data_str += index[i] + "=" + document.getElementById(contact_inp_id(i)).value + '&';
      }
      data_str += "update_contact";


      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/settings_crud.php", true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      xhr.onload = function() {
        var myModal = document.getElementById('contactSettings');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
          alert('success', 'Changes Saved Successfully');
          get_contact();
        } else {
          alert('error', 'No changes Made');
        }

      }
      xhr.send(data_str);
    }

    contactSettings_form.addEventListener('submit', function(e) {
      e.preventDefault();
      update_contact();
    })


    


  

  

  

    window.onload = function() {
      get_general();
      get_contact();
      
    }
  