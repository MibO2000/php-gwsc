<?php

if (!isset($_SESSION['cid'])) {
    header('Location: /login');
    return;
}
if (isset($_GET['pack'])) {
    $searchQuery = $_GET['pack'];
    header("Location: /packages?pack=" . urlencode($searchQuery));
    exit;
}

$countView = "SELECT SUM(view_count) AS viewCount FROM gwsc_customer";
$viewQuery = mysqli_query($connect, $countView);
$viewResult = mysqli_fetch_assoc($viewQuery);
$viewCount = $viewResult['viewCount'];

$packageSql = "SELECT * FROM gwsc_package ORDER BY package_id";
$packageQuery = mysqli_query($connect, $packageSql);
$packageCount = mysqli_num_rows($packageQuery);
if ($packageCount > 0) {
    // for each row, get image, get description and insert in slide show.
} else {
    // if there is no package, display image from the /images/.
}


$pitchSql = "SELECT * FROM gwsc_pitch ORDER BY RAND() LIMIT 1";
$pitchQuery = mysqli_query($connect, $pitchSql);
$pitchCount = mysqli_num_rows($pitchQuery);


$localSql = "SELECT * FROM gwsc_location ORDER BY RAND() LIMIT 1";
$localQuery = mysqli_query($connect, $localSql);
$localCount = mysqli_num_rows($localQuery);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="images/logo.png">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.css" rel="stylesheet">
</head>

<body>
    <div class="flex justify-between flex-col min-h-screen">
        <main>

            <?php include('mobilemenu.php') ?>


            <div class="home-nav">
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
                    <a class="active" href="/">Home</a>
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

            <video class="ads" src="videos/ads.mp4" autoplay muted loop playsinline></video>

            <div style=" position:relative;top:-100px;padding-bottom:50px;">
                <div class="container mx-auto">
                    <div style="padding-bottom: 40px;" class="mpadding">
                        <div class="pb-5">
                            <form class="form-field" action="" method="GET">
                                <div class="pb-5">
                                    <input class="w-full" type="search" name="pack" placeholder="Search" style="padding:15px 20px;font-size:larger" value="<?php echo $_GET['pack'] ?? '' ?>">
                                </div>
                            </form>
                        </div>
                    </div>

                    <div style="padding-bottom: 40px;">
                        <div class="flex justify-between space-x-5 mcard-container">
                            <div class="w-full flex justify-center items-center mcard mpadding">
                                <div class="pricing-card">

                                    <?php
                                    if ($pitchCount == 1) {
                                        $row = mysqli_fetch_assoc($pitchQuery);
                                        $img = $row['pitch_image'];
                                        echo '<img src="images/' . $img . '">';
                                    } else {
                                        echo '<img src="https://images.unsplash.com/photo-1682685797507-d44d838b0ac7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2970&q=80">';
                                    }
                                    ?>


                                    <div class="content">
                                        <h2>Pitch</h2>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus earum
                                            consequatur adipisci magni delectus nobis ut consectetur! Dolore eaque,
                                            quia, ea sequi cumque, beatae quod non repellendus ut voluptatibus
                                            accusamus!</p>
                                        <a href="/pitch">
                                            <button class="bg-primary text-white">Explore &#xbb;</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex justify-center items-center mcard mpadding">
                                <div class="pricing-card">
                                    <img src="/images/home-bg.jpg">
                                    <div class="content">
                                        <h2>Features</h2>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus earum
                                            consequatur adipisci magni delectus nobis ut consectetur! Dolore eaque,
                                            quia, ea sequi cumque, beatae quod non repellendus ut voluptatibus
                                            accusamus!</p>
                                        <a href="/features">
                                            <button class="bg-primary text-white">Explore &#xbb;</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex justify-center items-center mcard mpadding">
                                <div class="pricing-card">
                                    <?php
                                    if ($localCount == 1) {
                                        $row = mysqli_fetch_assoc($localQuery);
                                        $img = $row['location_picture'];
                                        echo '<img src="images/' . $img . '">';
                                    } else {
                                        echo '<img src="https://images.unsplash.com/photo-1682685797507-d44d838b0ac7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2970&q=80">';
                                    }
                                    ?>
                                    <div class="content">
                                        <h2>Local Attraction</h2>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus earum
                                            consequatur adipisci magni delectus nobis ut consectetur! Dolore eaque,
                                            quia, ea sequi cumque, beatae quod non repellendus ut voluptatibus
                                            accusamus!</p>
                                        <a href="/local-attraction">
                                            <button class="bg-primary text-white">Explore &#xbb;</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid sm-grid-cols-2 pb-5">
                        <div class="m-5">
                            <h3 class="text-center" style="font-weight:bold;font-size:large;padding-bottom:15px;">About
                                Us</h3>
                            <div class="mpadding">
                                <p>
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repudiandae architecto
                                    magni, inventore, molestiae, quas consectetur tenetur rem nulla fugiat facere quos.
                                    Tempore doloremque autem quos expedita iure? Quis, cum id?
                                </p>
                                <p>
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio fugiat quas quod
                                    alias eligendi asperiores! A, tempora voluptatum? Neque odit illum recusandae
                                    laborum vero architecto voluptatem illo exercitationem repellendus vel.
                                </p>
                            </div>
                            <div>
                                <div class="view-count-info">
                                    <div class="text-center flex justify-center items-center">
                                        <p><?= $viewCount ?> Views</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div id="map" class="map mpadding"></div>
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