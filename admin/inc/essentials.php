<?php



//frontend

define('SITE_URL','http://127.0.0.1/projectevent/projectevent/');
define('ABOUT_IMG_PATH',SITE_URL.'images/about/');
define('GALLERY_IMG_PATH',SITE_URL.'images/gallery/');
define('SERVICES_IMG_PATH',SITE_URL.'images/services/');
define('EVENTS_IMG_PATH',SITE_URL.'images/events/');

//upload function in backend
define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/PROJECTEVENT/projectevent/images/'); // $_SERVER['DOCUMENT_ROOT'] gives absolute path: c://xampp/htdocs
define('ABOUT_FOLDER','about/');
define('GALLERY_FOLDER','gallery/');
define('SERVICES_FOLDER','services/');
define('EVENTS_FOLDER','events/');
define('USERS_FOLDER','users/');



function adminLogin()
{
  session_start();
  if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
    echo "
    <script>
    window.location.href= 'index.php';
    </script>
    ";
    exit;
  }
}
function redirect($url)
{
  echo "
  <script>
  window.location.href= '$url';
  </script>
  ";
  exit;
}
function alert($type, $msg)
{
  $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
  echo <<<alert
        <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
        <strong class="me-3">$msg</strong> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        alert;

        
}



function uploadUserPicture($image){
  $valid_mime = ['images/jpeg','images/png' ,'images/webp'];
  $img_mime = $image['type'];

  if(!in_array($img_mime,$valid_mime)){
    return 'inv_img';
  }
  else{
    $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
    $rname = 'IMG_' .random_int(11111,99999).".jpeg";

    $img_path = UPLOAD_IMAGE_PATH.USERS_FOLDER.$rname;

    if($ext == 'png' || $ext == 'PNG'){
      $img = imagecreatefrompng($image['tmp_name']);
      //create png image from file 
    }
    else if($ext == 'webp' || $ext == 'WEBP'){
      $img = imagecreatefromwebp($image['tmp_name']);
    }
    else{
      $img = imagecreatefromjpeg($image['tmp_name']);
    }
    if(imagejpeg($img,$img_path,75)){ //output image to browser or file
      return $rname;
    }
    else{
      return 'upd_failed';
    }
  }
}

function uploadImage($image,$folder){
  $valid_mime = ['image/jpg','image/png','image/webp','image/jpeg']; //mime = multipurpose internet mail extensions
  $img_mime = $image['type']; //accessses mime type of image uploaded
  
  if(!in_array($img_mime,$valid_mime)){
    return 'inv_img'; //invalid image format
  }
  else if(($image['size']/(1024*1024))>2){  //image converted to mb
    return 'inv_size';  
  }
  else{
    $ext = pathinfo($image['name'],PATHINFO_EXTENSION); //find out extensions
    $rname = 'IMG_'.random_int(11111,99999).".$ext"; //IMG_12456.jpg
    $img_path = UPLOAD_IMAGE_PATH.$folder.$rname; // tells the path where picture should be uploaded
    if(move_uploaded_file($image['tmp_name'],$img_path)){
      return $rname;

    }
    else{
      return "upd_failed";
    }


  }


}

function deleteImage($image,$folder){
  if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
    return true;
  }
  else{
    return false;
  }
}