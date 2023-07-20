<?php
$isSuccess = false;
$isError = false;
$message;
if (!isset($_SESSION['cid'])) {
    header('Location: /login');
    return;
}
$cid = $_SESSION['cid'];

if (isset($_SESSION['SUCCESS_REGISTER'])) {
    unset($_SESSION['SUCCESS_REGISTER']);
    $isSuccess = true;
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
if (isset($_SESSION['FAIL'])) {
    unset($_SESSION['FAIL']);
    $isError = true;
    $message = $_SESSION['error'];
    unset($_SESSION['error']);
}
if (isset($_POST['btndelete'])) {
    $bid = $_POST['id'];
    $bookDetailSql = "SELECT * FROM gwsc_booking_detail WHERE booking_detail_id = '$bid'";
    $bookDetailquery = mysqli_query($connect, $bookDetailSql);
    $book = mysqli_fetch_assoc($bookDetailquery);
    $bookid = $book['booking_id'];

    $bookSql = "SELECT * FROM gwsc_booking_detail WHERE booking_id = '$bookid'";
    $bookquery = mysqli_query($connect, $bookSql);



    $deleteQuery1 = "DELETE FROM gwsc_booking_detail WHERE booking_detail_id = '$bid'";
    $deleteQuery2 = "DELETE FROM gwsc_booking WHERE booking_id = '$bookid'";

    // Execute the DELETE query
    if (mysqli_query($connect, $deleteQuery1)) {
        if (mysqli_num_rows($bookquery) == 1) {
            if (mysqli_query($connect, $deleteQuery2)) {
                $_SESSION['SUCCESS_REGISTER'] = true;
                $_SESSION['message'] = 'Booking removed SUCCESSFULLY!';
                header('Location: /cart');
            } else {
                $_SESSION['FAIL'] = true;
                $_SESSION['error'] = "Error deleting record: " . mysqli_error($connect);
                header('Location: /cart');
            }
        }
    } else {
        $_SESSION['FAIL'] = true;
        $_SESSION['error'] = "Error deleting record: " . mysqli_error($connect);
        header('Location: /cart');
    }
}
if (isset($_POST['btncheckout'])) {
    $updateQuery = "UPDATE gwsc_booking SET booking_status = 'SUCCESS', order_time = NOW() WHERE customer_id = '$cid'";

    if (mysqli_query($connect, $updateQuery)) {
        $_SESSION['SUCCESS_REGISTER'] = true;
        $_SESSION['message'] = 'Booking ordered SUCCESSFULLY!';
        header('Location: /cart');
    } else {
        $_SESSION['FAIL'] = true;
        $_SESSION['error'] = "Error ordering record: " . mysqli_error($connect);
        header('Location: /cart');
    }
}

function getPitchName($pid, $connect)
{
    $pquery = "SELECT * FROM gwsc_pitch WHERE pitch_id = '$pid'";
    $result = mysqli_query($connect, $pquery);
    $resultData = mysqli_fetch_assoc($result);
    return $resultData['pitch_name'];
}

function getLocName($lid, $connect)
{
    $lquery = "SELECT * FROM gwsc_location WHERE location_id = '$lid'";
    $result = mysqli_query($connect, $lquery);
    $resultData = mysqli_fetch_assoc($result);
    return $resultData['location_name'];
}
function getPack($packId, $connect)
{
    $packageSql = "SELECT * FROM gwsc_package WHERE package_id = '$packId'";
    $packageQuery = mysqli_query($connect, $packageSql);
    $package = mysqli_fetch_assoc($packageQuery);
    return $package;
}


$bookingsql = "SELECT * FROM gwsc_booking WHERE customer_id = '$cid' AND booking_status = 'INIT'";
$bookingquery = mysqli_query($connect, $bookingsql);
$book = mysqli_fetch_assoc($bookingquery);
$bookings = array(); // Initialize an empty array to hold the rows
if (empty($book)) {
} else {
    $bookId = $book['booking_id'];
    $bookDetailSql = "SELECT * FROM gwsc_booking_detail WHERE booking_id = '$bookId'";
    $bookDetailquery = mysqli_query($connect, $bookDetailSql);
    while ($row = $bookDetailquery->fetch_array()) {
        $bookings[] = $row; // Append each row to the array
    }
}
$total = 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="images/logo.png">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.css" rel="stylesheet">
</head>

<body>
    <div class="flex justify-between flex-col min-h-screen">
        <main>
            <?php if ($isSuccess) { ?>
                <div class="alert alert-success">
                    <p><?= $message ?></p>
                </div>
            <?php } ?>

            <?php if ($isError) { ?>
                <div class="alert alert-error">
                    <p><?= $message ?></p>
                </div>
            <?php } ?>
            <div class="hamburger-menu">
                <input id="menu__toggle" type="checkbox" />
                <label class="menu__btn" for="menu__toggle">
                    <span></span>
                </label>

                <ul class="menu__box">
                    <li>
                        <a class="menu__item pzero" href="#">
                            <div class="flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="padding-left:20px;height:50px;width:50px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span style="padding-right:7px"><?php echo $_SESSION['cname']; ?></span>
                            </div>
                        </a>
                    </li>
                    <li><a class="menu__item" href="/">Home</a></li>
                    <li><a class="menu__item" href="/about-us">Information</a></li>
                    <li><a class="menu__item" href="/pitch">Pitch Types</a></li>
                    <li><a class="menu__item" href="/features">Features</a></li>
                    <li><a class="menu__item" href="/local-attraction">Local Attraction</a></li>
                    <li><a class="menu__item" href="/reviews">Reviews</a></li>
                    <li><a class="menu__item flex items-center cursor-pointer pzero mactive" href="/cart">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="padding-left:20px;height:50px;width:50px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <div class="nav">
                    <div class="logo">
                        <img src="images/logo.png" class="logoimg-width">
                        <h1>Global Wild Swimming & Camping</h1>
                    </div>

                    <div class="flex disappear">
                        <div class="flex items-center cursor-pointer" id="profile-bar" onmouseenter="toggleProfileMenu()">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="padding-left:20px;height:50px;width:50px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p style="padding-left:7px"><?php echo $_SESSION['cname']; ?></p>
                        </div>
                        <a class="flex items-center cursor-pointer" href="/cart">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="padding-left:20px;height:50px;width:50px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
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

            <div id="myDropdown2" class="dropdown-content" style="top:72px;right:25px;">
                <a href="/logout">Log Out</a>
            </div>

            <form method="POST">
                <div class="container mx-auto" style="padding-top:54px;padding-bottom:50px;">
                    <?php
                    if (!empty($bookings)) {

                        foreach ($bookings as $booking) : ?>
                            <?php $pack = getPack($booking['package_id'], $connect) ?>
                            <form method="POST">
                                <div class="package-card">
                                    <img class="thumbnail" src="images/<?= $pack['package_image'] ?>">
                                    <div class="detail">
                                        <div>
                                            <h2><?= $pack['package_name'] ?></h2>
                                            <div class="py-5 flex">
                                                <div class="chip"><?= getPitchName($pack['pitch_id'], $connect) ?></div>
                                                <div class="chip"><?= getLocName($pack['location_id'], $connect) ?></div>
                                            </div>
                                            <div>
                                                <label style="font-size:small;padding-bottom:5px;display:block;">Date</label>
                                                <input type="date" value="<?= date("Y-m-d", strtotime(($booking['booking_date']))) ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="flex items-center w-full justify-between">
                                            <div>
                                                <p class="price"><?= $booking['total_price'] ?></p>
                                            </div>
                                            <div>
                                                <input type="hidden" name="id" value="<?= $booking['booking_detail_id'] ?>">
                                                <div class="flex" id="item-count">
                                                    <input name="quantity" value="<?= $booking['quantity'] ?>" class="text-center" style="width:50px" type="number">
                                                </div>

                                                <div style="padding-top:5px">
                                                    <button class="w-full bg-error text-white" name="btndelete">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <?php $total += $booking['total_price']; ?>
                    <?php endforeach;
                    } ?>


                    <div style="padding-top:40px;float:right;padding-right:40px;padding-bottom:40px;" class="flex space-x-5 items-center">
                        <h2 style="font-size:large;font-weight:bold">Total:</h2>
                        <p class="price" style="font-size:xx-large;font-weight:bold;color:#0a59cb"><?= $total ?></p>
                    </div>

                    <div style="padding-top:40px;" class="mpadding">
                        <button class="w-full bg-primary text-white" name='btncheckout'>
                            Check Out
                        </button>
                    </div>
                </div>
            </form>
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
    </script>
</body>

</html>