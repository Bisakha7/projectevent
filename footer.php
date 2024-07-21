<!DOCTYPE html>
<htm lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php
  $contact_query = "SELECT * FROM `contact_details` WHERE `id`=?";
  $settings_query = "SELECT * FROM `settings` WHERE `id`=?";
  $values = [1];
  $contact_result = mysqli_fetch_assoc(select($contact_query, $values, 'i'));
  $settings_result = mysqli_fetch_assoc(select($settings_query, $values, 'i'));
  ?>

  <div class="container-fluid mt-5 px-3 py-2" style="background-color:#eddea4;  ">
    <div class="row">
      <div class="col-lg-6 p-4">
        <h4 class="fw-bold mb-2 fs-3"><?php echo $settings_result['website_title']; ?></h4>
        <p><?php echo  $settings_result['website_info']; ?></p>
      </div>
      <div class="col-lg-4 p-4">
        <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a><br>
        <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About Us</a><br>
        <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact</a><br>
        <a href="services.php" class="d-inline-block mb-2 text-dark text-decoration-none">Services</a><br>
        <a href="events.php" class="d-inline-block mb-2 text-dark text-decoration-none">Events</a>
      </div>
      <div class="col-lg-2 p-4">
        <h5 class="mb-3">Follow Us:</h5>
        <?php
        if ($contact_result['insta'] != '') {
          echo <<<data
            <a href="$contact_result[insta]" class="d-inline-block mb-3 text-dark fs-5 me-2">
            <i class="bi bi-instagram me-1"></i></a>
            data;
        }
        ?>

        <a href="$contact_result[fb]" class="d-inline-block mb-3 text-dark fs-5 me-2">
          <i class="bi bi-facebook me-1"></i></a>
        <a href="$contact_result[twitter]" class="d-inline-block mb-3 text-dark fs-5 me-2">
          <i class="bi bi-twitter me-1"></i></a>
      </div>


    </div>
  </div>


</body>

<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
  function alert(type, msg, position = 'body') {
    let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
    let element = document.createElement('div');
    element.innerHTML = `
      <div class="alert ${bs_class} alert-dismissible fade show " role="alert">
        <strong class="me-3">${msg}</strong> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;

    if (position == 'body') {
      document.body.append(element);
      element.classList.add('custom-alert');
    } else {
      document.getElementById(position).appendChild(element);
    }
    setTimeout(remAlert, 2000);
  }

  function remAlert() {
    document.getElementsByClassName('alert')[0].remove();
  }

  function setActive() {
    let navbar = document.getElementById('nav-bar');
    let a_tag = navbar.getElementsByTagName('a');

    for (i = 0; i < a_tag.length; i++) {
      let file = a_tag[i].href.split('/').pop();
      let file_name = file.split('.')[0];

      if (document.location.href.indexOf(file_name) >= 0) {
        a_tag[i].classList.add('active');
      }
    }
  }

  let user_register = document.getElementById('user_register');

user_register.addEventListener('submit', function(e) {
  e.preventDefault();
  add_user();
});


function add_user() {
  let data = new FormData();

  data.append('username', user_register.elements['username'].value);
  data.append('email', user_register.elements['email'].value);
  data.append('password', user_register.elements['password'].value);
  data.append('confirm_pass', user_register.elements['confirm_pass'].value);
  data.append('phone', user_register.elements['phone'].value);
  data.append('address', user_register.elements['address'].value);
  data.append('register', '');

  let xhr = new XMLHttpRequest();
  xhr.open('POST', 'ajax/login_register.php', true);

  xhr.onload = function() {
    if (this.responseText == 'pass_mismatch') {
      alert('error', "Passwords do not match");
    } else if (this.responseText == 'email_already') {
      alert('error', "Email already exists");
    } else if (this.responseText == 'phone_already') {
      alert('error', "Phone number already exists");
    } else if (this.responseText == 'ins_failed') {
      alert('error', "Registration failed");
      
    } else if (this.responseText == '1') {
      alert('success', "Registration Successful");
      user_register.reset();
      var myModal = document.getElementById('registermodal');
      var modal = bootstrap.Modal.getInstance(myModal);
      modal.hide();
    } else {
      alert('error', "Unknown error occurred");
    }
  }
  xhr.send(data);
}

let login_form = document.getElementById('login_form');
login_form.addEventListener('submit', function(e) {
  e.preventDefault();
  login_user();
});

function login_user() {
  let data = new FormData();

  data.append('email_mobile', login_form.elements['email_mobile'].value);
  data.append('password', login_form.elements['password'].value);
  data.append('login', '');

  let xhr = new XMLHttpRequest();
  xhr.open('POST', 'ajax/login_register.php', true);

  xhr.onload = function() {
    if (this.responseText == 'inv_email_mobile') {
      alert('error', "Invalid email or mobile");
    } else if (this.responseText == 'not_verified') {
      alert('error', "You are not verified");}
       else if (this.responseText == 'inactive') {
      alert('error', 'Account is inactive');
    } else if (this.responseText == 'inv_pass') {
      alert('error', 'Incorrect Password');
    } else if (this.responseText == '1') {
      window.location = window.location.pathname;
    } else {
      alert('error', 'Unknown error occurred');
    }
  }
  xhr.send(data);
}

  function checkLogin(status, event_id) {
    if (status) {
      window.location.href = 'confirm_booking.php?id=' + event_id;
    } else {
      alert('error', 'Please login first');
    }
  }

  setActive();
</script>



</html>