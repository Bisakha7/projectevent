<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upscale Events - Services</title>
  <style>
    .service_box {
      max-width: 300px;
      margin: auto;
    }

    .service_box:hover {
      border-top-color: brown !important;
      transform: scale(1.03);
      transition: all 0.5s;
    }
  </style>
</head>

<body>
  <!-- Header section -->
  <?php
  include("header.php");
  ?>

  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">Our Services</h2>
    <p class="text-center mt-3">
      Join Upscale Family and get chance to enhance your memorable moments and celebrations.
    </p>
  </div>

  <div class="container">
    <div class="row">
      <?php
      $res = selectAll('services');
      $path = SERVICES_IMG_PATH;
      while ($row = mysqli_fetch_assoc($res)) {
        echo <<< data
                <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class=" bg-white rounded shadow border-top border-4 p-4 d-flex flex-column gap-2 service_box" >
                  <img src="$path$row[image]" alt="" width="250px">
                  <h5 class="m-0  text-center">$row[name]</h5>
                  <p class="m-0">$row[description]</p>
              
                </div>
                
            </div>
        data;
      }
      ?>







    </div>


  </div>
</body>
<?php
include('footer.php');
?>

</html>