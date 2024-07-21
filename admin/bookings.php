<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upscale Events - Bookings</title>
  
  <!-- Include links.php for CSS -->
  <?php require('inc/links.php'); ?>
  
  <link rel="stylesheet" href="css/style.css">
  
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

  <style>
    .small-dropdown {
      width: 150px; /* Adjust width as needed */
    }
  </style>
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

        <!-- Date range filter -->
        <div class="mb-3">
          <select id="dateRangeFilter" class="form-select small-dropdown" onchange="filterBookingsByDate()">
            <option value="0">All Time</option>
            <option value="15">Last 15 Days</option>
            <option value="30">Last 30 Days</option>
            <option value="60">Last 60 Days</option>
            <option value="90">Last 3 Months</option>
            <option value="270">Last 9 Months</option>
            <option value="365">Last 1 Year</option>
          </select>
        </div>

        <!-- Table structure remains the same -->
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <div class="table-responsive-md" style="height:450px; overflow-y: scroll;">
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

  <!-- Modals -->

  <!-- Confirm Delete Modal -->
  <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel">Confirm Your Decision</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this booking?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancel</button>
          <button id="confirmDeleteButton" type="button" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Booking Details Modal -->
  <div class="modal fade" id="bookingDetailsModal" tabindex="-1" aria-labelledby="bookingDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bookingDetailsModalLabel">Booking Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Booking details will be populated here -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Include script.php for JavaScript -->
  <?php require_once('inc/script.php'); ?>

  <!-- DataTables JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

  <!-- Additional Scripts -->
  <script src="scripts/bookings.js"></script>
  <script src="scripts/table2excel.js"></script>
  <script src="scripts/html2pdf.bundle.min.js"></script>
  <script src="scripts/export.js"></script>

  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
</body>

</html>
