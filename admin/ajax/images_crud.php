<?php
require('../inc/essentials.php');
require('../inc/db_config.php');
adminLogin();



if (isset($_POST['add_picture'])) {
  $img_r = uploadImage($_FILES['picture'], GALLERY_FOLDER);

  if ($img_r == 'inv_img') {
    echo $img_r;
  } else if ($img_r == 'inv_size') {
    echo $img_r;
  } else if ($img_r == 'upd_failed') {
    echo $img_r;
  } else {
    $q = "INSERT INTO `gallery`(`images`) VALUES (?)";
    $values = [ $img_r];
    $res = insert($q, $values, 's');
    echo $res;
  }
}

if (isset($_POST['get_picture'])) {
  $res = selectAll('gallery');

  while ($row = mysqli_fetch_assoc($res)) {
    $path = GALLERY_IMG_PATH;
    echo <<< data
     <div class="col-md-2 mb-3">
                <div class="card text-bg-dark">
                  <img src="$path$row[images]" class="card-img" >
                  <div class="card-img-overlay text-end">
                    <button class="btn btn-danger btn-sm shadow-none" type="button" onclick="del_picture($row[id])">
                    <i class="bi bi-trash-fill"></i> 
                    </button>
                  </div>


                </div>
              </div>
    data;
  }
}

if(isset($_POST['del_picture'])){
  $frm_data = filtration($_POST);
  $values = [$frm_data['del_picture']];

  $pre_query = "SELECT * FROM `gallery` WHERE `id`=?";
  $res = select($pre_query,$values,'i');
  $img = mysqli_fetch_assoc($res);

  if(deleteImage($img['images'],GALLERY_FOLDER)){
    $q = "DELETE FROM `gallery` where `id` =?";
    $res = delete($q, $values, 'i');
    echo $res;
  }
  else{
    echo 0;
  }
}
