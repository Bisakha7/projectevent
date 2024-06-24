<?php
require('../inc/essentials.php');
require('../inc/db_config.php');
adminLogin();



if (isset($_POST['add_feature'])) {

  $frm_data = filtration($_POST);
  $q = "INSERT INTO `features`(`name`) VALUES (?)";
  $values = [$frm_data['name']];
  $res = insert($q, $values, "s");
  echo $res;
}

if (isset($_POST['get_feature'])) {
  $res = selectAll('features');
  $i = 1;
  while ($row = mysqli_fetch_assoc($res)) {
    echo <<< data

    <tr>
    <td>$i</td>
    <td>$row[name]</td>
    <td>

    <button class="btn btn-danger btn-sm shadow-none" type="button" onclick="del_feature($row[id])">
                    <i class="bi bi-trash-fill"></i> 
                    </button>
    </td>

    </tr>
    
    data;
    $i++;
  }
}

if (isset($_POST['del_feature'])) {
  $frm_data = filtration($_POST);
  $values = [$frm_data['del_feature']];

  $check = select("SELECT * FROM `event_feature` WHERE `feature_id`=?",[$frm_data['del_feature']],'i');

  if(mysqli_num_rows($check)==0){
    $q = "DELETE FROM `features` where `id` =?";
    $res = delete($q, $values, 'i');
    echo $res;

  }
  else{
    echo 'event_added';
  }

 
}

if (isset($_POST['add_service'])) {
  $frm_data = filtration($_POST);
  $img_r = uploadImage($_FILES['image'], SERVICES_FOLDER);

  if ($img_r == 'inv_img') {
    echo $img_r;
  } else if ($img_r == 'inv_size') {
    echo $img_r;
  } else if ($img_r == 'upd_failed') {
    echo $img_r;
  } else {
    $q = "INSERT INTO `services`(`name`,`image`,`description`) VALUES (?,?,?)";
    $values = [ $frm_data['name'],$img_r,$frm_data['description']];
    $res = insert($q, $values, 'sss');
    echo $res;
  }
}



if (isset($_POST['get_service'])) {
  $res = selectAll('services');
  $i = 1;
  $path = SERVICES_IMG_PATH;
  while ($row = mysqli_fetch_assoc($res)) {
    echo <<< data

    <tr class="align-middle">
    <td>$i</td>
    <td><img src="$path$row[image]" alt="" width="100px"></td>
    <td>$row[image]</td>
    <td>$row[description]</td>
    <td>

    <button class="btn btn-danger btn-sm shadow-none" type="button" onclick="del_service($row[id])">
                    <i class="bi bi-trash-fill"></i> 
                    </button>
    </td>

    </tr>
    
    data;
    $i++;
  }
}

if (isset($_POST['del_service'])) {
  $frm_data = filtration($_POST);
  $values = [$frm_data['del_service']];

  $pre_query = "SELECT * FROM `services` WHERE `id`=?";
  $res = select($pre_query,$values,'i');
  $img = mysqli_fetch_assoc($res);

  if(deleteImage($img['image'],SERVICES_FOLDER)){
    $q = "DELETE FROM `services` where `id` =?";
  $res = delete($q, $values, 'i');
  echo $res;
  }
  else{
    echo 0;
  }
 
}