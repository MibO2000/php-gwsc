<?php

if (!isset($_SESSION['cid'])) {
    header('Location: /login');
    return;
}

$wearUrl = "https://55gadgets.com/wearable-technology/feed/";
$wearArr = simplexml_load_file($wearUrl);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Features</title>
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
                    <a class="active" href="/features">Features</a>
                    <a href="/local-attraction">Local Attraction</a>
                    <a href="/packages">Availability</a>
                    <a href="/reviews">Reviews</a>
                </div>
            </div>

            <div id="myDropdown2" class="dropdown-content logout">
                <a href="/logout">Log Out</a>
            </div>

            <div class="container mx-auto heading-pa">
                <div class="flex flex-column">
                    <div class="w-full">
                        <h2 class="heading-style">
                            Features
                        </h2>
                        <div class="grid grid-cols-2 py-5 place-items-center" class="features-subtitle">
                            <div>
                                <img class="w-full" src="/images/entertainment.jpeg">
                            </div>
                            <div>
                                <h2 class="features-title">Entertainment Facilities</h2>
                                <p>At GWSC, we take pride in providing a plethora of entertainment facilities to make
                                    your camping experience unforgettable. Whether you're an adrenaline junkie or
                                    seeking relaxation, our sites have something for everyone. Engage in friendly
                                    competitions with beach volleyball or enjoy thrilling tug-of-war contests by the
                                    water's edge. For those seeking tranquility, our designated yoga and meditation
                                    spaces offer a serene escape amidst nature's beauty. As the sun sets, gather around
                                    the campfire for captivating storytelling and stargazing. Our entertainment
                                    facilities ensure that each moment is filled with joy, fostering connections with
                                    fellow campers and creating lasting memories.</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 py-5 place-items-center" class="features-subtitle">
                            <div>
                                <h2 class="features-title">Hot Showers</h2>
                                <p>We believe that comfort should never be compromised, even in the heart of nature. Our
                                    commitment to your well-being is reflected in the provision of modern and
                                    eco-friendly hot shower facilities at all GWSC sites. After a day of adventure,
                                    indulge in the luxury of a warm shower to refresh and rejuvenate. Our showers offer
                                    ample privacy and a continuous supply of warm water, allowing you to unwind in a
                                    natural oasis. Embrace the invigorating experience of a hot shower while knowing
                                    that our sustainability efforts ensure minimal impact on the environment. At GWSC,
                                    we prioritize your comfort, offering a serene haven where you can relax and recharge
                                    after embracing the wonders of the wild.</p>
                            </div>
                            <div>
                                <img class="w-full" src="/images/shower.png">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 py-5 place-items-center" class="features-subtitle">
                            <div>
                                <img class="w-full" src="/images/camp-cafe.jpeg">
                            </div>
                            <div>
                                <h2 class="features-title">On-site Cafes</h2>
                                <p>Elevate your dining experience at GWSC with our on-site cafes, where culinary
                                    delights await. Our talented chefs craft an array of mouthwatering dishes,
                                    celebrating both local and international flavors. Start your day with a hearty
                                    breakfast that energizes your adventures, or savor artisanal treats during leisurely
                                    afternoons. Our open-air seating areas provide stunning views of the surrounding
                                    landscapes, creating an ambiance that complements your outdoor exploration.
                                    Embracing our commitment to community support, our cafes showcase regional
                                    specialties, supporting local farmers and artisans. Enjoy meals that are not only
                                    delicious but also a reflection of the unique culture and nature of each site. At
                                    GWSC, we celebrate food as an integral part of the camping experience, inviting you
                                    to savor every moment with each delightful bite.</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 py-5 place-items-center" class="features-subtitle">
                            <div>
                                <h2 class="features-title">Guided Nature Walks</h2>
                                <p>Discover the wonders of the wilderness with our guided nature walks, led by
                                    experienced guides passionate about the natural world. Traverse scenic trails,
                                    immersing yourself in lush forests and alongside pristine waterways. Our guides
                                    share their knowledge of local flora and fauna, providing insights into the delicate
                                    ecosystems that thrive in these havens. From wildlife enthusiasts to nature lovers,
                                    our guided walks cater to all skill levels, ensuring everyone can connect with the
                                    great outdoors. Embrace the serenity of nature as you explore at your own pace,
                                    gaining a profound appreciation for the beauty that surrounds us. At GWSC, we
                                    believe that the best way to understand and cherish nature is through guided
                                    exploration, creating memories that deepen your connection with the natural world.
                                </p>
                            </div>
                            <div>
                                <img class="w-full" src="/images/nature walk.jpeg">
                            </div>
                        </div>
                    </div>
                    <div class="rss-parent">
                        <div class="rss-feed rss-scroll">
                            <?php

                            if (isset($wearArr->channel)) {
                                $wearCha = $wearArr->channel;
                                echo "<h2>" . $wearCha->title . "</h2><br>";
                                foreach ($wearCha->item as $item) {
                                    echo '<div class="rss-container">';
                                    echo '<h3><a href="' . $item->link . '" target="_blank">' . $item->title . '</a></h3>';
                                    echo '<p>' . $item->description . '</p>';
                                    echo '</div><br>';
                                }
                            } else {
                                print_r("invalid channel");
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="social-footer items-center">
            <div class="social-footer-left">
                <a href="/contact-us" class="social-footer-left-text">Contact Info</a>
            </div>
            <div>
                <p class="text-center copyright">Features<br>© 2023, MibO.<br>All Rights Reserved.</p>
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