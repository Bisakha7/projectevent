 <?php
  require('admin/inc/db_config.php');
  require('admin/inc/essentials.php');
  session_start();
  ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Upscale Events</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <link rel="stylesheet" href="css/style.css">

 </head>

 <body>

   <?php
    $settings_query = "SELECT * FROM `settings` WHERE `id`=?";
    $values = [1];
    $settings_result = mysqli_fetch_assoc(select($settings_query, $values, 'i'));
    ?>
   <!-- navbar -->
   <nav id="nav-bar" class="navbar navbar-expand-lg bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
     <div class="container-fluid">
       <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><?php echo $settings_result['website_title']; ?></a>
       <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
       </button>
       <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <ul class="navbar-nav ms-auto me-5 mb-2 mb-lg-0">
           <li class="nav-item">
             <a class="nav-link me-2" href="index.php">Home</a>
           </li>
           <li class="nav-item">
             <a class="nav-link me-2 " href="events.php">Book Events</a>
           </li>
           <li class="nav-item">
             <a class="nav-link me-2 " href="services.php">Services</a>
           </li>
           <li class="nav-item">
             <a class="nav-link me-2 " href="contact.php">Contact</a>
           </li>
           <li class="nav-item">
             <a class="nav-link me-2 " href="about.php">About</a>
           </li>


         </ul>
         <div class="d-flex" role="search">

           <?php

            if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
              echo <<< data
                                        <div class="btn-group">
                            <button type="button" class="btn btn-light shadow-none border-0 dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                $_SESSION[uname]
                            </button>
                            <ul class="dropdown-menu dropdown-menu-lg-end">
                              <li><a href="profile.php" class="dropdown-item" type="button">Profile</a></li>
                              <li><a href="bookings.php" class="dropdown-item" type="button">Bookings</a></li>
                              <li><a href="logout.php" class="dropdown-item" type="button">Logout</a></li>
                            </ul>
                          </div>
              data;
            } else {
              echo <<< data
                          <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#loginmodal">
                          Login
                        </button>
                        <button type="button" class="btn btn-outline-dark shadow-none " data-bs-toggle="modal" data-bs-target="#registermodal">
                          Register
                        </button>
              data;
            }

            ?>

         </div>
       </div>
     </div>
   </nav>
   <!-- navbar -->

   <!-- loginmodal -->
   <div class="modal fade" id="loginmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
       <div class="modal-content ">
         <form id="login_form">
           <div class="modal-header">
             <h5 class="modal-title  fs-3 text-center">
               Welcome Back!!
             </h5>
             <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">

             <div class="mb-3">
               <label class="form-label">Email / Mobile: </label>
               <input type="text" name="email_mobile" class="form-control shadow-none" aria-describedby="emailHelp" required>
             </div>
             <div class="mb-4">
               <label class="form-label">Password: </label>
               <input type="password" name="password" class="form-control shadow-none" aria-describedby="emailHelp">
             </div>
             <div class="d-flex align-items-center justify-content-between">
               <button class="btn btn-dark shadow-none">Login</button>
               <a href="javascript: void(0)" class="text-secondary text-decoration-none">Forgot Password?</a>
             </div>
             <div class="text-center">
               <p class="mt-5">Do not have an account?<a href="" class="text-decoration-none text-dark fw-bold data-bs-toggle=" modal" data-bs-target="#registermodal"> Register</a></p>
             </div>
             
           </div>

         </form>
       </div>

     </div>
   </div>

   <!-- loginmodal -->

   <!-- registermodal -->
   <div class="modal fade" id="registermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg ">
       <div class="modal-content">
         <form id="user_register">
           <div class="modal-header">
             <h5 class="modal-title fs-2 ">
               Create your account
             </h5>
             <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">

             <span class="badge rounded-pill text-bg-light mb-3 text-wrap lh-base">
               * fields are necessary to fill.
             </span>
             <div class="container-fluid">
               <div class="row">
                 <div class="col-md-6 ps-0 mb-3">
                   <label class="form-label">Username: * </label>
                   <input name="username" type="text" id="username" class="form-control shadow-none" aria-describedby="emailHelp" required>
                 </div>
                 <div class="col-md-6 p-0 mb-3">

                   <label class="form-label">Email: * </label>
                   <input name="email" type="email" id="email" class="form-control shadow-none" aria-describedby="emailHelp" required>
                   <span id="emailError" class="text-danger"></span>
                 </div>
                 <div class="col-md-6 ps-0 mb-3">
                   <label class="form-label">Password: * </label>
                   <input name="password"id="password" type="password" class="form-control shadow-none" aria-describedby="passwordHelp" required autocomplete="on" >
                   <span id="passwordError" class="text-danger"></span>
                
                 </div>
                 <div class="col-md-6 p-0 mb-3">
                   <label class="form-label">Confirm Password: * </label>
                   <input name="confirm_pass" id= "confirmPass" type="password" class="form-control shadow-none" aria-describedby="emailHelp" autocomplete="on" required>
                   <span id="confirmPassError" class="text-danger"></span>
                 </div>
                 <div class="col-md-6 ps-0 mb-3">
                   <label class="form-label">Phone: * </label>
                   <input name="phone" id="phone" type="text" class="form-control shadow-none" aria-describedby="emailHelp" required>
                   <span id="phoneError" class="text-danger"></span>
                 </div>
                
                 <div class="col-md-12 p-0 mb-3">
                   <label class="form-label">Address: * </label>
                   <textarea name="address" id="address" class="form-control shadow-none" rows="3" required></textarea>
                   <span id="addressError" class="text-danger"></span>
                 </div>

               </div>
             </div>
             <div>
               <button type="submit" class="btn btn-dark shadow-none">Register</button>
             </div>

           </div>

         </form>
       </div>

     </div>
   </div>
   <!-- registermodal -->

 </body>


 


 </html>