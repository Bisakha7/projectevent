<?php
require('inc/essentials.php');
require('inc/db_config.php');

adminLogin();



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <?php
  require('inc/links.php');
  ?>
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light">
  <?php
  require('inc/header.php');
  ?>

  <div class="container-fluid" id="main-content">
    <div class="row">
      <div class="col-lg-10 ms-auto p-3 overflow-hidden">
    <div class="d-flex justify-content-between">
      <h3 class="mb-5">Dashboard</h3>
      <div class="mb-3">
  
  <select class="form-select" id="time_period" onchange="filterData(this.value)">
    <option value="">Select Time Period:</option>
    <option value="last_30_days">Last 30 days</option>
    <option value="last_3_months">Last 3 months</option>
    <option value="last_6_months">Last 6 months</option>
    <option value="last_year">Last year</option>
  </select>
</div>

    </div>

    <div class="row mb-4">
      

      <div class="col-md-3 mb-4">
        <a href="user_query.php" class="text-decoration-none">
          <div class="card text-center p-3 " style=" border-left: 7px solid #283618">
          
            <p class="fw-bold">Total user queries</p>
          
          <?php
          $dash_users_query_query = "SELECT * FROM `user_query`";
          $dash_users_query_query_run = mysqli_query($conn, $dash_users_query_query);
          if($users_query_total = mysqli_num_rows($dash_users_query_query_run))
          {
              echo '<div class="mt-2">'.$users_query_total.'</div>';
          }
          else{
                echo '<div class="quantity">No data</div>';
          }
          ?>

          </div>
        </a>
      </div>

      <div class="col-md-3 mb-4">
        <a href="bookings.php" class="text-decoration-none">
          <div class="card text-center p-3 " style=" border-left: 7px solid #d90429">
          
            <p class="fw-bold">Total bookings</p>
          
          <?php
          $dash_users_booking = "SELECT * FROM `booking`";
          $dash_users_booking_run = mysqli_query($conn, $dash_users_booking);
          if($users_booking_total = mysqli_num_rows($dash_users_booking_run))
          {
            echo '<div class="mt-2">'.$users_booking_total.'</div>';
     }
         
          else{
                echo '<div class="quantity">No data</div>';
          }
          ?>

          </div>
        </a>
      </div>

      <div class="col-md-3 mb-4">
        <a href="bookings.php" class="text-decoration-none">
          <div class="card text-center p-3 " style=" border-left: 7px solid #7400b8">
          
            <p class="fw-bold">Confirmed bookings</p>
          
          <?php
          $dash_booking_confirm = "SELECT * FROM `booking` where `status` =1 ";
          $dash_booking_confirm_run = mysqli_query($conn, $dash_booking_confirm);
          if($confirm_booking_total = mysqli_num_rows($dash_booking_confirm_run))
          {
              echo '<div class="mt-2">'.$confirm_booking_total.'</div>';
          }
          else{
                echo '<div class="quantity">No data</div>';
          }
          ?>

          </div>
        </a>
      </div>
      <div class="col-md-3 mb-4">
        <a href="bookings.php" class="text-decoration-none">
          <div class="card text-center p-3 " style=" border-left: 7px solid #000000">
          
            <p class="fw-bold">Pending bookings</p>
          
          <?php
          $dash_booking_confirm = "SELECT * FROM `booking` where `status` =0 ";
          $dash_booking_confirm_run = mysqli_query($conn, $dash_booking_confirm);
          if($confirm_booking_total = mysqli_num_rows($dash_booking_confirm_run))
          {
              echo '<div class="mt-2">'.$confirm_booking_total.'</div>';
          }
          else{
                echo '<div class="quantity">No data</div>';
          }
          ?>

          </div>
        </a>
      </div>

  <div class="col-md-3 mb-4">
  <a href="bookings.php" class="text-decoration-none">
    <div class="card text-center p-3 " style="border-left: 7px solid #f72585">
    
      <p class="fw-bold">Total money received</p>
    
      <?php
      // Query to get the sum of all prices from the `booking` table
      $dash_booking_confirm = "SELECT SUM(price) AS total_sum FROM `booking`";
      $dash_booking_confirm_run = mysqli_query($conn, $dash_booking_confirm);

      if ($dash_booking_confirm_run) {
        // Fetch the total sum from the query result
        $row = mysqli_fetch_assoc($dash_booking_confirm_run);
        $total_sum = $row['total_sum'];

        // Display the total sum, formatted as currency
        if ($total_sum !== null) {
          echo '<div class="mt-2">Rs. ' . number_format($total_sum, 2) . '</div>';
        } else {
          echo '<div class="quantity">No data</div>';
        }
      } else {
        echo '<div class="quantity">No data</div>';
      }
      ?>

    </div>
  </a>
</div>

<div class="row mt-4">
<div class="col-md-3 mb-4">
        <a href="categories.php" class="text-decoration-none">
          <div class="card text-center p-3 " style=" border-left: 7px solid #246dec">
          
            <p class="fw-bold">Total Categories</p>
          
          <?php
          $dash_categories_query = "SELECT * FROM `categories`";
          $dash_categories_query_run = mysqli_query($conn, $dash_categories_query);
          if($categories_total = mysqli_num_rows($dash_categories_query_run))
          {
              echo '<div class="mt-2">'.$categories_total.'</div>';
          }
          else{
                echo '<div class="quantity">No data</div>';
          }
          ?>

          </div>
        </a>
      </div>
      <div class="col-md-3 mb-4">
        <a href="users.php" class="text-decoration-none">
          <div class="card text-center p-3 " style=" border-left: 7px solid #f5b74f">
          
            <p class="fw-bold">Total Users</p>
          
          <?php
          $dash_users_query = "SELECT * FROM `user_register`";
          $dash_users_query_run = mysqli_query($conn, $dash_users_query);
          if($users_total = mysqli_num_rows($dash_users_query_run))
          {
              echo '<div class="mt-2">'.$users_total.'</div>';
          }
          else{
                echo '<div class="quantity">No data</div>';
          }
          ?>

          </div>
        </a>
      </div>

      <div class="col-md-3 mb-4">
        <a href="events.php" class="text-decoration-none">
          <div class="card text-center p-3 " style=" border-left: 7px solid #6f1d1b">
          
            <p class="fw-bold">Total events</p>
          
          <?php
          $dash_events_query = "SELECT * FROM `events` where `removed` =0";
          $dash_events_query_run = mysqli_query($conn, $dash_events_query);
          if($events_total = mysqli_num_rows($dash_events_query_run))
          {
              echo '<div class="mt-2">'.$events_total.'</div>';
          }
          else{
                echo '<div class="quantity">No data</div>';
          }
          ?>

          </div>
        </a>
      </div>

      <div class="col-md-3 mb-4">
        <a href="features.php" class="text-decoration-none">
          <div class="card text-center p-3 " style=" border-left: 7px solid #007200">
          
            <p class="fw-bold">Total features</p>
          
          <?php
          $dash_features_query = "SELECT * FROM `features`";
          $dash_features_query_run = mysqli_query($conn, $dash_features_query);
          if($features_total = mysqli_num_rows($dash_features_query_run))
          {
              echo '<div class="mt-2">'.$features_total.'</div>';
          }
          else{
                echo '<div class="quantity">No data</div>';
          }
          ?>

          </div>
        </a>
      </div>
</div>

    </div>
      </div>

      
    </div>
  </div>
  <?php
  require('inc/script.php');
  ?>
</body>
<script>
  function filterData(timePeriod) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'ajax/filter_data.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      document.getElementById('total_user_queries').innerText = response.total_user_queries;
      document.getElementById('total_bookings').innerText = response.total_bookings;
      document.getElementById('confirmed_bookings').innerText = response.confirmed_bookings;
      document.getElementById('pending_bookings').innerText = response.pending_bookings;
      document.getElementById('total_money_received').innerText = 'Rs. ' + response.total_money_received;
    }
  };
  xhr.send('time_period=' + timePeriod);
}

document.getElementById('time_period').addEventListener('change', function() {
  filterData(this.value);
});

</script>

</html>