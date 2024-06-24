<?php
require('../inc/essentials.php');
require('../inc/db_config.php');
adminLogin();





if (isset($_POST['add_event'])) {
  $feature = filtration(json_decode($_POST['feature']));
  $frm_data = filtration($_POST);
  $flag = 0;

  $q1 = "INSERT INTO `events`( `name`, `category`, `price`, `description`) VALUES (?,?,?,?)";
  $values = [$frm_data['name'], $frm_data['category'], $frm_data['price'], $frm_data['description']];

  if (insert($q1, $values, 'ssis')) {
    $flag = 1;
  }

  $event_id = mysqli_insert_id($conn);

  $q2 = "INSERT INTO `event_feature`( `event_id`, `feature_id`) VALUES (?,?)";

  if ($stmt = mysqli_prepare($conn, $q2)) {
    foreach ($feature as $f) {
      mysqli_stmt_bind_param($stmt, 'ii', $event_id, $f);
      mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
  } else {
    $flag = 0;
    die('Query cannot be executed');
  }

  if ($flag) {
    echo 1;
  } else {
    echo 0;
  }
}

if (isset($_POST['get_event'])) {
  $res = select("SELECT * FROM `events` WHERE `removed`=?",[0],'i');

  $i = 1;

  $data = "";

  while ($row = mysqli_fetch_assoc($res)) {

    if ($row['status'] == 1) {
      $status = "
      <button onclick='toggleStatus($row[id],0)' class='btn btn-sm btn-success shadow-none'>Active</button> ";
    } else {
      $status = "
      <button onclick='toggleStatus($row[id],1)' class='btn btn-sm btn-danger shadow-none'>Inactive</button> ";
    }
    $data .= "
        <tr class='align-middle'>
        <td>$i</td>
        <td>$row[name]</td>
        <td>$row[category]</td>
        <td>$row[price]</td>
        <td>$status</td>
        <td>
                <button type='button' onclick='edit_event($row[id])' class='btn btn-dark btn-sm shadow-none' data-bs-toggle='modal' data-bs-target='#edit_events'>
                            <i class='bi bi-pen'></i>
                          </button>
                           <button type='button' onclick=\"event_images($row[id],'$row[name]')\" class='btn btn-success btn-sm shadow-none' data-bs-toggle='modal' data-bs-target='#events_images'>
                            <i class='bi bi-card-image'></i>
                          </button>
                           <button type='button' onclick='del_event($row[id])' class='btn btn-danger btn-sm shadow-none'>
                            <i class='bi bi-trash'></i>
                          </button>
                
                </td>
                <tr>

    ";
    $i++;
  }
  echo $data;
}

if (isset($_POST['get_edit_event'])) {
  $frm_data = filtration($_POST);
  $res1 = select("SELECT * FROM `events` where `id`=?", [$frm_data['get_edit_event']], 'i');
  $res2 = select("SELECT * FROM `event_feature` where `event_id`=?", [$frm_data['get_edit_event']], 'i');

  $event_data = mysqli_fetch_assoc($res1);
  $feature = [];

  if (mysqli_num_rows($res2) > 0) {
    while ($row = mysqli_fetch_assoc($res2)) {
      array_push($feature, $row['feature_id']);
    }

    $data = ["event_data" => $event_data, "feature" => $feature];

    $data = json_encode($data);


    echo $data;
  }
}

if (isset($_POST['edit_event'])) {
  $feature = filtration(json_decode($_POST['feature']));
  $frm_data = filtration($_POST);
  $flag = 0;

  $q1 = "UPDATE `events` SET `name`=?,`category`=?,`price`=?,`description`=?  WHERE `id`=?";
  $values = [$frm_data['name'], $frm_data['category'], $frm_data['price'], $frm_data['description'], $frm_data['event_id']];

  if (update($q1, $values, "ssisi")) {
    $flag = 1;
  }
  $delete_feature = delete("DELETE FROM `event_feature` WHERE `event_id`=? ", [$frm_data['event_id']], 'i');


  if (!$delete_feature) {
    $flag = 0;
  }


  $q2 = "INSERT INTO `event_feature`( `event_id`, `feature_id`) VALUES (?,?)";

  if ($stmt = mysqli_prepare($conn, $q2)) {
    foreach ($feature as $f) {
      mysqli_stmt_bind_param($stmt, 'ii', $frm_data['event_id'], $f);
      mysqli_stmt_execute($stmt);
    }
    $flag = 1;
    mysqli_stmt_close($stmt);
  } else {
    $flag = 0;
    die('Query cannot be executed');
  }

  if ($flag) {
    echo 1;
  } else {
    echo 0;
  }
}

if (isset($_POST['toggleStatus'])) {
  $frm_data = filtration($_POST);

  $q = "UPDATE `events` SET `status`=? where `id` = ?";
  $values = [$frm_data['value'], $frm_data['toggleStatus']];
  if (update($q, $values, 'ii')) {
    echo 1;
  } else {
    echo 0;
  }
}

if (isset($_POST['add_image'])) {
  $frm_data = filtration($_POST);
  $img_r = uploadImage($_FILES['image'], EVENTS_FOLDER);

  if ($img_r == 'inv_img') {
    echo $img_r;
  } else if ($img_r == 'inv_size') {
    echo $img_r;
  } else if ($img_r == 'upd_failed') {
    echo $img_r;
  } else {
    $q = "INSERT INTO `event_image`( `event_id`, `image`) VALUES (?,?)";
    $values = [$frm_data['event_id'],$img_r];
    $res = insert($q, $values, 'is');
    echo $res;
  }
}


if (isset($_POST['get_event_image'])) {
  $frm_data = filtration($_POST);
  $res = select("SELECT * FROM `event_image` WHERE `event_id`=?",[$frm_data['get_event_image']],'i');

  $path = EVENTS_IMG_PATH;


  while($row = mysqli_fetch_assoc($res)){

    if($row['thumbnail']==1){
      $thumbnail_btn = "<i class='bi bi-check-lg bg-primary px-2 py-1 fs-5 rounded'></i>";
    }
    else{
      $thumbnail_btn = "<button onclick='thumbnail_image($row[id],$row[event_id])' class='btn btn-success shadow-none'><i class='bi bi-check-lg'></i></button>";
    }
    echo <<< data
    <tr class='align-middle'>
    <td><img src='$path$row[image]' class='img-fluid'></td>
    <td>$thumbnail_btn</td>
    <td>
    <button onclick='del_image($row[id],$row[event_id])' class='btn btn-danger shadow-none'><i class='bi bi-trash'></i></button>
    
    
    </td>
    </tr>
    data;
  }
}

if(isset($_POST['del_image'])){
  $frm_data = filtration($_POST);
  $values = [$frm_data['image_id'],$frm_data['event_id']];

  $pre_query = "SELECT * FROM `event_image` WHERE `id`=? AND `event_id`=?";
  $res = select($pre_query,$values,'ii');
  $img = mysqli_fetch_assoc($res);

  if(deleteImage($img['image'],EVENTS_FOLDER)){
    $q = "DELETE FROM `event_image` where `id` =? AND `event_id`=?";
    $res = delete($q, $values, 'ii');
    echo $res;
  }
  else{
    echo 0;
  }
}

if(isset($_POST['thumbnail_image'])){
  $frm_data = filtration($_POST);

  $pre = "UPDATE `event_image` SET `thumbnail`=? WHERE `event_id`=?";
  $pre_run = [0,$frm_data['event_id']];
  $pre_res = update($pre,$pre_run,'ii');


  
  $p = "UPDATE `event_image` SET `thumbnail`=? WHERE `id`=? AND `event_id`=?";
  $p_r = [1,$frm_data['image_id'],$frm_data['event_id']];
  $p_res = update($p,$p_r,'iii');

  echo  $p_res;



  
}
if(isset($_POST['del_event'])){
  $frm_data = filtration($_POST);

  $res1 = select("SELECT * FROM `event_image` WHERE `event_id`=?",[$frm_data['event_id']],'i');

  while($row = mysqli_fetch_assoc($res1)){
    deleteImage($row['image'],EVENTS_FOLDER);
  }

  $res2 = delete("DELETE FROM `event_image` WHERE `event_id`=?",
  [ $frm_data['event_id']],'i');
  $res3 = delete("DELETE FROM `event_feature` WHERE `event_id`=?",
  [ $frm_data['event_id']],'i');
  $res4 = update("UPDATE `events` SET `removed`=? WHERE `id`=?",[1,$frm_data['event_id']],'ii');


  if($res2 || $res3 || $res4){
    echo 1;
  }
  else{
    echo 0;
  }




  
}
