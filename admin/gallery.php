<?php
require('inc/essentials.php');
adminLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upscale Events - Gallery</title>
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
        <h3 class="mb-4">Gallery</h3>



        <!--  Gallery Settings -->
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Gallery</h5>
              <button type="button" class="btn btn-success btn-sm shadow-none" data-bs-toggle="modal" data-bs-target="#gallerySettings">
                <i class="bi bi-plus"></i> 
              </button>
            </div>

            <div class="row" id="gallery_data">
              
            </div>



          </div>
        </div>

        <!-- Gallery Settings Modal -->
        <div class="modal fade" id="gallerySettings" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <form id="gallerySettings_form">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5">Add Images </h1>
                </div>
                <div class="modal-body">
                  

                  <div class=" mb-3">
                    <label class="form-label">Picture: </label>
                    <input type="file" name="gallery_picture" id="gallery_picture_inp" class="form-control shadow-none" aria-describedby="emailHelp" required accept=".jpg, .webp, .png, .jpeg">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" onclick=" gallery_picture.value =''" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn custom-bg">Add image</button>
                </div>
              </div>
            </form>

          </div>
        </div>



      </div>
    </div>
  </div>
  <?php
  require('inc/script.php');
  ?>
  <script src="scripts/gallery.js"></script>

</body>

</html>