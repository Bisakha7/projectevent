<?php
require('../inc/db_config.php');

if(isset($_POST['time_period'])) {
    $time_period = $_POST['time_period'];
    $where_clause = '';

    switch ($time_period) {
        case 'last_30_days':
            $where_clause = "WHERE booking_date BETWEEN (CURDATE() - INTERVAL 30 DAY) AND NOW()";
            break;
        case 'last_3_months':
            $where_clause = "WHERE booking_date BETWEEN (CURDATE() - INTERVAL 3 MONTH) AND NOW()";
            break;
        case 'last_6_months':
            $where_clause = "WHERE booking_date BETWEEN (CURDATE() - INTERVAL 6 MONTH) AND NOW()";
            break;
        case 'last_year':
            $where_clause = "WHERE booking_date BETWEEN (CURDATE() - INTERVAL 1 YEAR) AND NOW()";
            break;
        default:
            $where_clause = '';
    }

    $data = [];

    // Total user queries
    $query = "SELECT COUNT(*) AS total FROM `user_query` $where_clause";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $data['total_user_queries'] = $row['total'] ?? 'No data';

    // Total bookings
    $query = "SELECT COUNT(*) AS total FROM `booking` $where_clause";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $data['total_bookings'] = $row['total'] ?? 'No data';

    // Confirmed bookings
    $query = "SELECT COUNT(*) AS total FROM `booking` WHERE `status` = 1 $where_clause";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $data['confirmed_bookings'] = $row['total'] ?? 'No data';

    // Pending bookings
    $query = "SELECT COUNT(*) AS total FROM `booking` WHERE `status` = 0 $where_clause";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $data['pending_bookings'] = $row['total'] ?? 'No data';

    // Total money received
    $query = "SELECT SUM(price) AS total FROM `booking` $where_clause";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $data['total_money_received'] = $row['total'] ?? 'No data';

    echo json_encode($data);
} else {
    echo json_encode([
        'total_user_queries' => 'No data',
        'total_bookings' => 'No data',
        'confirmed_bookings' => 'No data',
        'pending_bookings' => 'No data',
        'total_money_received' => 'No data'
    ]);
}
?>
