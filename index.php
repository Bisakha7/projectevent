<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upscale Events - Home</title>
</head>

<body>
  <!-- Header section -->
  <?php
  include('header.php');
  ?>


  <!-- Main Content -->
  <div class="container-fluid">
    
    <div class="row px-3">
      <div class="col-md-6" style="padding-top:100px;">
        <h1 class="display-3 fw-bold">Elevate Your <span style="color:#FF8264;">Events</span> and <span style="color:#FF8264">Memories</span> With Us.</h1>
        <p class="fs-5">Looking for a great place to organize and manage your events? You are in the right place.</p>
        <?php
        if(isset($_SESSION['login']) && $_SESSION['login'] == true){
          echo <<< data
                            <a href="events.php" type="button" class="btn  mt-3 shadow-none custom-bg px-md-3" data-bs-toggle="modal" data-bs-target="#registermodal">
                            See Events
                          </a>
          data;
        }
        else{
          echo <<< data

                    <button type="button" class="btn  mt-3 shadow-none custom-bg px-md-3" data-bs-toggle="modal" data-bs-target="#registermodal">
                    Get Started
                  </button>
          data;
        }
        ?>
       
      </div>
      <div class="col-md-6 ">
        <img src="images/coverimage.jpg" width="100%" class="image-fluid" alt="">
      </div>
    </div>
  </div>
  <!-- Main content -->


  <!-- pictures-section -->
  <div class="container-fluid px-lg-4 mt-4 py-5" style="background-color:#eddea4;">
    <h2 class="text-center fs-1">We Manage all kinds of events</h2>
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">

        <?php
        $res = selectAll('gallery');

        while ($row = mysqli_fetch_assoc($res)) {
          $path = GALLERY_IMG_PATH;
          echo <<< data
                <div class="swiper-slide">
                <img src="$path$row[images]"/>
              </div>
              
         data;
        }
        ?>

      </div>
    </div>
  </div>
  <!-- pictures-section -->

  <!-- events-cards -->
  <h2 class="mt-5 pt-4 mb-4 text-center fw-bold">Events</h2>

  <div class="container">
    <div class="row">

      <?php
      $event_res = select("SELECT * FROM `events` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3 ", [1, 0], 'ii');

      while ($event_data = mysqli_fetch_assoc($event_res)) {
        // Fetching features
        $feature_q = mysqli_query($conn, "SELECT f.name from `features` as f INNER JOIN `event_feature` as e on f.id = e.feature_id where e.event_id ='$event_data[id]'");
        $feature_data = "";

        while ($feature_row = mysqli_fetch_assoc($feature_q)) {
          $feature_data .= "<span class='badge rounded-pill text-bg-light text-wrap me-1 mb-1'>$feature_row[name]</span> ";
        }

        // Thumbnail
        $event_thumbnail = EVENTS_IMG_PATH . "thumb.png";
        $thumbnail_q = mysqli_query($conn, "SELECT * FROM `event_image` WHERE `event_id` = '$event_data[id]' AND `thumbnail`='1'");

        if (mysqli_num_rows($thumbnail_q) > 0) {
          $thumbnail_res = mysqli_fetch_assoc($thumbnail_q);
          $event_thumbnail = EVENTS_IMG_PATH . $thumbnail_res['image'];
        }

        $book_btn="";

          $login = 0;     
          if(isset($_SESSION['login']) && $_SESSION['login']==true){
            $login = 1;

          }
          $book_btn = " <button onclick='checkLogin($login,$event_data[id])' class='btn btn-sm btn-success shadow-none '>Book Event</a>";   
        // Printing card
        echo <<<data
                                      <div class="card border-0 shadow" style="max-width: 350px; margin:auto;">
                                          <img src="$event_thumbnail" class="card-img-top" alt="">

                                            <div class="card-body">
                                              <h5>$event_data[name]</h5>

                                             

                                              <div class="category mb-4">
                                                <h6 class="mb-1 mt-4">Category</h6>
                                                <span class="badge rounded-pill text-bg-light  text-wrap ">
                                                  $event_data[category]
                                                </span>
                                              </div>

                                              <div class="price mb-4">
                                                  <h6 class="mb-1 mt-4">Price</h6>
                                                      Rs.$event_data[price]
                                                  </div>

                                             
                                              <div class="d-flex justify-content-between">
                                                  <div>$book_btn</div>
                                                  <a href="event_details.php?id=$event_data[id]" class="btn btn-sm custom-bg">View Detail</a>
                                              </div>
                                              
                                            </div>
                                          </div>
                                  data;
      }
      ?>
     



      <div class="col-lg-12 text-center mt-5">
        <a href="events.php" class="btn custom-bg  rounded-0 fw-bold shadow-none ">View More</a>
      </div>
    </div>
  </div>


  <!-- events-cards -->

  <!-- swiperjs -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <script>
    var swiper = new Swiper(".mySwiper", {
      effect: "coverflow",
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: "auto",
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: true,
      },
      loop: true,
      autoplay: {
        delay: 1500,
        disableOnInteraction: false,
      }

    });
  </script>
</body>
<?php
include('footer.php');
?>

</html>