<?php
require('../inc/essentials.php');
require('../inc/db_config.php');
adminLogin();

if (isset($_POST['get_users'])) {
  $res = selectAll('user_register');

  $i = 1;
  $data = "";

  while ($row = mysqli_fetch_assoc($res)) {
    $del_btn = "<button type='button' onclick='delete_user($row[id])' class='btn btn-danger shadow-none'><i class='bi bi-trash'></i>";

    $verified = "<span class='badge bg-success '><i class='bi bi-x-lg'></i></span>";
    if($row['is_verified']){
      $verified = "<span class='badge bg-primary '><i class='bi bi-check-lg'></i></span>";
      $del_btn = '';
    }

    $status = "<button onclick='toggleStatus($row[id],0)' class='btn btn-sm btn-success shadow-none'>Active</button> ";

    if($row['status']==0){
      $status = "<button onclick='toggleStatus($row[id],1)' class='btn btn-sm btn-danger shadow-none'>Inactive</button> ";
    }

    $date = date("d-m-Y",strtotime($row['dateandtime']));
    $data .= "
       <tr>
       <td>$i</td>
       <td>$row[username]</td>
       <td>$row[email]</td>
       <td>$row[phone]</td>
       <td>$row[address]</td>
     
       <td>$status</td> 
       <td>$date</td> 
       <td>$del_btn</td> 
       </tr>
    ";
    $i++;
  }
  echo $data;
}

if (isset($_POST['toggleStatus'])) {
  $frm_data = filtration($_POST);

  $q = "UPDATE `user_register` SET `status`=? where `id` = ?";
  $values = [$frm_data['value'], $frm_data['toggleStatus']];
  if (update($q, $values, 'ii')) {
    echo 1;
  } else {
    echo 0;
  }
}

if(isset($_POST['delete_user'])){
  $frm_data = filtration($_POST);

  $res = delete("DELETE FROM `user_register` WHERE `id`=? AND `is_verified`=?",[$frm_data['user_id'],0],'ii');

  if($res){
    echo 1;
  }
  else{
    echo 0;
  }
}

