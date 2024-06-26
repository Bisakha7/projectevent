<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upscale Events - Bookings</title>
  
  <!-- Include links.php for CSS -->
  <?php require('inc/links.php'); ?>
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light">
  <?php require('inc/header.php'); ?>

  <div class="container-fluid" id="main-content">
    <div class="row">
      <div class="col-lg-10 ms-auto p-3 overflow-hidden">
        <h3 class="mb-4">Bookings</h3>

        <!-- Buttons for PDF and Excel -->
        <div class="mb-3">
          <button class="btn btn-primary" onclick="exportToPDF()">Export to PDF</button>
          <button class="btn btn-success" onclick="exportToExcel()">Export to Excel</button>
        </div>

        <!-- Table structure remains the same -->
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-light" id="myTable">
                <!-- Table headers and body -->
                <thead>
                  <tr class="table-secondary text-light align-middle">
                    <th scope="col" style="width:1px">Booking ID</th>
                    <th scope="col" style="width:120px">Event Name</th>
                    <th scope="col" style="width:120px">Customer Name</th>
                    <th scope="col" style="width:50px">Booking Date</th>
                    <th scope="col" style="width:40px">Price</th>
                    <th scope="col" style="width:40px">Status</th>
                    <th scope="col" style="width:40px">Action</th>
                  </tr>
                </thead>
                <tbody id="bookings_data">
                  <!-- Table rows populated dynamically -->
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Include script.php for JavaScript -->
  <?php require('inc/script.php'); ?>

  <!-- Include bookings.js for additional JavaScript -->
  <script src="scripts/bookings.js"></script>
  <script src="scripts/table2excel.js"></script>
  <script src="scripts/html2pdf.bundle.min.js"></script>
  <script src="scripts/export.js"></script>

</body>

</html>
