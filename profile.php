<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upscale Events - Profile</title>
</head>
<body>
  <?php 
  include('header.php');
  if(!(isset($_SESSION['login'])) || $_SESSION['login'] != true){
    header('Location: index.php');
    exit;
  }
  
  // Fetch user data based on session ID
  $user_exists = select("SELECT * FROM `user_register` WHERE `id`=?",[$_SESSION['uid']],'s');
  
  // Redirect to index.php if user does not exist
  if(mysqli_num_rows($user_exists) == 0){
    redirect('index.php');
  }
  
  // Fetch user details
  $row = mysqli_fetch_assoc($user_exists); 
  ?>
  
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 my-5 px-4">
        <h2 class="fw-bold text-center">Your Profile</h2>
        <div style="font-size:14px" class="text-center">
          <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
          <span class="text-secondary"> > </span>
          <a href="#" class="text-secondary text-decoration-none">Profile</a>
        </div>
      </div>

      <div class="col-md-6 offset-md-3">
        <div class="bg-white p-3 rounded">
            <h5 class="mb-3 fw-bold text-center">Your Information</h5>
            <div class="form-group">
              <label class="form-label">Name</label>
              <input type="text" name="name" value="<?php echo $row['username']?>" class="form-control form-control-sm">
            </div>
            <div class="form-group">
              <label class="form-label">Email</label>
              <input type="email" name="email" value="<?php echo $row['email']?>" class="form-control form-control-sm">
            </div>
            <div class="form-group">
              <label class="form-label">Phone</label>
              <input type="text" name="phone" value="<?php echo $row['phone']?>" class="form-control form-control-sm">
            </div>
           <a href="update_profile.php" class="btn btn-success btn-sm mt-5">Update profile</a>
           
        </div>
      </div>
    </div>
  </div>
  
  <?php include('footer.php'); ?>
  
 
</body>
</html>
