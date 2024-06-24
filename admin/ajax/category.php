<?php
require('../inc/essentials.php');
require('../inc/db_config.php');
adminLogin();



if (isset($_POST['add_category'])) {

  $frm_data = filtration($_POST);
  $q = "INSERT INTO `categories`(`name`) VALUES (?)";
  $values = [$frm_data['name']];
  $res = insert($q, $values, "s");
  echo $res;
}

if (isset($_POST['get_category'])) {
  $res = selectAll('categories');
  $i = 1;
  while ($row = mysqli_fetch_assoc($res)) {
    echo <<< data

    <tr>
    <td>$i</td>
    <td>$row[name]</td>
    <td>

    <button class="btn btn-danger btn-sm shadow-none" type="button" onclick="del_category($row[id])">
                    <i class="bi bi-trash-fill"></i> 
                    </button>
    </td>

    </tr>
    
    data;
    $i++;
  }
}

if (isset($_POST['del_category'])) {
  $frm_data = filtration($_POST);
  $values = [$frm_data['del_category']];
  $q = "DELETE FROM `categories` where `id` =?";
  $res = delete($q, $values, 'i');
  echo $res;
}
