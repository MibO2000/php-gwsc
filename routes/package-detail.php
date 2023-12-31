<?php

$isSuccess = false;
$isError = false;
$errorMessage;

if (!isset($_SESSION['cid'])) {
    header('Location: /login');
    return;
}

if (!isset($_GET['id']) || !$_GET['id']) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    return;
}

if (isset($_SESSION['SUCCESS_REGISTER'])) {
    unset($_SESSION['SUCCESS_REGISTER']);
    $isSuccess = true;
}
if (isset($_SESSION['FAIL'])) {
    unset($_SESSION['FAIL']);
    $isError = true;
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']);
}
$customer_id = $_SESSION['cid'];
$updateQuery = "UPDATE gwsc_customer SET view_count = view_count + 1 WHERE customer_id = '$customer_id'";
$updateResult = mysqli_query($connect, $updateQuery);

// if ($updateResult) {
//     echo "View count updated successfully.";
// } else {
//     echo "Error updating view count: " . mysqli_error($connect);
// }

$pid = $_GET['id'];
$pid = trim($pid, "'");
$packageSql = "SELECT * FROM gwsc_package WHERE package_id = '$pid'";
$packageQuery = mysqli_query($connect, $packageSql);
$package = mysqli_fetch_assoc($packageQuery);
if ($package) {
} else {
    http_response_code(404);
    require __DIR__ . '/404.php';
    return;
}
$pitchId = $package['pitch_id'];
$lid = $package['location_id'];
$ptid = $package['package_type_id'];
$quantity = $package['quantity'];

$pquery = "SELECT * FROM gwsc_pitch WHERE pitch_id = '$pitchId'";
$pitchQ = mysqli_query($connect, $pquery);
$pitch = mysqli_fetch_assoc($pitchQ);
$pitchTypeId = $pitch['pitch_type_id'];

$pityquery = "SELECT * FROM gwsc_pitch_type WHERE pitch_type_id = '$pitchTypeId'";
$pityQ = mysqli_query($connect, $pityquery);
$pitchType = mysqli_fetch_assoc($pityQ);

$lquery = "SELECT * FROM gwsc_location WHERE location_id = '$lid'";
$locationQ = mysqli_query($connect, $lquery);
$local = mysqli_fetch_assoc($locationQ);
$localType = $local['location_type_id'];

$ltquery = "SELECT * FROM gwsc_location_type WHERE location_type_id = '$localType'";
$locationTyQ = mysqli_query($connect, $ltquery);
$localType = mysqli_fetch_assoc($locationTyQ);

$ptquery = "SELECT * FROM gwsc_package_type WHERE package_type_id = '$ptid'";
$ptQ = mysqli_query($connect, $ptquery);
$ptype = mysqli_fetch_assoc($ptQ);

if (isset($_POST['btncart'])) {
    $cid = $_SESSION['cid'];
    $bdid = AutoID('gwsc_booking_detail', 'booking_detail_id', 'BOOKDE', 4);
    $quantity = $_POST['quantity'];
    $price = $package['price'];
    $date = $_POST['date'];
    $checkDate = new DateTime($date);
    $tax = 0.1 * $price * $quantity;
    $total = $price * $quantity;
    $cash = $tax + $total;
    $status = 'INIT';
    $currentDateTime = new DateTime();
    $orderTime = $currentDateTime->format('Y-m-d H:i:s.u');
    $bid = AutoID('gwsc_booking', 'booking_id', 'BOOK', 4);

    $checkQuery = "SELECT * FROM gwsc_booking_detail WHERE booking_date = '$date' and package_id = '$pid'";
    $checkSql = mysqli_query($connect, $checkQuery);
    if ($quantity - mysqli_num_rows($checkSql) <= 0) {
        $_SESSION['FAIL'] = true;
        $_SESSION['error'] = "Date Already Booked";
        header("Location: /package-detail?id='$pid'");
        return;
    }
    if ($checkDate < $currentDateTime) {
        $_SESSION['FAIL'] = true;
        $_SESSION['error'] = "Date is Wrong";
        header("Location: /package-detail?id='$pid'");
        return;
    }


    $bookQuery = "SELECT * FROM gwsc_booking WHERE customer_id = '$cid' and booking_status = '$status'";
    $bkQ = mysqli_query($connect, $bookQuery);
    if (mysqli_num_rows($bkQ) > 0) {
        $booking = mysqli_fetch_assoc($bkQ);
        $bid = $booking['booking_id'];
    } else {
        $insert = "INSERT INTO gwsc_booking (booking_id, customer_id, order_time, booking_status) 
VALUES ('$bid', '$cid', '$orderTime', '$status')";
        $run = mysqli_query($connect, $insert);
    }

    $insert = "INSERT INTO gwsc_booking_detail (booking_detail_id, booking_id, package_id, quantity, tax, price, total_price, booking_date) 
    VALUES ('$bdid','$bid','$pid','$quantity', '$tax', '$price', '$cash', '$date')";
    $run = mysqli_query($connect, $insert);
    if ($run) {
        $_SESSION['SUCCESS_REGISTER'] = true;
        header('Location: /packages');
    } else {
        $_SESSION['FAIL'] = true;
        $_SESSION['error'] = "Fail to book";
        header("Location: /package-detail?id='$pid'");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Package Detail</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="images/logo.png">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.css" rel="stylesheet">
</head>

<body>
    <div class="flex justify-between flex-col min-h-screen">
        <main>
            <?php include('mobilemenu.php') ?>
            <div>
                <div class="nav">
                    <div class="logo">
                        <img src="images/logo.png" class="logoimg-width">
                        <h1>Global Wild Swimming & Camping</h1>
                    </div>

                    <div class="flex disappear">
                        <div class="flex items-center cursor-pointer" id="profile-bar"
                            onmouseenter="toggleProfileMenu()">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="profile-logo">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="pl-7"><?php echo $_SESSION['cname']; ?></p>
                        </div>
                        <a class="flex items-center cursor-pointer" href="/cart">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="profile-logo">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="nav-bar disappear">
                    <a href="/">Home</a>
                    <a href="/about-us">Information</a>
                    <a href="/pitch">Pitch Types</a>
                    <a href="/features">Features</a>
                    <a href="/local-attraction">Local Attraction</a>
                    <a href="/packages">Availability</a>
                    <a href="/reviews">Reviews</a>
                </div>
            </div>

            <div id="myDropdown2" class="dropdown-content logout">
                <a href="/logout">Log Out</a>
            </div>

            <?php if ($isSuccess) { ?>
            <div class="alert alert-success">
                <p>Booking added SUCCESSFULLY!</p>
            </div>
            <?php } ?>
            <?php if ($isError) { ?>
            <div class="alert alert-error">
                <p><?= $errorMessage ?></p>
            </div>
            <?php } ?>
            <div class="container mx-auto heading-pa">
                <form method="POST">
                    <div class="grid grid-cols-2 gap-20">
                        <img class="w-full object-cover object-center detail-thumbnail"
                            src="images/<?= $package['package_image'] ?>">

                        <div class="flex flex-col w-full justify-between p-2-1">
                            <div>
                                <h2 class="package-detail-font">
                                    <?= $package['package_name'] ?>
                                </h2>
                                <div class="py-5 flex">
                                    <div class="chip"><?= $pitch['pitch_name'] ?>
                                    </div>
                                    <div class="chip"><?= $local['location_name'] ?>
                                    </div>
                                </div>
                                <div class="padding-top:20px">
                                    <label for="date" class="package-detail-date">Choose date</label>
                                    <input type="date" name="date" class="w-full" required>
                                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                </div>
                            </div>
                            <div class='w-full flex justify-between items-center'>
                                <p class="price"><?= $package['price'] ?></p>
                                <div class="flex" id="item-count">
                                    <button type="button" id="decrease">-</button>
                                    <input name="quantity" value=1 class="text-center w-50" type="number">
                                    <button type="button" id="increase">+</button>
                                </div>
                                <div class="pt-20">
                                    <button class="text-white bg-primary w-full" name='btncart'>
                                        Add to cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>
                <div class="grid grid-cols-2 package-detial-head">
                    <div class='w-full'>
                        <h2 class="font-l">
                            Package Detail
                        </h2>
                    </div>
                    <div class="w-full">
                        <p>
                            <?= $package['package_name'] ?>
                        </p>
                    </div>
                </div>

                <hr>
                <div class="grid grid-cols-2 package-detial-head">
                    <div class='w-full'>
                        <img class="w-full object-cover object-center detail-thumbnail"
                            src="images/<?= $ptype['picture'] ?>">
                    </div>
                    <div class="w-full">
                        <p>
                            <?= $package['pitch_description'] ?>
                        </p>
                    </div>
                </div>

                <hr>
                <div class="grid grid-cols-2 package-detial-head">
                    <div class='w-full'>
                        <h2 class="font-l">
                            Pitch Detail
                        </h2>
                    </div>
                    <div class="w-full">
                        <p>
                            <?= $pitch['pitch_name'] ?>
                        </p>
                    </div>
                </div>

                <hr>
                <div class="grid grid-cols-2 package-detial-head">
                    <div class="w-full">
                        <img class="w-full object-cover object-center detail-thumbnail"
                            src="images/<?= $pitch['pitch_image'] ?>">
                    </div>
                    <div class='w-full'>
                        <?= $pitch['pitch_description'] ?>
                    </div>
                </div>

                <hr>
                <div class="grid grid-cols-2 package-detial-head">
                    <div class='w-full'>
                        <h2 class="font-l">
                            Local Attraction
                        </h2>
                    </div>
                    <div class="w-full">
                        <p>
                            <?= $local['location_name'] ?>
                        </p>
                    </div>
                </div>

                <hr>
                <div class="grid grid-cols-2 package-detial-head">
                    <div class="w-full">
                        <img class="w-full object-cover object-center detail-thumbnail"
                            src="images/<?= $local['location_picture'] ?>">
                    </div>
                    <div>
                        <p>
                            <?= $local['location_description'] ?>
                        </p>
                    </div>
                </div>

                <hr>

                <div class="grid grid-cols-2 package-detial-head">
                    <div class="flex justify-center items-center h-full flex-col">
                        <h2 class="font-pad">
                            <?= $local['full_location'] ?>
                        </h2>
                        <p class="w-full">
                            <?= $ptype['package_description'] ?>
                        </p>
                    </div>
                    <div>
                        <div id="map" class="map"></div>
                    </div>
                </div>

                <hr>
            </div>
        </main>

        <footer class="social-footer items-center">
            <div class="social-footer-left">
                <a href="/contact-us" class="social-footer-left-text">Contact Info</a>
            </div>
            <div>
                <p class="text-center copyright">Package Detail<br>© 2023, MibO.<br>All Rights Reserved.</p>
            </div>
            <div class="social-footer-icons">
                <div class="flex">
                    <div class="mr-4">
                        <a href="https://www.facebook.com/" class="fa fa-facebook" target="_blank">
                            <img src="images/facebook.png" class="fa fa-facebook-png" alt="facebook">
                        </a>
                    </div>
                    <div class="mr-4">
                        <a href="https://www.instagram.com/?hl=en" class="fa fa-instagram" target="_blank">
                            <img src="images/instagram.jpeg" class="fa fa-instagram-png" alt="instagram">
                        </a>
                    </div>
                    <div class="mr-4">
                        <a href="https://www.pinterest.com/" class="fa fa-pinterest" target="_blank">
                            <img src="images/pinterest.png" class="fa fa-pinterest-png" alt="pinterest">
                        </a>
                    </div>
                    <div class="mr-4">
                        <a href="https://twitter.com/?lang=en" class="fa fa-twitter" target="_blank">
                            <img src="images/twitter.png" class="fa fa-twitter-png" alt="twitter">
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>


    <div id="overlay-profile" onmouseenter="toggleProfileMenu()" class="overlay display-none"></div>

    <script>
    var isMenuOpen = false;
    var menuBar = document.getElementById('menu-bar');
    var overlay = document.getElementById('overlay');

    function myFunction() {
        if (isMenuOpen) {
            isMenuOpen = false;
            menuBar.classList.remove("change");
            document.getElementById("myDropdown").classList.remove("show");
            overlay.classList.add('display-none');
        } else {
            isMenuOpen = true;
            menuBar.classList.add("change");
            document.getElementById("myDropdown").classList.add("show");
            overlay.classList.remove('display-none');
        }
    }

    // profile menu
    var isProfileMenuOpen = false;
    var profileMenuBar = document.getElementById('profile-bar');
    var profileOverlay = document.getElementById('overlay-profile');

    function toggleProfileMenu() {
        if (isProfileMenuOpen) {
            isProfileMenuOpen = false;
            profileMenuBar.classList.remove("change");
            document.getElementById("myDropdown2").classList.remove("show");
            profileOverlay.classList.add('display-none');
        } else {
            isProfileMenuOpen = true;
            profileMenuBar.classList.add("change");
            document.getElementById("myDropdown2").classList.add("show");
            profileOverlay.classList.remove('display-none');
        }
    }
    // Button to increase/decrease
    let itemCounters = document.querySelectorAll('#item-count');
    itemCounters.forEach(itemCounter => {
        console.log(itemCounter);
        let decreaseButton = itemCounter.querySelector('#decrease');
        let increaseButton = itemCounter.querySelector('#increase');
        let input = itemCounter.querySelector('input');
        decreaseButton.addEventListener('click', () => {
            let value = parseInt(input.value);
            if (value <= 1) return;
            input.value = value - 1;
        });
        increaseButton.addEventListener('click', () => {
            let value = parseInt(input.value);
            input.value = value + 1;
        });
    });

    // Map
    mapboxgl.accessToken =
        'pk.eyJ1IjoibXl0ZWwtc29mdHdhcmUiLCJhIjoiY2w5emg0MHoxMGE3djN2cjhhcGlwMXJwOSJ9.PjkQpWi6lDfuKDzTB7SFYw';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11?optimize=true',
        center: [<?= $package['longitude'] ?>, <?= $package['latitude'] ?>],
        zoom: 7,
    });
    var marker = new mapboxgl.Marker()
        .setLngLat([<?= $package['longitude'] ?>, <?= $package['latitude'] ?>])
        .addTo(map)
        .setPopup(new mapboxgl.Popup().setHTML('<b><?= $package['package_name'] ?></b>'))
        .togglePopup();
    window.scrollTo(0, 0);
    </script>
</body>

</html>