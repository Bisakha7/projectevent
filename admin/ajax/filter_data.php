<?php
require('../inc/db_config.php');

$time_period = $_POST['time_period'];

$date_condition = "";
switch ($time_period) {
    case 'last_30_days':
        $date_condition = "WHERE booking_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
        break;
    case 'last_3_months':
        $date_condition = "WHERE booking_date >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)";
        break;
    case 'last_6_months':
        $date_condition = "WHERE booking_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)";
        break;
    case 'last_year':
        $date_condition = "WHERE booking_date >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
        break;
    default:
        $date_condition = "";
}

$user_queries = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_query $date_condition"));
$total_bookings = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM booking $date_condition"));
$confirmed_bookings = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM booking WHERE status = 1 $date_condition"));
$pending_bookings = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM booking WHERE status = 0 $date_condition"));
$total_money = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(price) AS total FROM booking $date_condition"))['total'];

$response = [
    'total_user_queries' => $user_queries,
    'total_bookings' => $total_bookings,
    'confirmed_bookings' => $confirmed_bookings,
    'pending_bookings' => $pending_bookings,
    'total_money_received' => number_format($total_money, 2)
];

echo json_encode($response);
