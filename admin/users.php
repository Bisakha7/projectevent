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
  <title>Upscale Events - Users</title>
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
        <h3 class="mb-4">Users</h3>
         <!-- Buttons for PDF and Excel -->
         <div class="mb-3">
          <button class="btn btn-primary" onclick="exportToPDF()">Export to PDF</button>
          <button class="btn btn-success" onclick="exportToExcel()">Export to Excel</button>
        </div>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">

            <!-- Events section -->
            

            <div class="table-responsive">
              <table class="table table-hover table-bordered table-light"   id="myTable">
                <thead>
                  <tr class="table-secondary text-light align-middle">
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <!-- <th scope="col">Verified</th> -->
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>               
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="users_data">
                </tbody>
              </table>
            </div>

          </div>
        </div>



      </div>
    </div>
  </div>

 



  



  <?php
  require('inc/script.php');
  ?>
  <script src="scripts/users.js"> </script>





</body>
<script src="scripts/table2excel.js"></script>
  <script src="scripts/html2pdf.bundle.min.js"></script>
  <script src="scripts/export.js"></script>


</html>