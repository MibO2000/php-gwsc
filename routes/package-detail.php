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
    // echo "<script>window.alert('Customer registered SUCCESSFULLY!')</script>";
    $isSuccess = true;
}
if (isset($_SESSION['FAIL'])) {
    unset($_SESSION['FAIL']);
    $isError = true;
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']);
}
$pid = $_GET['id'];
$packageSql = "SELECT * FROM ASSIGNMENT.PACKAGE WHERE PACKAGE_ID = '$pid'";
$packageQuery = mysqli_query($connect, $packageSql);

$package = mysqli_fetch_assoc($packageQuery);
if ($package) {
} else {
    http_response_code(404);
    require __DIR__ . '/404.php';
    return;
}
$pid = $package['PITCH_TYPE_ID'];
$lid = $package['LOCATION_ID'];
$pquery = "SELECT * FROM ASSIGNMENT.PITCH WHERE PITCH_ID = '$pid'";
$pitchQ = mysqli_query($connect, $pquery);
$pitch = mysqli_fetch_assoc($pitchQ);


$lquery = "SELECT * FROM ASSIGNMENT.LOCATION WHERE LOCATION_ID = '$lid'";
$locationQ = mysqli_query($connect, $lquery);
$local = mysqli_fetch_assoc($locationQ);


if (isset($_POST['btncart'])) {
    $bid = AutoID('BOOKING', 'BOOKING_ID', 'BOOK', 4);
    $quantity = $_POST['quantity'];
    $price = $package['PRICE'];
    $date = $_POST['date'];
    $id = $_POST['id'];
    $cid = $_SESSION['cid'];
    $tax = 0.1 * $price * $quantity;
    $total = $price * $quantity;
    $cash = $tax + $total;
    $status = 'INIT';
    print_r($bid . ' | ' . $quantity . ' | ' . $price . ' | ' . $date . ' | ' . $id . ' | ' . $cid . ' | ' . $tax . ' | ' . $cash . ' | ' . $status);
    $insert = "INSERT INTO ASSIGNMENT.BOOKING (BOOKING_ID, CUSTOMER_ID, PACKAGE_ID, QUANTITY, TAX, PRICE, TOTAL_AMOUNT, BOOKING_DATE, BOOKING_STATUS) 
    VALUES ('$bid','$cid','$id','$quantity', '$tax', '$price', '$cash', '$date', '$status')";
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
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.css" rel="stylesheet">
</head>

<body>
    <div class="flex justify-between flex-col min-h-screen">
        <main>
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
            <div>
                <div class="nav">
                    <div class="logo">
                        <img src="images/logo.png" style="width:120px;">
                        <h1>Global Wild Swimming & Camping</h1>
                    </div>

                    <div class="flex">
                        <div class="flex items-center cursor-pointer" id="profile-bar"
                            onmouseenter="toggleProfileMenu()">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    style="padding-left:20px;height:50px;width:50px;">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p style="padding-left:7px"><?php echo $_SESSION['cname']; ?></p>
                        </div>
                        <a class="flex items-center cursor-pointer" href="/cart">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    style="padding-left:20px;height:50px;width:50px;">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="nav-bar">
                    <a href="/">Home</a>
                    <a href="/about-us">Information</a>
                    <a href="/pitch">Pitch Types</a>
                    <a href="/features">Features</a>
                    <a href="/local-attraction">Local Attraction</a>
                    <a class="active" href="/packages">Availability</a>
                    <a href="/reviews">Reviews</a>
                </div>
            </div>

            <div id="myDropdown2" class="dropdown-content" style="top:72px;right:25px;">
                <a href="/logout">Log Out</a>
            </div>

            <div class="container mx-auto" style="padding-top:54px;padding-bottom:50px;">
                <form method="POST">
                    <div class="flex" style="gap:20px">
                        <img class="w-full object-cover object-center detail-thumbnail"
                            src="images/<?= $package['PICTURE1'] ?>">

                        <div class="flex flex-col w-full justify-between" style="padding:20px 10px;">
                            <div>
                                <h2 style="font-size:xx-large;font-weight:bold;text-align:left">
                                    <?= $package['PACKAGE_NAME'] ?>
                                </h2>
                                <div class="py-5 flex">
                                    <div class="chip"><?= $pitch['PITCH_NAME'] ?>
                                    </div>
                                    <div class="chip"><?= $local['LOCATION_NAME'] ?>
                                    </div>
                                </div>
                                <div class="padding-top:20px">
                                    <label for="date" style="padding-bottom:5px;display:block">Choose date</label>
                                    <input type="date" name="date" class="w-full" required>
                                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                </div>
                            </div>
                            <div class='w-full flex justify-between items-center'>
                                <p class="price"><?= $package['PRICE'] ?></p>
                                <div class="flex" id="item-count">
                                    <button type="button" id="decrease">-</button>
                                    <input name="quantity" value=1 class="text-center" style="width:50px" type="number">
                                    <button type="button" id="increase">+</button>
                                </div>
                                <div style="padding-top:20px">
                                    <button class="text-white bg-primary w-full" name='btncart'>
                                        Add to cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="flex items-center w-full" style="padding:40px 10px;">
                    <div style="width:400px">
                        <h2 style="font-size:large;font-weight:bold">
                            Package Detail
                        </h2>
                    </div>
                    <div class="w-full">
                        <p>
                            <?= $package['DESCRIPTION1'] ?>
                        </p>
                    </div>
                </div>

                <hr>

                <div class="flex items-center w-full" style="padding:50px 10px;">
                    <div class="w-full">
                        <p>
                        <p>
                            <?= $pitch['DESCRIPTION_PITCH'] ?>
                        </p>
                        </p>
                    </div>
                    <div style="width:400px">
                        <h2 style="font-size:large;font-weight:bold">
                            Pitch Detail
                        </h2>
                    </div>
                </div>

                <hr>

                <div class="flex items-center w-full" style="padding:40px 10px;">
                    <div style="width:400px">
                        <h2 style="font-size:large;font-weight:bold">
                            Local Attraction
                        </h2>
                    </div>
                    <div class="w-full">
                        <p>
                            <?= $local['DESCRIPTION'] ?>
                        </p>
                    </div>
                </div>

                <hr>

                <div class="grid grid-cols-2" style="gap:20px;padding:50px 10px;">
                    <div class="flex justify-center items-center h-full flex-col">
                        <h2 style="font-size:large;font-weight:bold;padding-bottom:15px;">
                            <?= $local['FULL_LOCATION'] ?>
                        </h2>
                        <p>
                            <?= $package['DESCRIPTION2'] ?>
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
                <p class="text-center copyright">© 2023, MibO.<br>All Rights Reserved.</p>
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
        center: [96.2044674, 16.8666789],
        zoom: 14,
    });
    var marker = new mapboxgl.Marker()
        .setLngLat([96.2044674, 16.8666789])
        .addTo(map)
        .setPopup(new mapboxgl.Popup().setHTML('<b>Global Wild Swimming & Camping</b>'))
        .togglePopup();
    </script>
</body>

</html>