<?php
require('../admin/inc/essentials.php');
require('../admin/inc/db_config.php');

if(isset($_GET['email_confirmation'])){
  $data = filtration($_GET);

  $query = select("SELECT * FROM `user_register` where `email`=? and `token`=? LIMIT 1",[$data['email'],$data['token']],'ss');

  if(mysqli_num_rows($query) == 1){
    $fetch = mysqli_fetch_assoc($query);

    if($fetch['is_verified'] == 1){
      echo "<script>alert('Email already is verified');</script>";
      
    }
    else{
      $update = update("UPDATE `user_register ` SET is_verified`=? WHERE `id`=?",[1,$fetch['id']],'ii');
      if($update){
        echo "<script>alert('Email verification successful');</script>";
      }
      else{
        echo "<script>alert('Failed');</script>";
      }
      redirect('index.php');
    }
    redirect('index.php');
  }
  else{
    echo "<script>alert('Invalid link');</script>";
    redirect('index.php');
  }

}