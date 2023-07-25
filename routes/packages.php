<?php
$isSuccess = false;
$isError = false;
$errorMessage;
if (!isset($_SESSION['cid'])) {
    header('Location: /login');
    return;
}
$packName = null;
$pitchName = null;
$locationName = null;
if (isset($_GET['pack'])) {
    $packName = $_GET['pack'];
}
if (isset($_GET['pitch'])) {
    $pitchName = $_GET['pitch'];
}
if (isset($_GET['location'])) {
    $locationName = $_GET['location'];
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
function isBlank($str)
{
    if (is_null($str)) return true;
    return trim($str) === '';
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

$pitchSql = "SELECT * FROM gwsc_pitch ORDER BY pitch_id";
$pitchQuery = mysqli_query($connect, $pitchSql);
$pitchLists = array();

while ($row = $pitchQuery->fetch_array()) {
    $pitchLists[] = $row;
}

$localSql = "SELECT * FROM gwsc_location ORDER BY location_id";
$localQuery = mysqli_query($connect, $localSql);
$localLists = array();

while ($row = $localQuery->fetch_array()) {
    $localLists[] = $row;
}
$pitchId = null;
$localId = null;


$packageSql = "SELECT * FROM gwsc_package ";
$where = false;
if (!isBlank($packName)) {
    $packageSql = $packageSql . " where UPPER(package_name) LIKE CONCAT('%', UPPER('$packName'), '%') ";
    $where = true;
}
if (!isBlank($pitchName)) {
    $pquery = "SELECT * FROM gwsc_pitch WHERE pitch_name = '$pitchName'";
    $pitchQ = mysqli_query($connect, $pquery);
    $pitch = mysqli_fetch_assoc($pitchQ);
    $pitchId = $pitch['pitch_id'];
    if ($where) {
        $packageSql = $packageSql . " AND pitch_id = '$pitchId' ";
    } else {
        $packageSql = $packageSql . " WHERE pitch_id = '$pitchId' ";
    }
}
if (!isBlank($locationName)) {
    $lquery = "SELECT * FROM gwsc_location WHERE location_name = '$locationName'";
    $locationQ = mysqli_query($connect, $lquery);
    $local = mysqli_fetch_assoc($locationQ);
    $localId = $local['location_id'];
    if ($where) {
        $packageSql = $packageSql . " AND location_id = '$localId' ";
    } else {
        $packageSql = $packageSql . " WHERE location_id = '$localId' ";
    }
}
$packageSql = $packageSql . " order by package_id";
$packageQuery = mysqli_query($connect, $packageSql);
$packages = array();
while ($row = $packageQuery->fetch_array()) {
    $packages[] = $row;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Availability</title>
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
                    <p>Booking added SUCCESSFULLY!</p>
                </div>
            <?php } ?>
            <?php if ($isError) { ?>
                <div class="alert alert-error">
                    <p><?= $errorMessage ?></p>
                </div>
            <?php } ?>
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
                    <a class="active" href="/packages">Availability</a>
                    <a href="/reviews">Reviews</a>
                </div>
            </div>

            <div id="myDropdown2" class="dropdown-content" style="top:72px;right:25px;">
                <a href="/logout">Log Out</a>
            </div>

            <div class="container mx-auto" style="padding-top:54px;padding-bottom:50px;">
                <div class="pb-5">
                    <form class="form-field mpadding">
                        <div class="pb-5">
                            <input class="w-full" type="search" name="pack" placeholder="Search" style="padding:15px 20px;font-size:larger" value="<?php echo $_GET['pack'] ?? '' ?>">
                        </div>

                        <div class="grid grid-cols-3" style="gap:15px">
                            <div>
                                <label for="pitch">Pitch</label>
                                <select class="w-full" name="pitch" id="pitch" style="padding:10px 20px;">


                                    <option value="" <?php echo isset($_GET['pitch']) ? '' : 'selected'; ?>>
                                        - All -</option>
                                    <?php foreach ($pitchLists as $pitch) { ?>
                                        <option value="<?php echo $pitch['pitch_name'] ?>" <?php echo ($_GET['pitch'] ?? '') === $pitch['pitch_name'] ? 'selected' : ''; ?>>
                                            <?php echo $pitch['pitch_name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div>
                                <label for="location">Location</label>
                                <select class="w-full" name="location" id="location" style="padding:10px 20px;">
                                    <option value="" <?php echo isset($_GET['location']) ? '' : 'selected'; ?>>
                                        - All -</option>
                                    <?php foreach ($localLists as $local) { ?>
                                        <option value="<?php echo $local['location_name'] ?>" <?php echo ($_GET['location'] ?? '') === $local['location_name'] ? 'selected' : ''; ?>>
                                            <?php echo $local['location_name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div style="padding-top:20px">
                                <button class="bg-primary text-white w-full">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="py-5">
                    <?php foreach ($packages as $package) : ?>
                        <div class="grid grid-cols-2 package-card">
                            <img class="thumbnail w-full" src="images/<?= $package['package_image'] ?>">

                            <div class="detail">
                                <div>
                                    <a href="/package-detail?id=<?= $package['package_id'] ?>">
                                        <h2><?= $package['package_name'] ?></h2>
                                    </a>

                                    <div class="py-5 flex">
                                        <div class="chip"><?= getPitchName($package['pitch_id'], $connect) ?></div>
                                        <div class="chip"><?= getLocName($package['location_id'], $connect) ?></div>
                                    </div>
                                </div>

                                <div>
                                    <p class="price"><?= $package['price'] ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>

        <footer class="social-footer items-center">
            <div class="social-footer-left">
                <a href="/contact-us" class="social-footer-left-text">Contact Info</a>
            </div>
            <div>
                <p class="text-center copyright">Availability<br>© 2023, MibO.<br>All Rights Reserved.</p>
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