<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>
</head>

<body>
  <?php
  include('header.php');
  ?>

  <?php
   $contact_query = "SELECT * FROM `contact_details` WHERE `id`=?";
   $values = [1];
   $contact_result = mysqli_fetch_assoc(select($contact_query,$values,'i'));
  ?>

  <h2 class="mt-3 pt-4 text-center fw-bold ">Contact Us</h2>
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 p-4 mb-lg-0 mb-5">

        <iframe height="350px" class="w-100 rounded mb-4" src="<?php echo $contact_result['iframe'] ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <h5>Location</h5>
        <a href="<?php echo $contact_result['map'] ?>" class="d-inline-block text-decoration-none text-dark mb-2" target="_blank">
          <i class="bi bi-geo-alt-fill me-1"></i><?php echo $contact_result['location'] ?>
        </a>
        <h5 class="mt-4">Call Us:</h5>
        <a href="tel: +<?php echo $contact_result['ph1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill me-1"></i>+<?php echo $contact_result['ph1'] ?></a><br>
        <a href="tel: +<?php echo $contact_result['ph2'] ?>" class="d-inline-block text-decoration-none text-dark"><i class="bi bi-telephone-fill me-1"></i>+<?php echo $contact_result['ph2'] ?></a>

        <h5 class="mt-4">Email Us:</h5>
        <a href="maito: <?php echo $contact_result['email'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-envelope-fill me-1"></i><?php echo $contact_result['email'] ?></a><br>
        <a href="maito: lamichhanebisakha@gmail.com" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-envelope-fill me-1"></i>lamichhanebisakha@gmail.com</a>

      </div>
      <div class="col-lg-6 col-md-6 mt-3 shadow p-5">
        <form method = "POST">
          <h5 class="mb-5">Send Us Message!</h5>
          <div class="mb-3">
            <label class="form-label" style="font-weight: 500;">Name: </label>
            <input type="text" name="name" required class="form-control shadow-none" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-weight: 500;">Email: </label>
            <input type="email" name="email" required class="form-control shadow-none" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-weight: 500;">Subject: </label>
            <input type="text" name="subject" required class="form-control shadow-none" aria-describedby="emailHelp">
          </div>

          <div class="col-md-12 p-0 mb-3">
            <label class="form-label" style="font-weight: 500;">Message: </label>
            <textarea name="message" required class="form-control shadow-none" rows="3"></textarea>

          </div>

          <div>
            <button type="submit"name="contact_send" class="btn btn-dark shadow-none mt-5">Send</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>

  <?php
  if(isset($_POST['contact_send'])){
    $frm_data = filtration($_POST);

    $q = "INSERT INTO `user_query`( `name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
    $values = [$frm_data['name'],$frm_data['email'],$frm_data['subject'],$frm_data['message']];

    $res = insert($q,$values,"ssss");
    if($res == 1){
      alert('success','message sent');
    }
    else{
      alert('error','problem occured');
    }
  }
  ?>
  <?php
  include('footer.php');
  ?>
</body>

</html>