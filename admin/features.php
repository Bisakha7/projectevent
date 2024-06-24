<?php
require('inc/essentials.php');
require('inc/db_config.php');
adminLogin();

if (isset($_GET['seen'])) {
  $frm_data = filtration($_GET);

  if ($frm_data['seen'] == 'all') {
    $sql = "UPDATE `user_query` SET `seen`=?";
    $values = [1];
    if (update($sql, $values, 'i')) {
      alert('success', 'Marked all as read');
    }
  } else {
    $sql = "UPDATE `user_query` SET `seen`=? WHERE `id`=?";
    $values = [1, $frm_data['seen']];
    if (update($sql, $values, 'ii')) {
      alert('success', 'Marked as read');
    }
  }
}
if (isset($_GET['delete'])) {
  $frm_data = filtration($_GET);

  if ($frm_data['delete'] == 'all') {
    $sql = "TRUNCATE table `user_query`";

    if (mysqli_query($conn, $sql)) {
      alert('success', 'All message Deleted');
    }
  } else {
    $sql = "DELETE FROM `user_query` WHERE `id`=?";
    $values = [$frm_data['delete']];
    if (delete($sql, $values, 'i')) {
      alert('success', 'Message Deleted');
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upscale Events - Features</title>
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
        <h3 class="mb-4">Features</h3>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">

            <!-- features section -->
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <h5 class="card-title m-0">Features</h5>
                  <button type="button" class="btn btn-success btn-sm shadow-none" data-bs-toggle="modal" data-bs-target="#features">
                    <i class="bi bi-plus"></i>
                  </button>
                </div>
              </div>
            </div>

            <div class="table-responsive-md" style="height:450px; overflow-y : scroll;">
              <table class="table table-hover table-bordered table-light">
                <thead >
                  <tr class="table-secondary text-light align-middle">
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="features_data">
                </tbody>
              </table>
            </div>

          </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">

            <!-- services section -->
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <h5 class="card-title m-0">Services</h5>
                  <button type="button" class="btn btn-success btn-sm shadow-none" data-bs-toggle="modal" data-bs-target="#services">
                    <i class="bi bi-plus"></i>
                  </button>
                </div>
              </div>
            </div>

            <div class="table-responsive-md" style="height:450px; overflow-y : scroll;">
              <table class="table table-hover table-bordered table-light">
                <thead class="sticky-top">
                  <tr class="table-secondary text-light align-middle" id="myTable">
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="services_data">
                </tbody>
              </table>
            </div>

          </div>
        </div>


      </div>
    </div>
  </div>

  <!-- Features Modal -->
  <div class="modal fade" id="features" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="features_form">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Add Features </h1>
          </div>
          <div class="modal-body">


            <div class=" mb-3">
              <label class="form-label">Feature name: </label>
              <input type="text" name="feature_name" id="feature_name_inp" class="form-control shadow-none" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn custom-bg">Add Feature</button>
          </div>
        </div>
      </form>

    </div>
  </div>

  <!-- Services Modal -->
  <div class="modal fade" id="services" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="services_form">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Add Services </h1>
          </div>
          <div class="modal-body">
            <div class=" mb-3">
              <label class="form-label">Service name: </label>
              <input type="text" name="service_name" id="service_name_inp" class="form-control shadow-none" required>
            </div>

            <div class=" mb-3">
              <label class="form-label">Image: </label>
              <input type="file" name="service_image" id="service_image_inp" class="form-control shadow-none" aria-describedby="emailHelp" required accept=".jpg, .webp, .png, .jpeg">
            </div>

            <div class="mb-3">
              <label class="form-label">Description: * </label>
              <textarea name="service_description" class="form-control shadow-none" rows="3" ></textarea>

            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn custom-bg">Add Service</button>
          </div>
        </div>
      </form>

    </div>
  </div>
  <?php
  require('inc/script.php');
  ?>
  <script src="scripts/features.js"></script>
  
</body>


</html>