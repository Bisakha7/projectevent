<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upscale Events - Event_Details</title>
</head>

<body >
  <?php include('header.php'); ?>

  <?php
  if(!isset($_GET['id'])){
    redirect('events.php');
  }

  $data = filtration($_GET);
  $event_res = select("SELECT * FROM `events` WHERE `id`=? AND  `status`=? AND `removed`=?", [$data['id'],1, 0], 'iii');

  if(mysqli_num_rows($event_res)==0){
    redirect('events.php');

  }
  $event_data = mysqli_fetch_assoc($event_res);


  ?>

  <div class="container mt-5">

    <div class="row">
      <div class=" col-12 my-5 mb-4 px-4">
        <h2 class="fw-bold"><?php
        echo $event_data['name'];?></h2>
        <div style="font-size:14px">
          <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
          <span class="text-secondary"> > </span>
          <a href="events.php" class="text-secondary text-decoration-none">EVENTS</a>
        </div>
      </div>


      <div class="col-lg-7 col-md-12 px-4 ">
      <div id="eventGallery" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">

  <?php
  $event_image = EVENTS_IMG_PATH . "thumb.png";
  $image_q = mysqli_query($conn, "SELECT * FROM `event_image` WHERE `event_id` = '$event_data[id]'");

  if (mysqli_num_rows($image_q) > 0) {
    $active_class= 'active';

   while( $image_res = mysqli_fetch_assoc($image_q)){

    echo "
    <div class='carousel-item $active_class'>
      <img src='".EVENTS_IMG_PATH.$image_res['image']."' class='d-block w-100' alt='...\'>
    </div>";
    $active_class = '';
  }}
  else{
    echo " <div class='carousel-item active'>
      <img src='$event_image' class='d-block w-100' alt='...\'>
    </div>";
  }

  ?>
   
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#eventGallery" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#eventGallery" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

      </div>

      <div class="col-lg-5 col-md-12 px-4" >

      <div class="card-mb-4 border-0 shadow-sm rounded-3">
        <div class="card-body px-3">
          <?php
          echo <<<price
          <h4 class="mt-5"> Rs.$event_data[price]</h4>
          price;


          $feature_q = mysqli_query($conn, "SELECT f.name from `features` as f INNER JOIN `event_feature` as e on f.id = e.feature_id where e.event_id ='$event_data[id]'");
        $feature_data = "";

        while ($feature_row = mysqli_fetch_assoc($feature_q)) {
          $feature_data .= "<span class='badge rounded-pill text-bg-light text-wrap'>$feature_row[name]</span> ";
        }


          echo <<< feature
           <div class="b-3">
                  <h6 class="mb-3 mt-4">Features</h6>
                  $feature_data
                  </div>

          feature;

          echo <<< category
           <div class="category mb-4">
                                              <h6 class="mb-3 mt-4">Category</h6>
                                              <span class="badge rounded-pill text-bg-light text-wrap">$event_data[category]</span>
                                            </div>
          category;
          $book_btn = "";
          $login = 0;     
          if(isset($_SESSION['login']) && $_SESSION['login']==true){
            $login = 1;
  
          }
          $book_btn = " <button onclick='checkLogin($login,$event_data[id])' class='w-100 btn  custom-bg shadow-nonemb-1 '>Book Event</a>";   
  
        
          echo <<<book
          $book_btn

          book;
          ?>
        </div>
        </div>

      </div>

      <div class="col-12 px-4 mt-4">
        <div class="mb-4">
          <h5>Description</h5>
          <p>
          <?php
            echo $event_data['description'];
           ?>
          </p>
          
        </div>

      </div>
    </div>

    
  </div>

  <?php include('footer.php'); ?>
</body>

</html>