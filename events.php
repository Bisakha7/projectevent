<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upscale Events - Events</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <style>
        .content-wrapper {
            min-height: calc(100vh - 200px); /* Adjust based on your header and footer height */
            display: flex;
            flex-direction: column;
        }
        #eventsContainer {
            flex-grow: 1;
            display: flex;
            flex-wrap: wrap;
        }
        #noEventsMessage {
            display: none;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        #noEventsMessage img {
            max-width: 200px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>

    <div class="content-wrapper">
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-12 col-md-12 mb-lg-4 mb-4">
                    <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-light bg-white rounded shadow">
                        <div class="container-fluid">
                            <h4 class="mt-2 me-5">Search</h4>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="search-icon">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                                <input type="text" id="categorySearch" class="form-control" placeholder="Search for Events" aria-label="Search" aria-describedby="search-icon">
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

            <div id="eventsContainer">
                <div id="noEventsMessage">
                    <div >
                        <img src="images/nofound.jpg" alt="No events" class="img-fluid mt-5">
                        <h3 class="mt-1">No events available</h3>
                        <p class="mt-1">We couldn't find any events matching your search .</p>
                    </div>
                </div>
                <?php
                // Initially display all events
                $event_res = select("SELECT * FROM `events` WHERE `status`=? AND `removed`=?", [1, 0], 'ii');
                while ($event_data = mysqli_fetch_assoc($event_res)) {
                    displayEvent($event_data);
                }

                function displayEvent($event_data)
                {
                    global $conn;
                    // Fetching features
                    $feature_q = mysqli_query($conn, "SELECT f.name FROM `features` AS f INNER JOIN `event_feature` AS e ON f.id = e.feature_id WHERE e.event_id ='$event_data[id]'");
                    $feature_data = "";
                    while ($feature_row = mysqli_fetch_assoc($feature_q)) {
                        $feature_data .= "<span class='badge rounded-pill text-bg-light text-wrap me-1 mb-1'>$feature_row[name]</span> ";
                    }
                    // Thumbnail
                    $event_thumbnail = EVENTS_IMG_PATH . "thumb.png";
                    $thumbnail_q = mysqli_query($conn, "SELECT * FROM `event_image` WHERE `event_id` = '$event_data[id]' AND `thumbnail`='1'");
                    if (mysqli_num_rows($thumbnail_q) > 0) {
                        $thumbnail_res = mysqli_fetch_assoc($thumbnail_q);
                        $event_thumbnail = EVENTS_IMG_PATH . $thumbnail_res['image'];
                    }
                    $book_btn = "";
                    $login = 0;
                    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                        $login = 1;
                    }
                    $book_btn = " <button onclick='checkLogin($login, $event_data[id])' class='btn btn-sm btn-success shadow-none'>Book Event</button>";
                    // Printing card
                    echo <<<data
                        <div class="col-lg-3 col-md-12 px-4 mt-4 event-card" data-category="$event_data[category]">
                            <div class="card mb-4 border-0 shadow" style="max-width: 300px;">
                                <img src="$event_thumbnail" class="card-img-top" alt="" height="200px">
                                <div class="card-body px-4 py-4">
                                    <h5>$event_data[name]</h5>
                                    
                                    <div class="features mb-4">
                                        <h6 class="mb-1 mt-4">Price</h6>
                                        Rs.$event_data[price]
                                    </div>
                                    <div class="category mb-4">
                                        <h6 class="mb-1 mt-4">Category</h6>
                                        <span class="badge rounded-pill text-bg-light text-wrap">$event_data[category]</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>$book_btn</div>
                                        <a href="event_details.php?id=$event_data[id]" class="btn btn-sm custom-bg">More Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    data;
                }
                ?>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Initialize Search -->
    <script>
        $(document).ready(function() {
            $('#categorySearch').on('input', function() {
                var searchTerm = $(this).val().toLowerCase();
                filterEvents(searchTerm);
            });

            function filterEvents(term) {
                var visibleEvents = 0;
                $('.event-card').each(function() {
                    var eventCategory = $(this).data('category').toLowerCase();
                    if (term === "" || eventCategory.includes(term)) {
                        $(this).show();
                        visibleEvents++;
                    } else {
                        $(this).hide();
                    }
                });

                // Show/hide the "No events available" message
                if (visibleEvents === 0) {
                    $('#noEventsMessage').css('display', 'flex');
                } else {
                    $('#noEventsMessage').css('display', 'none');
                }
            }
        });
    </script>
</body>

</html>