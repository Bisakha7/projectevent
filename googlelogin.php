<?php
require_once 'admin/inc/db_config.php';
require_once 'admin/inc/essentials.php';
require_once 'vendor/autoload.php';

$clientID = "1076733530435-r2t41irpduvvjlk6jj6oib4vo3p1rub3.apps.googleusercontent.com";
$clientSecret = "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";
$redirectUri = "http://localhost/projectevent/projectevent/google_callback.php";

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");