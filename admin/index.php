<?php
require('inc/essentials.php');
require('inc/db_config.php');

session_start();
if ((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
  redirect('dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <?php
  require_once('inc/links.php');
  ?>
  <link rel="stylesheet" href="css/style.css">

  <style>
    .login-form {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 400px;
    }
  </style>
</head>

<body class="bg-light">
  <div class="login-form  rounded bg-white shadow overflow-hidden">
    <form method="POST">
      <h4 class="text-center fw-bold py-3 bg-dark text-white">Admin Login </h4>
      <div class="p-4">
        <div class=" mb-3">
          <label class="form-label">Username: </label>
          <input name="admin_name" type="text" class="form-control shadow-none text-center" required>
        </div>
        <div class=" mb-4">
          <label class="form-label">Password: </label>
          <input name="admin_pass" type="password" class="form-control shadow-none text-center" required>
        </div>
        <button name="admin_login" class="btn text-white custom-bg shadow-none">Login</button>
      </div>
    </form>
  </div>



  <?php
  if (isset($_POST['admin_login'])) {
    $frm_data = filtration($_POST); //$_POST gets in array 
    $query = "SELECT * FROM `admin_credentials` WHERE `admin_name`=? AND `admin_pass`=?";
    //=? are placeholder for values that will be behold later
    $values = [$frm_data['admin_name'], $frm_data['admin_pass']]; //values for placeholder from user input
    $res = select($query, $values, "ss"); //sending parameter to res fucntion
    if ($res->num_rows == 1) { //if user has logged in successfully
      $row = mysqli_fetch_assoc($res);
      $_SESSION['adminLogin'] = true;
      $_SESSION['adminID'] = $row['id'];
      redirect('dashboard.php');
    } else {
      alert('error', 'Login Failed - Invalid Credentials!');
    }
  }
  ?>


  <?php
  require('inc/script.php');
  ?>
</body>

</html>