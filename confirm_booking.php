<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upscale Events - Confirm Booking</title>
 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/hmac-sha256.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/enc-base64.min.js"></script>
</head>
<body>
  <?php include('header.php'); ?>
  <?php
  

  if (!isset($_GET['id'])) {
      redirect('events.php');
  } else if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
      redirect('events.php');
  }

  $data = filtration($_GET);
  $event_res = select("SELECT * FROM `events` WHERE `id`=? AND  `status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');

  if (mysqli_num_rows($event_res) == 0) {
      redirect('events.php');
  }
  $event_data = mysqli_fetch_assoc($event_res);

  $_SESSION['event'] = [
      "id" => $event_data['id'],
      "name" => htmlentities($event_data['name']),
      "price" => $event_data['price'],
      
      "payment" => null,
      "available" => false,
  ];
 

  $user_res = select("SELECT * FROM `user_register` WHERE `id`=? LIMIT 1", [$_SESSION['uid']], "i");
  $user_data = mysqli_fetch_assoc($user_res);
  

$_SESSION['user'] = [
    "username" => $user_data['username'],
    "email" => $user_data['email'],
    "phone" => $user_data['phone'],
    "address" => $user_data['address'],
];?>
  <div class="container mt-5">
    <div class="row">
        <div class="col-12 my-5 mb-4 px-4">
            <h2 class="fw-bold">Confirm Your Event Booking</h2>
            <div style="font-size:14px">
                <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                <span class="text-secondary"> > </span>
                <a href="events.php" class="text-secondary text-decoration-none">EVENTS</a>
                <span class="text-secondary"> > </span>
                <a href="#" class="text-secondary text-decoration-none">CONFIRM</a>
            </div>
        </div>
        <div class="col-lg-7 col-md-12 px-4">
            <?php
            $event_thumbnail = EVENTS_IMG_PATH . "thumb.png";
            $thumbnail_q = mysqli_query($conn, "SELECT * FROM `event_image` WHERE `event_id` = '{$event_data['id']}' AND `thumbnail`='1'");

            if (mysqli_num_rows($thumbnail_q) > 0) {
                $thumbnail_res = mysqli_fetch_assoc($thumbnail_q);
                $event_thumbnail = EVENTS_IMG_PATH . $thumbnail_res['image'];
            }

            echo <<<HTML
            <div class="card p-3 shadow-sm rounded">
            <img src="$event_thumbnail" class="img-fluid rounded mb-3">
            <h5>{$event_data['name']}</h5>
            <h6>{$event_data['price']}</h6>
            </div>
HTML;
            ?>
        </div>
        <div class="col-lg-5 col-md-12 px-4">
            <div class="card-mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body px-3">
                <?php
    if (isset($_SESSION['transaction_msg'])) {
        echo $_SESSION['transaction_msg'];
        unset($_SESSION['transaction_msg']);
    }

    if (isset($_SESSION['validate_msg'])) {
        echo $_SESSION['validate_msg'];
        unset($_SESSION['validate_msg']);
    }
    ?>
    <h1 class="text-center"> Payment</h1>
    <div class="">
        <form class="row " action="payment-request.php" method="POST">
            <label class="mb-3 fw-bold">Product Details:</label>
            <div class="col-md-6 mb-3">
                <label for="inputAmount4" class="form-label">Price</label>
                <input type="Amount" class="form-control" id="inputAmount4" name="inputAmount4" value="<?php  echo $event_data['price'] ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputPurchasedOrderId4" class="form-label">Event Id</label>
                <input type="PurchasedOrderId" class="form-control" id="inputPurchasedOrderId4" value="<?php  echo $event_data['id'] ?>" name="inputPurchasedOrderId4" >
            </div>
            <div class="col-12 mb-3">
                <label for="inputPurchasedOrderName" class="form-label">Event Name</label>
                <input type="text" class="form-control" id="inputPurchasedOrderName" name="inputPurchasedOrderName" value="<?php  echo $event_data['name'] ?>" >
            </div>
            <div class="col-12 mb-3">
                <label for="inputPurchasedOrderDate" class="form-label">Date</label>
                <input type="date" class="form-control" id="inputPurchasedOrderDate" name="inputPurchasedOrderDate" >
            </div>
            <label class="mb-3 fw-bold">Customer Details:</label>
            <div class="col-12 mb-3">
                <label for="inputName" class="form-label">Customer Name</label>
                <input type="text" class="form-control" id="inputName" name="inputName" value="<?php  echo $user_data['username'] ?>" >
            </div>
            <div class="col-md-6">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="text" class="form-control" id="inputEmail" name="inputEmail" value="<?php  echo $user_data['email'] ?>" >
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputPhone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="inputPhone" name="inputPhone" value="<?php  echo $user_data['phone'] ?>" >
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="inputAddress" name="inputAddress" value="<?php  echo $user_data['address'] ?>" >
            </div>
            <div class="col-12">
                <button type="submit" name="submit" class="btn" style="background-color:purple;color:white;">Pay With Khalti</button>
            </div>
        </form>
    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>


</body>
</html>
