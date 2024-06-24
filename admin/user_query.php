<?php
require('inc/essentials.php');
require('inc/db_config.php');
adminLogin();

if(isset($_GET['seen'])){
  $frm_data = filtration($_GET);

  if($frm_data['seen'] == 'all'){
    $sql = "UPDATE `user_query` SET `seen`=?";
    $values = [1];
    if(update($sql,$values,'i')){
      alert('success','Marked all as read');
    }
  }
  else{
    $sql = "UPDATE `user_query` SET `seen`=? WHERE `id`=?";
    $values = [1,$frm_data['seen']];
    if(update($sql,$values,'ii')){
      alert('success','Marked as read');
    }
    
  }
}
if(isset($_GET['delete'])){
  $frm_data = filtration($_GET);

  if($frm_data['delete'] == 'all'){
    $sql = "TRUNCATE table `user_query`";
    
    if(mysqli_query($conn,$sql)){
      alert('success','All message Deleted');
    }
  }
  else{
    $sql = "DELETE FROM `user_query` WHERE `id`=?";
    $values = [$frm_data['delete']];
    if(delete($sql,$values,'i')){
      alert('success','Message Deleted');
    }
    
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upscale Events - User Query</title>
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
        <h3 class="mb-4">User Queries</h3>

        <div class="mb-3">
          <button class="btn btn-primary" onclick="exportToPDF()">Export to PDF</button>
          <button class="btn btn-success" onclick="exportToExcel()">Export to Excel</button>
        </div>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">

          <div class="text-end mb-4">
            <a href="?seen=all" class="btn btn-sm rounded-pill shadow-none btn-dark">Mark all read</a>
            <a href="?delete=all" class="btn btn-sm rounded-pill shadow-none btn-success">Delete all</a>
          </div>
          

            <div class="table-responsive-md" style="height:450px; overflow-y : scroll;">
              <table class="table table-hover table-bordered table-light" id="myTable" >
                <thead >
                  <tr class="table-secondary text-light align-middle">
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Message</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                 <?php
                 $sql = "select *  from `user_query` order by `id` desc";
                 $query = mysqli_query($conn,$sql);
                 $i = 1;

                 while($row = mysqli_fetch_assoc($query)){
                  $seen = '';
                  if($row['seen']!=1){
                    $seen = "<a href='?seen=$row[id]' class='btn btn-sm rounded-pill btn-success me-2'><i class='bi bi-check2-all'></i></a><br>";
                  }
                  $seen.= "<a href='?delete=$row[id]' class='btn btn-sm rounded-pill btn-danger mt-2'><i class='bi bi-trash3-fill'></i></a>";

                  echo <<< query
                  <tr>
                  <td>$i</td>
                  <td>$row[name]</td>
                  <td>$row[email]</td>
                  <td>$row[subject]</td>
                  <td>$row[message]</td>
                  <td>$row[date]</td>
                  <td>$seen</td>
                  </tr>

                  query;
                  $i++;


                 }
                 
                 ?>
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


</body>
<script src="scripts/table2excel.js"></script>
  <script src="scripts/html2pdf.bundle.min.js"></script>
  <script src="scripts/export.js"></script>

</html>