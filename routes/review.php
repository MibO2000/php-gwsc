<?php

$isSuccess = false;
$isError = false;
$errorMessage;
if (!isset($_SESSION['cid'])) {
    header('Location: /login');
    return;
}

if (isset($_SESSION['SUCCESS_REGISTER'])) {
    unset($_SESSION['SUCCESS_REGISTER']);
    $isSuccess = true;
}

$reviewSql = "SELECT * FROM gwsc_review ORDER BY review_id";
$reviewQuery = mysqli_query($connect, $reviewSql);
$reviewCount = mysqli_num_rows($reviewQuery);
if ($reviewCount > 0) {
    $reviews = array(); // Initialize an empty array to hold the rows

    while ($row = $reviewQuery->fetch_array()) {
        $reviews[] = $row; // Append each row to the array
    }
} else {
    //
}
if ($_POST) {
    $reviewId = AutoID('gwsc_review', 'review_id', 'REVIEW', 4);
    $customerId = $_SESSION['cid'];
    $content = $_POST['content'];
    $stars = $_POST['rating'];
    if ($stars == null || $stars < 0) {
        echo "<script>window.alert('Stars cannot be empty!')</script>";
    } elseif ($content == null || $content == " ") {
        echo "<script>window.alert('Content cannot be empty!')</script>";
    } else {
        $date = date("Y-m-d");
        $insertReviewSql = "INSERT INTO gwsc_review(review_id, customer_id, content, stars, date_time) 
            VALUES ('$reviewId','$customerId','$content','$stars','$date')";
        $run = mysqli_query($connect, $insertReviewSql);
        if ($run) {
            $_SESSION['SUCCESS_REGISTER'] = true;
        } else {
            $_SESSION['FAIL'] = true;
            $_SESSION['error'] = "Fail to add a new review";
        }
        header('Location: /reviews');
    }
}

function getCustomerName($cid, $connect)
{
    $pquery = "SELECT * FROM gwsc_customer WHERE customer_id = '$cid'";
    $result = mysqli_query($connect, $pquery);
    $resultData = mysqli_fetch_assoc($result);
    return $resultData['first_name'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reviews</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="images/logo.png">
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
                    <a class="active" href="/reviews">Reviews</a>
                </div>
            </div>

            <div id="myDropdown2" class="dropdown-content" style="top:72px;right:25px;">
                <a href="/logout">Log Out</a>
            </div>


            <?php if ($isSuccess) { ?>
                <div class="alert alert-success">
                    <p>Package added SUCCESSFULLY!</p>
                </div>
            <?php } ?>
            <?php if ($isError) { ?>
                <div class="alert alert-error">
                    <p><?= $errorMessage ?></p>
                </div>
            <?php } ?>
            <div class="container mx-auto grid sm-grid-cols-2">
                <div>
                    <object data="images/reviews.png" class="w-full"></object>
                </div>
                <form method="POST">
                    <div style="padding-top:80px">
                        <div class="w-full">
                            <div class="rating">
                                <input type="radio" id="star5" name="rating" value="5">
                                <label for="star5"></label>
                                <input type="radio" id="star4" name="rating" value="4">
                                <label for="star4"></label>
                                <input type="radio" id="star3" name="rating" value="3">
                                <label for="star3"></label>
                                <input type="radio" id="star2" name="rating" value="2">
                                <label for="star2"></label>
                                <input type="radio" id="star1" name="rating" value="1">
                                <label for="star1"></label>
                            </div>

                            <div class="w-full">
                                <textarea class="w-full" name="content" placeholder="Enter your comment" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="review-sec">
                            <h2 style="font-size:large;font-weight:bold">
                                Review
                            </h2>

                            <div class="py-5">
                                <button type="submit" class="bg-primary w-full text-white">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <h2 style="text-align:left;padding:20px 15px;font-size:large;font-weight:bold">
                Reviews
            </h2>
            <div>
                <?php
                if (empty($reviews)) {
                    echo "<p> Review List is empty! </p>";
                } else {
                    foreach ($reviews as $review) { ?>
                        <div class="review-card">
                            <div class="rating">
                                <?php for ($i = 0; $i < 5; $i++) {
                                    if ($i < $review['stars']) { ?>
                                        <span class="star active"></span>
                                    <?php } else { ?>
                                        <span class="star"></span>
                                <?php }
                                } ?>
                            </div>
                            <p class="review-name"><?php echo getCustomerName($review['customer_id'], $connect) ?>
                                <span class="review-date"><?php echo $review['date_time'] ?></span>
                            </p>
                            <p><?php echo $review['content'] ?></p>
                        </div>
                <?php }
                } ?>
        </main>

        <footer class="social-footer items-center">
            <div class="social-footer-left">
                <a href="/contact-us" class="social-footer-left-text">Contact Info</a>
            </div>
            <div>
                <p class="text-center copyright">Reviews<br>© 2023, MibO.<br>All Rights Reserved.</p>
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
                        <a href="https320px://www.pinterest.com/" class="fa fa-pinterest" target="_blank">
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