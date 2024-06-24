<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upscale Events - Events</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Bootstrap Select CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
</head>

<body>
  <?php include('header.php'); ?>

  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-12 col-md-12 mb-lg-4 mb-4">
        <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-light bg-white rounded shadow">
          <div class="container-fluid">
            <h4 class="mt-2 me-5">Filter</h4>
            <select name="select_event" required class="selectpicker show-tick" data-live-search="true" data-width="100%" data-size="4">
              <option value="">Select Category</option>
              <?php
              $q = selectAll('categories');
              while ($row = mysqli_fetch_assoc($q)) {
                echo "
               
                <option value='$row[name]' >$row[name]</option>
                
                ";
              }
              ?>
            </select>
            <div class="category_button">
              <button class="btn btn-primary">Search</button>
            </div>
          </div>
        </nav>
      </div>
    </div>

    <div class="row">
      <?php
      // Fetch events from the database
      $event_res = select("SELECT * FROM `events` WHERE `status`=? AND `removed`=?", [1, 0], 'ii');
      while ($event_data = mysqli_fetch_assoc($event_res)) {
        // Fetching features
        $feature_q = mysqli_query($conn, "SELECT f.name FROM `features` AS f INNER JOIN `event_feature` AS e ON f.id = e.feature_id WHERE e.event_id ='$event_data[id]'");
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
        $book_btn = "";
        $login = 0;
        if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
          $login = 1;
        }
        $book_btn = " <button onclick='checkLogin($login,$event_data[id])' class='btn btn-sm btn-success shadow-none '>Book Event</a>";
        // Printing card
        echo <<<data
                    <div class="col-lg-3 col-md-12 px-4 mt-4">
                        <div class="card-mb-4 border-0 shadow" style="max-width: 300px;">
                            <img src="$event_thumbnail" class="card-img-top" alt="">
                            <div class="card-body px-4 py-4">
                                <h5 >$event_data[name]</h5>
                                <div class="features mb-4">
                                    <h6 class="mb-1 mt-4 me-1 mb-1">Features</h6>
                                    $feature_data
                                </div>
                                <div class="features mb-4">
                                    <h6 class="mb-1 mt-4">Price</h6>
                                    Rs.$event_data[price]
                                </div>
                                <div class="category mb-4">
                                    <h6 class="mb-1 mt-4">Category</h6>
                                    <span class="badge rounded-pill text-bg-light text-wrap">$event_data[category]</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div>$book_btn</div>
                                    <a href="event_details.php?id=$event_data[id]" class="btn btn-sm custom-bg">More Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                data;
      }
      ?>
    </div>
  </div>

  <?php include('footer.php'); ?>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Bootstrap Select JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
  <!-- Initialize SelectPicker -->
  <script>
    $(document).ready(function() {
      $('.selectpicker').selectpicker();
    });
  </script>
</body>

</html>