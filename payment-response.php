<?php
session_start();

// Check if payment data is available in session
if (isset($_SESSION['payment_data'])) {
    $payment_data = $_SESSION['payment_data'];

    // Extract data from the payment data array
    $amount = $payment_data['amount'];
    $purchase_order_id = $payment_data['purchase_order_id'];
    $purchase_order_name = $payment_data['purchase_order_name'];
    $purchase_order_date = $payment_data['purchase_order_date'];
    $name = $payment_data['name'];
    $email = $payment_data['email'];
    $phone = $payment_data['phone'];
    $address = $payment_data['address'];

    // Perform database insertion here
    require('admin/inc/db_config.php');

    try {
        // Prepare statement for inserting into 'booking' table
        $stmt = $conn->prepare("INSERT INTO booking (event_id, event_name, customer_name, booking_date, price, address) VALUES (?, ?, ?, ?, ?,?)");
        $stmt->bind_param("isssis", $purchase_order_id, $purchase_order_name, $name, $purchase_order_date, $amount,$address);

        // Execute the statement
        $stmt->execute();

        // Close statement
        $stmt->close();

        // Redirect to success page
        $_SESSION['transaction_msg'] = '<script>
            Swal.fire({
                icon: "success",
                title: "Transaction successful.",
                showConfirmButton: false,
                timer: 1500
            });
        </script>';
        header("Location: message.php");
        exit();
    } catch (mysqli_sql_exception $e) {
        // Handle database error
        $_SESSION['transaction_msg'] = '<script>
            Swal.fire({
                icon: "error",
                title: "Database error. Please try again later.",
                showConfirmButton: false,
                timer: 1500
            });
        </script>';
        header("Location: checkout.php");
        exit();
    }
} else {
    // Handle case where payment data is not available
    $_SESSION['transaction_msg'] = '<script>
        Swal.fire({
            icon: "error",
            title: "Payment data not found. Please try again.",
            showConfirmButton: false,
            timer: 1500
        });
    </script>';
    header("Location: checkout.php");
    exit();
}
?>
