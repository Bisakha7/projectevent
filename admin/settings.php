<?php
require('inc/essentials.php');
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
        <h3 class="mb-4">Settings</h3>

        <!-- Settings -->
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">General Settings</h5>
              <button type="button" class="btn btn-primary btn-sm shadow-none" data-bs-toggle="modal" data-bs-target="#generalSettings">
                <i class="bi bi-pen-fill me-2"></i>Edit
              </button>
            </div>
            <h6 class="card-subtitle mb-1  fw-bold">Website Title</h6>
            <p class="card-text" id="website_title"></p>
            <h6 class="card-subtitle mb-1  fw-bold">Information</h6>
            <p class="card-text" id="website_info"></p>
          </div>
        </div>

        <!-- Settings Modal -->
        <div class="modal fade" id="generalSettings" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <form id="generalSettings_form">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5">General Settings</h1>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label">Website Title: </label>
                    <input type="text" name="website_title" id="website_title_inp" class="form-control shadow-none" aria-describedby="emailHelp" required>
                  </div>

                  <div class=" mb-3">
                    <label class="form-label">Information </label>
                    <textarea name="website_info" id="website_info_inp" class="form-control shadow-none" rows="6" required></textarea>

                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" onclick="website_title.value=general_data.website_title, website_info.value = general_data.website_info" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn custom-bg">Save Changes</button>
                </div>
              </div>
            </form>

          </div>
        </div>




        <!-- contact settings section -->
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Contact Settings</h5>
              <button type="button" class="btn btn-primary btn-sm shadow-none" data-bs-toggle="modal" data-bs-target="#contactSettings">
                <i class="bi bi-pen-fill me-2"></i>Edit
              </button>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-4">
                  <h6 class="card-subtitle mb-1  fw-bold">Location</h6>
                  <p class="card-text" id="location"></p>
                </div>
                <div class="mb-4">
                  <h6 class="card-subtitle mb-1  fw-bold">Map</h6>
                  <p class="card-text" id="map"></p>
                </div>
                <div class="mb-4">
                  <h6 class="card-subtitle mb-1  fw-bold">Numbers</h6>
                  <p class="card-text">
                    <i class="bi bi-telephone-fill me-1"> </i>
                    <span id="ph1"></span>
                  </p>
                  <p class="card-text">
                    <i class="bi bi-telephone-fill me-1"> </i>
                    <span id="ph2"></span>
                  </p>
                </div>

                <div class="mb-4">
                  <h6 class="card-subtitle mb-1  fw-bold">Email</h6>
                  <p class="card-text" id="email"></p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-4">
                  <h6 class="card-subtitle mb-1  fw-bold">Social Media Links</h6>
                  <p class="card-text">
                    <i class="bi bi-instagram me-1"></i>
                    <span id="insta"></span>
                  </p>
                  <p class="card-text">
                    <i class="bi bi-facebook me-1"></i>
                    <span id="fb"></span>
                  </p>
                  <p class="card-text">
                    <i class="bi bi-twitter me-1"></i>
                    <span id="twitter"></span>
                  </p>
                </div>


                <div class="mb-4">
                  <h6 class="card-subtitle mb-1  fw-bold">iFrame</h6>
                  <iframe id="iframe" class="border p-2 w-100" loading="lazy"></iframe>
                </div>

              </div>
            </div>





          </div>
        </div>

        


        <!-- contact model -->
        <div class="modal fade" id="contactSettings" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <form id="contactSettings_form">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5">Contact Settings</h1>
                </div>
                <div class="modal-body">

                  <div class="container-fluid p-0">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label">Location </label>
                          <input type="text" name="location" id="location_inp" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Map Link </label>
                          <input type="text" name="map" id="map_inp" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Phone Numbers </label>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-telephone-fill me-1"></i></span>
                            <input name="ph1" id="ph1_inp" type="number" class="form-control shadow-none" required>
                          </div>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-telephone-fill me-1"></i></span>
                            <input name="ph2" id="ph2_inp" type="number" class="form-control shadow-none" required>
                          </div>
                        </div>

                        <div class="mb-3">
                          <label class="form-label">Email </label>
                          <div class="input-group mb-3">
                            <span class="input-group-text">@</span>
                            <input name="email" id="email_inp" type="email" class="form-control shadow-none" required>
                          </div>
                        </div>

                      </div>

                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label">Social Media Links </label>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-instagram me-1"></i></span>
                            <input name="insta" id="insta_inp" type="text" class="form-control shadow-none" required>
                          </div>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-facebook me-1"></i></span>
                            <input name="fb" id="fb_inp" type="text" class="form-control shadow-none" required>
                          </div>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-twitter me-1"></i></span>
                            <input name="twitter" id="twitter_inp" type="text" class="form-control shadow-none" required>
                          </div>

                          <div class="mb-3">
                            <label class="form-label">iFrame</label>
                            <input type="text" name="iframe" id="iframe_inp" class="form-control shadow-none" required>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>



                </div>
                <div class="modal-footer">
                  <button type="button" onclick="contact_inp(contact_data)" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn custom-bg">Save Changes</button>
                </div>
              </div>
            </form>

          </div>
        </div>

       

        <!-- Team Settings Modal -->
        <div class="modal fade" id="teamSettings" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <form id="teamSettings_form">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5">Add Team </h1>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label">Name: </label>
                    <input type="text" name="team_name" id="team_name_inp" class="form-control shadow-none" aria-describedby="emailHelp" required>
                  </div>

                  <div class=" mb-3">
                    <label class="form-label">Picture: </label>
                    <input type="file" name="team_picture" id="team_picture_inp" class="form-control shadow-none" aria-describedby="emailHelp" required accept=".jpg, .webp, .png, .jpeg">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" onclick="team_name.value='' , team_picture.value =''" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn custom-bg">Save Changes</button>
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
  <script src="scripts/settings.js"></script>

</body>

</html>