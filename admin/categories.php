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
  <title>Upscale Events - Categories</title>
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
        <h3 class="mb-4">Categories</h3>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <!-- categories section -->
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <h5 class="card-title m-0">Categories</h5>
                  <button type="button" class="btn btn-success btn-sm shadow-none" data-bs-toggle="modal" data-bs-target="#categories">
                    <i class="bi bi-plus"></i>
                  </button>
                </div>
              </div>
            </div>

            <div class="table-responsive-md" style="height:450px; overflow-y : scroll;">
              <table class="table table-hover table-bordered table-light" >
                <thead>
                  <tr class="table-secondary text-light">
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="category_data">
                  <tr>
                    <!-- Category data will be inserted here via JavaScript -->
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

 <!-- Category Modal -->
<div class="modal fade" id="categories" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="categories_form">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Add Category</h1>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Category name: </label>
            <input type="text" name="category_name" id="category_name_inp" class="form-control shadow-none" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn custom-bg">Add Category</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Confirm Your Decision</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this category?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="confirmDeleteButton" type="button" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>


  <?php
  require('inc/script.php');
  ?>
  <script src="scripts/categories.js"></script>
</body>
</html>
