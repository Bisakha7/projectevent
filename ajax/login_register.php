<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');

if(isset($_POST['register'])) {
    $data = filtration($_POST);
    
    if ($data['password'] != $data['confirm_pass']) {
        echo 'pass_mismatch';
        exit;
    }

    $user_exists = select("SELECT * FROM user_register WHERE email = ? OR phone = ? LIMIT 1", [$data['email'], $data['phone']], "ss");

    if (mysqli_num_rows($user_exists) != 0) {
        $user_exists_fetch = mysqli_fetch_assoc($user_exists);
        echo ($user_exists_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
        exit;
    }

    $token = bin2hex(random_bytes(16));
    $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
    
    $q = "INSERT INTO user_register(username, email, password, phone, address, token, is_verified, status) VALUES (?,?,?,?,?,?,1,1)";
    $values = [$data['username'], $data['email'], $hashed_password, $data['phone'], $data['address'], $token];

    if (insert($q, $values, "ssssss")) {
        echo 1;
    } else {
        echo 'ins_failed';
    }
}

if(isset($_POST['login'])){
    $data = filtration($_POST);

    $user_exists = select("SELECT * FROM user_register WHERE email=? OR phone=? LIMIT 1", [$data['email_mobile'], $data['email_mobile']], "ss");

    if(mysqli_num_rows($user_exists) == 0){
       echo 'inv_email_mobile';
    } else {
        $user_fetch = mysqli_fetch_assoc($user_exists);
        if($user_fetch['is_verified'] == 0){
            echo 'not_verified';
        } else if($user_fetch['status'] == 0){
            echo 'inactive';
        } else {
            if(password_verify($data['password'], $user_fetch['password'])){
                echo 'inv_pass';
 
            } else {
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['uid'] = $user_fetch['id'];
                $_SESSION['uname'] = $user_fetch['username'];
                $_SESSION['phone'] = $user_fetch['phone'];
                echo 1;
            }
        }
    }
}
