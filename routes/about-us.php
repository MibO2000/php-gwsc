<?php

if (!isset($_SESSION['cid'])) {
    header('Location: /login');
    return;
}
$countPack = "SELECT count(*) as packcount FROM ASSIGNMENT.gwsc_package";
$countQuery = mysqli_query($connect, $countPack);
$countResult = mysqli_fetch_assoc($countQuery);
$packCount = $countResult['packcount'];


$countView = "SELECT SUM(view_count) AS viewCount FROM gwsc_customer";
$viewQuery = mysqli_query($connect, $countView);
$viewResult = mysqli_fetch_assoc($viewQuery);
$viewCount = $viewResult['viewCount'];

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
    <link rel="icon" href="images/logo.png">
</head>

<body>
    <div class="flex justify-between flex-col min-h-screen">
        <main>
            <?php require_once('mobilemenu.php') ?>
            <div>
                <div class="nav">
                    <div class="logo">
                        <img src="images/logo.png" class="logoimg-width">
                        <h1>Global Wild Swimming & Camping</h1>
                    </div>

                    <div class="flex disappear">
                        <div class="flex items-center cursor-pointer" id="profile-bar" onmouseenter="toggleProfileMenu()">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="profile-logo">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="pl-7"><?php echo $_SESSION['cname']; ?></p>
                        </div>
                        <a class="flex items-center cursor-pointer" href="/cart">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="profile-logo">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="nav-bar disappear">
                    <a href="/">Home</a>
                    <a class="active" href="/about-us">Information</a>
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

            <div class="container mx-auto heading-pa">
                <h2 class="heading-style">
                    About Us
                </h2>

                <div class="py-5 grid grid-cols-2">
                    <div class="flex justify-center items-center">
                        <p>
                            Global Wild Swimming and Camping (GWSC) was born from a shared passion for the great
                            outdoors and a profound love for the untamed beauty of nature. Established in 2011,
                            GWSC is a premier destination for those seeking extraordinary camping and
                            wild swimming experiences in some of the world's most breathtaking locations.
                            <br>
                            At GWSC, we believe that the wilderness holds the power to rejuvenate, inspire, and
                            reconnect individuals with their inner adventurer. We are driven by a commitment to curate
                            exceptional experiences that immerse our guests in the splendor of natural wonders while
                            fostering sustainable and eco-friendly practices.
                            <br>
                            Our handpicked sites are thoughtfully chosen to offer not just a place to lay your head but
                            an opportunity to indulge in the awe-inspiring landscapes that surround you. Whether you're
                            setting up camp under the starlit sky, plunging into crystal-clear waters for a wild swim,
                            or exploring scenic trails that wind through lush forests and picturesque valleys, every
                            moment with GWSC is an invitation to embrace the untamed spirit of nature.
                        </p>
                    </div>
                    <div>
                        <img src="images/undraw_Team_spirit_re_yl1v.png" class="w-half">
                    </div>
                </div>

                <div class="py-5 mpadding">
                    <div class="about-us-info">
                        <div class="text-center flex justify-center items-center">
                            <p class="blue"><?= $packCount ?> Packages</p>
                        </div>
                        <div class="text-center flex justify-center items-center">
                            <p class="red">12 Years</p>
                        </div>
                        <div class="text-center flex justify-center items-center">
                            <p class="green"><?= $viewCount ?> Views</p>
                        </div>
                    </div>
                </div>

                <div class="py-5 grid grid-cols-2">
                    <div>
                        <img src="images/undraw_team_work_k80m.png" class="w-half">
                    </div>
                    <div class="flex justify-center items-center">
                        <p>
                            What sets us apart is our dedication to creating a warm and inviting atmosphere that ensures
                            the safety and enjoyment of all our guests. Our team of seasoned outdoor enthusiasts and
                            hospitality experts work tirelessly to provide personalized service, ensuring you have
                            everything you need for a seamless and unforgettable experience.
                            <br>
                            Sustainability lies at the heart of our values. We are deeply committed to preserving the
                            pristine beauty of the environments we call home. Through responsible tourism practices and
                            community engagement, we strive to leave a positive impact on the places we operate in,
                            empowering local communities and protecting delicate ecosystems for generations to come.
                            <br>
                            Embark on a journey of discovery with Global Wild Swimming and Camping, where you can
                            embrace the wilderness, embrace adventure, and create memories that will last a lifetime. We
                            invite you to join us as we embark on this incredible expedition to rediscover the magic of
                            the natural world, one wild adventure at a time.
                        </p>
                    </div>
                </div>
            </div>
        </main>

        <footer class="social-footer items-center">
            <div class="social-footer-left">
                <a href="/contact-us" class="social-footer-left-text">Contact Info</a>
            </div>
            <div>
                <p class="text-center copyright">Information<br>© 2023, MibO.<br>All Rights Reserved.</p>
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