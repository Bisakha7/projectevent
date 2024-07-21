<?php
require_once 'googlelogin.php';
require_once 'admin/inc/db_config.php';
require_once 'admin/inc/essentials.php';

if (isset($_GET['code'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        if (isset($token['error'])) {
            throw new Exception($token['error_description']);
        }
        $client->setAccessToken($token['access_token']);
    // Get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    
    $userInfo = [
        'email' => $google_account_info['email'],
        'firstName' => $google_account_info['givenName'],
        'lastName' => $google_account_info['familyName'],
        'token' => $google_account_info['id'],
    ];

    // Check if the user already exists in the database
    $sql = "SELECT * FROM user_register WHERE email = ?";
    $result = select($sql, [$userInfo['email']], 's');

    if ($result && mysqli_num_rows($result) > 0) {
        $userinfo = mysqli_fetch_assoc($result);
    } else {
        // Insert the new user into the database
        $sql = "INSERT INTO user_register (username, email, token, is_verified, status) VALUES (?, ?, ?, 1, 1)";
        $values = [$userInfo['firstName'] . ' ' . $userInfo['lastName'], $userInfo['email'], $userInfo['token']];
        
        if (insert($sql, $values, 'sss')) {
            $sql = "SELECT * FROM user_register WHERE email = ?";
            $result = select($sql, [$userInfo['email']], 's');
            if ($result && mysqli_num_rows($result) > 0) {
                $userinfo = mysqli_fetch_assoc($result);
            } else {
                echo "Failed to retrieve user info after insertion.";
                die();
            }
        } else {
            echo "User is not created";
            die();
        }
    }

    echo "<script>
    googleLogin('{$userinfo['email']}');
</script>";
    exit();
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
    exit;
}
} else {
    echo "Authorization code not received";
}