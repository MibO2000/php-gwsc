<?php

if (!isset($_SESSION['cid'])) {
    header('Location: /login');
    return;
}


$packageSql = "SELECT * FROM gwsc_package ORDER BY package_id";
$packageQuery = mysqli_query($connect, $packageSql);
$packageCount = mysqli_num_rows($packageQuery);

$cusSql = "SELECT * FROM gwsc_customer ORDER BY customer_id";
$cusQuery = mysqli_query($connect, $cusSql);
$cusCount = mysqli_num_rows($cusQuery);
if ($cusCount > 0) {
} else {
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Information</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <div class="flex justify-between flex-col min-h-screen">
        <main>
            <div>
                <div class="nav">
                    <div class="logo">
                        <img src="images/logo.png" style="width:120px;">
                        <h1>Global Wild Swimming & Camping</h1>
                    </div>

                    <div class="flex">
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

                <div class="nav-bar">
                    <a href="/">Home</a>
                    <a class="active" href="/about-us">Information</a>
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

            <div class="container mx-auto" style="padding-top:54px;padding-bottom:50px">
                <h2 style="font-weight:bold;font-size:24px">
                    About Us
                </h2>

                <div class="py-5 grid grid-cols-2">
                    <div class="flex justify-center items-center">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus quis voluptatum illo
                            temporibus voluptate non voluptatibus aliquid qui at totam nihil hic quia, explicabo, dicta
                            earum aspernatur sed nostrum similique?</p>
                    </div>
                    <div>
                        <img src="images/undraw_Team_spirit_re_yl1v.png" class="w-half">
                    </div>
                </div>

                <div class="py-5">
                    <div class="about-us-info">
                        <div class="text-center flex justify-center items-center">
                            <p style="color: #4c88dc;">12 Packages</p>
                        </div>
                        <div class="text-center flex justify-center items-center">
                            <p style="color: #ef6e5d">12 Years</p>
                        </div>
                        <div class="text-center flex justify-center items-center">
                            <p style="color: #3c9e87">12 Views</p>
                        </div>
                    </div>
                </div>

                <div class="py-5 grid grid-cols-2">
                    <div>
                        <img src="images/undraw_team_work_k80m.png" class="w-half">
                    </div>
                    <div class="flex justify-center items-center">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus quis voluptatum illo
                            temporibus voluptate non voluptatibus aliquid qui at totam nihil hic quia, explicabo, dicta
                            earum aspernatur sed nostrum similique?</p>
                    </div>
                </div>
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
    </script>

</body>

</html>