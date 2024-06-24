<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upscale Events - Booking</title>

</head>
<body>
  <?php include('header.php'); 
  // Check if user is not logged in, redirect to index.php
  if(!(isset($_SESSION['login'])) || $_SESSION['login'] != true){
    header('Location: index.php');
    exit;
  }
  ?>
  
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 my-5 px-4">
        <h2 class="fw-bold">Your Bookings</h2>
        <div style="font-size:14px">
          <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
          <span class="text-secondary"> > </span>
          <a href="#" class="text-secondary text-decoration-none">Bookings</a>
        </div>
      </div>

      <?php
      $query = "SELECT * FROM `booking`";
      $query_run = mysqli_query($conn, $query);
      if(mysqli_num_rows($query_run) > 0){
        while($row = mysqli_fetch_assoc($query_run)){
          ?>
          <div class="col-4 mb-4">
            <div class="card" style="width: 100%;">
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['event_name']?></h5>
                <h6 class="card-subtitle mb-3 text-muted"><?php echo 'Rs '.$row['price']?></h6>
                <p class="card-text"><span class="fw-bold">Booking_id: </span><?php echo $row['id']?></p>

                <p class="card-text"><span class="fw-bold">Booking Date: </span><?php echo date('F j, Y', strtotime($row['booking_date']))?></p>
                <p class="card-text"><span class="fw-bold">Address: </span><?php echo $row['address']?></p>
                <?php
                if($row['status'] == 1){
                  $status = "<button class='btn btn-sm btn-success shadow-none'>Booked</button>";
                }
                else{
                  $status = "<button class='btn btn-sm btn-danger shadow-none'>Pending</button>";
                }
                ?>
                <div><?php echo $status;?></div>
              </div>
            </div>
          </div>
          <?php
        }
      }
      else {
        echo "No bookings found.";
      }
      ?>
    </div>
  </div>
  
  <?php include('footer.php'); ?>

  
</body>
</html>
