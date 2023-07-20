<?php

$isSuccess = false;
$isError = false;
$errorMessage;
if (!isset($_SESSION['aid'])) {
    header('Location: /admin-login');
    return;
}

if (isset($_SESSION['cid'])) {
    header('Location: /');
    return;
}

if (isset($_SESSION['SUCCESS_REGISTER'])) {
    unset($_SESSION['SUCCESS_REGISTER']);
    $isSuccess = true;
}

if (isset($_POST['btnsave'])) {
    $pid = $_POST['txtpid'];
    $pname = $_POST['txtpname'];
    $packType = $_POST['txtpactype'];
    $pitch = $_POST['txtpitchtype'];
    $location = $_POST['txtlocationtype'];
    $pduration = $_POST['txtpduration'];
    $pprice = $_POST['txtpprice'];
    $pdes = $_POST['txtpdescription'];

    $pimg = "images/" . $_FILES['image']['name'];
    $imageType = pathinfo($pimg, PATHINFO_EXTENSION);
    if ($imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'png') {
        $isError = true;
        $errorMessage = "Image Type is incorrect!";
    } else {
        $isSuccess = true;
        $image = uniqid() . "-" . $_FILES['image']['name'];

        move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $image);
    }

    $pdiscount = $_POST['txtpdiscount'];

    $check = "SELECT * FROM gwsc_package WHERE package_name = '$pname'";
    $count = mysqli_num_rows(mysqli_query($connect, $check));
    if ($count > 0) {
        echo "<script>window.alert('Pitch Already exists!')</script>";
    } else {
        $insert = "INSERT INTO gwsc_package (package_id, package_name, package_type_id, pitch_id, location_id, duration, price, pitch_description, package_image, discount) 
        VALUES ('$pid','$pname', '$packType', '$pitch', '$location', '$pduration', '$pprice', '$pdes', '$image', '$pdiscount')";
        $run = mysqli_query($connect, $insert);
        if ($run) {
            $_SESSION['SUCCESS_REGISTER'] = true;
        } else {
            $_SESSION['FAIL'] = true;
            $_SESSION['error'] = "Fail to add a new package";
        }
        header('Location: /admin-package');
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADM-Package</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="images/logo.png">
</head>

<body>
    <div class="flex justify-between flex-col min-h-screen">
        <main>
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
            <div>
                <div class="nav">
                    <div class="logo">
                        <img src="images/logo.png" style="width:120px;">
                        <h1>GWSC Admin Portal</h1>
                    </div>

                    <div class="flex">
                        <div class="flex items-center cursor-pointer" id="profile-bar" onmouseenter="toggleProfileMenu()">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="padding-left:20px;height:50px;width:50px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p style="padding-left:7px"><?php echo $_SESSION['aname']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="nav-bar">
                    <a href="/admin-pitch">Pitch</a>
                    <a href="/admin-pitch-type">Pitch Type</a>
                    <a class="active" href="/admin-package">Package</a>
                    <a href="/admin-package-type">Package Type</a>
                    <a href="/admin-local">Local Attraction</a>
                    <a href="/admin-location-type">Location Type</a>
                </div>
            </div>

            <div id="myDropdown2" class="dropdown-content" style="top:72px;right:25px;">
                <a href="/logout">Log Out</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>PACKAGE_ID</th>
                        <th>PACKAGE_NAME</th>
                        <th>DURATION</th>
                        <th>PRICE</th>
                        <th>DESCRIPTION</th>
                        <th>PICTURE</th>
                        <th>DISCOUNT</th>
                        <th>PACKAGE_TYPE</th>
                        <th>PITCH</th>
                        <th>LOCATION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $query = "SELECT * FROM gwsc_package";
                    $result = mysqli_query($connect, $query);

                    // Loop through each row and display the data
                    while ($row = mysqli_fetch_assoc($result)) {
                        $pkid = $row['package_type_id'];
                        $pkquery = "SELECT * FROM gwsc_package_type WHERE package_type_id = '$pkid'";
                        $pkresult = mysqli_query($connect, $pkquery);

                        $ptid = $row['pitch_id'];
                        $ptquery = "SELECT * FROM gwsc_pitch WHERE pitch_id = '$ptid'";
                        $ptresult = mysqli_query($connect, $ptquery);
                        $lid = $row['location_id'];
                        $lquery = "SELECT * FROM gwsc_location WHERE location_id = '$lid'";
                        $lresult = mysqli_query($connect, $lquery);

                        echo "<tr>";
                        echo "<td>" . $row['package_id'] . "</td>";
                        echo "<td>" . $row['package_name'] . "</td>";
                        echo "<td>" . $row['duration'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td>" . $row['pitch_description'] . "</td>";
                        echo "<td>" . $row['package_image'] . "</td>";
                        echo "<td>" . $row['discount'] . "</td>";
                        if ($pkresult && mysqli_num_rows($pkresult) > 0) {
                            $row = mysqli_fetch_assoc($pkresult);
                            $packageType = $row['package_type_name'];
                            echo "<td>" . $packageType . "</td>";
                        }

                        if ($ptresult && mysqli_num_rows($ptresult) > 0) {
                            $row = mysqli_fetch_assoc($ptresult);
                            $pitchType = $row['pitch_name'];
                            echo "<td>" . $pitchType . "</td>";
                        }

                        if ($lresult && mysqli_num_rows($lresult) > 0) {
                            $row = mysqli_fetch_assoc($lresult);
                            $location = $row['location_name'];
                            echo "<td>" . $location . "</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>


            <h2>Add Package</h2>
            <div class="form-container">
                <form class="form-card justify-center items-center" action="/admin-package" method="POST" enctype="multipart/form-data">
                    <div class="pb-15">
                        <label class="block">PACKAGE_ID</label>
                        <input class="w-full" type="text" name="txtpid" value="<?php echo AutoID('gwsc_package', 'package_id', 'PACK', 4); ?>" readonly>
                    </div>
                    <div class="pb-15">
                        <label class="block">PACKAGE_NAME</label>
                        <input class="w-full" type="text" name="txtpname" placeholder="Enter Pitch name" required>
                    </div>
                    <div class="pb-15">
                        <label class="block">Package Type</label>
                        <div class="w-full">
                            <select name="txtpactype" id="txtpactype">
                                <!-- <option value="">Select an option</option> -->
                                <?php
                                $pquery = "SELECT * FROM gwsc_package_type";
                                $presult = mysqli_query($connect, $pquery);
                                while ($prow = mysqli_fetch_assoc($presult)) {
                                    echo "<option value=" . $prow['package_type_id'] . ">" . $prow['package_type_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="pb-15">
                        <label class="block">Pitch</label>
                        <div class="w-full">
                            <select name="txtpitchtype" id="txtpitchtype">
                                <!-- <option value="">Select an option</option> -->
                                <?php
                                $ptquery = "SELECT * FROM gwsc_pitch";
                                $ptresult = mysqli_query($connect, $ptquery);
                                while ($ptrow = mysqli_fetch_assoc($ptresult)) {
                                    echo "<option value=" . $ptrow['pitch_id'] . ">" . $ptrow['pitch_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="pb-15">
                        <label class="block">Location</label>
                        <div class="w-full">
                            <select name="txtlocationtype" id="txtlocationtype">
                                <!-- <option value="">Select an option</option> -->
                                <?php
                                $lquery = "SELECT * FROM gwsc_location";
                                $lresult = mysqli_query($connect, $lquery);
                                while ($lrow = mysqli_fetch_assoc($lresult)) {
                                    echo "<option value=" . $lrow['location_id'] . ">" . $lrow['location_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="pb-15">
                        <label class="block">Duration (hr)</label>
                        <input class="w-full" type="number" name="txtpduration" placeholder="Enter Package Duration" required>

                    </div>
                    <div class="pb-15">
                        <label class="block">Package Price</label>
                        <input class="w-full" type="number" name="txtpprice" placeholder="Enter Package Price" required>
                    </div>
                    <div class="pb-15">
                        <label class="block">Description</label>
                        <input class="w-full" type="text" name="txtpdescription" placeholder="Enter Package Description 1" required>
                    </div>
                    <div class="pb-15">
                        <label class="block">Package Image</label>
                        <input class="w-full" type="file" name="image" placeholder="Enter Package Image 1" required>
                    </div>
                    <div class="pb-15">
                        <label class="block">Package Discount</label>
                        <input class="w-full" type="number" name="txtpdiscount" placeholder="Enter Package Discount" required>
                    </div>

                    <!-- Dropdown List -->

                    <div class="w-full">
                        <input class="w-full font-bold bg-primary text-white mb-5" type="submit" name="btnsave" value="Save">
                        <a href="/admin-package">
                            <input class="w-full font-bold bg-secondary text-white" type="button" value="Cancel">
                        </a>
                    </div>
                </form>
            </div>
        </main>

        <footer class="social-footer items-center">
            <div class="social-footer-left">
                <p class="social-footer-left-text">Package</p>
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