<?php
require('../inc/essentials.php');
require('../inc/db_config.php');
adminLogin();

if (isset($_POST['get_bookings'])) {
  $res = selectAll('booking');

  $i = 1;

  $data = "";

  while ($row = mysqli_fetch_assoc($res)) {
    $del_btn = "<button type='button' onclick='delete_booking($row[id])' class='btn btn-danger shadow-none'><i class='bi bi-trash'></i></button>";
    $view_btn = "<button type='button' onclick='view_details($row[id])' class='btn btn-dark shadow-none'><i class='bi bi-eye'></i></button>";
    
    $status = "<button onclick='toggleStatus($row[id],1)' class='btn btn-sm btn-danger shadow-none'>Pending</button>";

    if($row['status']==1){
      $status = "<button onclick='toggleStatus($row[id],0)' class='btn btn-sm btn-success shadow-none'>Confirmed</button>";
    }

    $date = date("d-m-Y", strtotime($row['booking_date']));
    $data .= "
      <tr>
        <td>$i</td>
        <td>$row[event_name]</td>
        <td>$row[customer_name]</td>
        <td>$date</td>
        <td>$row[price]</td>
        <td>$status</td>
        <td>$del_btn $view_btn</td>
      </tr>
    ";
    $i++;
  }
  echo $data;
}

if (isset($_POST['toggleStatus'])) {
  $frm_data = filtration($_POST);

  $q = "UPDATE `booking` SET `status`=? WHERE `id`=?";
  $values = [$frm_data['value'], $frm_data['toggleStatus']];
  if (update($q, $values, 'ii')) {
    echo 1;
  } else {
    echo 0;
  }
}

if (isset($_POST['delete_booking'])) {
  $frm_data = filtration($_POST);

  $res = delete("DELETE FROM `booking` WHERE `id`=? AND `status`=?", [$frm_data['booking_id'], 0], 'ii');

  if ($res) {
    echo 1;
  } else {
    echo 0;
  }
}

if (isset($_POST['view_details'])) {
  $frm_data = filtration($_POST);
  $q = "SELECT * FROM `booking` WHERE `id`=?";
  $values = [$frm_data['view_details']];
  $res = select($q, $values, 'i');

  if ($res) {
    $data = mysqli_fetch_assoc($res);
    echo json_encode($data);
  } else {
    echo json_encode(['error' => 'Booking not found']);
  }
}
