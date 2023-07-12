<?php

if (!isset($_SESSION['aid'])) {
    header('Location: /admin-login');
    return;
}

if (isset($_SESSION['cid'])) {
    header('Location: /');
    return;
}

if (isset($_POST['btnsave'])) {
    $pid = $_POST['txtpid'];
    $pname = $_POST['txtpname'];
    $packType = $_POST['txtpactype'];
    $pitType = $_POST['txtpitchtype'];
    $location = $_POST['txtlocationtype'];
    $pduration = $_POST['txtpduration'];
    $pprice = $_POST['txtpprice'];
    $pdes1 = $_POST['txtpdescription1'];
    $pdes2 = $_POST['txtpdescription2'];

    $pimg1 = "images/" . $_FILES['image1']['name'];
    $imageType = pathinfo($pimg1, PATHINFO_EXTENSION);
    if ($imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'png') {
        $isError = true;
        $errorMessage = "Image Type is incorrect!";
    } else {
        $isSuccess = true;
        $image1 = uniqid() . "-" . $_FILES['image1']['name'];

        move_uploaded_file($_FILES['image1']['tmp_name'], "images/" . $image1);
    }

    $pimg2 = "images/" . $_FILES['image2']['name'];
    $imageType = pathinfo($pimg2, PATHINFO_EXTENSION);
    if ($imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'png') {
        $isError = true;
        $errorMessage = "Image Type is incorrect!";
    } else {
        $isSuccess = true;
        $image2 = uniqid() . "-" . $_FILES['image2']['name'];

        move_uploaded_file($_FILES['image2']['tmp_name'], "images/" . $image2);
    }

    $pdiscount = $_POST['txtpdiscount'];
    $pstatus = $_POST['txtpstatus'];

    $check = "SELECT * FROM ASSIGNMENT.PACKAGE WHERE PACKAGE_NAME = '$pname'";
    $count = mysqli_num_rows(mysqli_query($connect, $check));
    if ($count > 0) {
        echo "<script>window.alert('Pitch Already exists!')</script>";
    } else {
        $insert = "INSERT INTO ASSIGNMENT.PACKAGE(PACKAGE_ID, PACKAGE_NAME, PACKAGE_TYPE_ID, PITCH_TYPE_ID, LOCATION_ID, DURATION, PRICE, DESCRIPTION1, DESCRIPTION2, PICTURE1, PICTURE2, DISCOUNT, STATUS, VIEW_COUNT) 
        VALUES ('$pid','$pname', '$packType', '$pitType', '$location', '$pduration', '$pprice', '$pdes1', '$pdes2', '$image1', '$image2', '$pdiscount', '$pstatus', 0)";
        $run = mysqli_query($connect, $insert);
        if ($run) {
            echo "<script>window.alert('New Package Added!')</script>";
        } else {
            echo "<script>window.alert('Something went wrong!')</script>";
        }
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
</head>

<body>
    <div class="flex justify-between flex-col min-h-screen">
        <main>
            <div>
                <div class="nav">
                    <div class="logo">
                        <img src="images/logo.png" style="width:120px;">
                        <h1>GWSC Admin Portal</h1>
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
                        <th>DESCRIPTION1</th>
                        <th>DESCRIPTION2</th>
                        <th>PICTURE1</th>
                        <th>PICTURE2</th>
                        <th>DISCOUNT</th>
                        <th>STATUS</th>
                        <th>VIEW_COUNT</th>
                        <th>PACKAGE_TYPE</th>
                        <th>PITCH_TYPE</th>
                        <th>LOCATION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $query = "SELECT * FROM ASSIGNMENT.PACKAGE";
                    $result = mysqli_query($connect, $query);

                    // Loop through each row and display the data
                    while ($row = mysqli_fetch_assoc($result)) {
                        $pkid = $row['PACKAGE_TYPE_ID'];
                        $pkquery = "SELECT * FROM ASSIGNMENT.PACKAGE_TYPE WHERE PACKAGE_TYPE_ID = '$pkid'";
                        $pkresult = mysqli_query($connect, $pkquery);

                        $ptid = $row['PITCH_TYPE_ID'];
                        $ptquery = "SELECT * FROM ASSIGNMENT.PITCH WHERE PITCH_ID = '$ptid'";
                        $ptresult = mysqli_query($connect, $ptquery);
                        $lid = $row['LOCATION_ID'];
                        $lquery = "SELECT * FROM ASSIGNMENT.LOCATION WHERE LOCATION_ID = '$lid'";
                        $lresult = mysqli_query($connect, $lquery);

                        echo "<tr>";
                        echo "<td>" . $row['PACKAGE_ID'] . "</td>";
                        echo "<td>" . $row['PACKAGE_NAME'] . "</td>";
                        echo "<td>" . $row['DURATION'] . "</td>";
                        echo "<td>" . $row['PRICE'] . "</td>";
                        echo "<td>" . $row['DESCRIPTION1'] . "</td>";
                        echo "<td>" . $row['DESCRIPTION2'] . "</td>";
                        echo "<td>" . $row['PICTURE1'] . "</td>";
                        echo "<td>" . $row['PICTURE1'] . "</td>";
                        echo "<td>" . $row['DISCOUNT'] . "</td>";
                        echo "<td>" . $row['STATUS'] . "</td>";
                        echo "<td>" . $row['VIEW_COUNT'] . "</td>";
                        if ($pkresult && mysqli_num_rows($pkresult) > 0) {
                            $row = mysqli_fetch_assoc($pkresult);
                            $packageType = $row['PACKAGE_TYPE_NAME'];
                            echo "<td>" . $packageType . "</td>";
                        }

                        if ($ptresult && mysqli_num_rows($ptresult) > 0) {
                            $row = mysqli_fetch_assoc($ptresult);
                            $pitchType = $row['PITCH_NAME'];
                            echo "<td>" . $pitchType . "</td>";
                        }

                        if ($lresult && mysqli_num_rows($lresult) > 0) {
                            $row = mysqli_fetch_assoc($lresult);
                            $location = $row['LOCATION_NAME'];
                            echo "<td>" . $location . "</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>


            <h2>Add Package</h2>
            <div class="form-container">
                <form class="form-card justify-center items-center" action="/admin-package" method="POST"
                    enctype="multipart/form-data">
                    <div class="pb-15">
                        <label class="block">PACKAGE_ID</label>
                        <input class="w-full" type="text" name="txtpid"
                            value="<?php echo AutoID('PACKAGE', 'PACKAGE_ID', 'PACK', 4); ?>" readonly>
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
                                $pquery = "SELECT * FROM PACKAGE_TYPE";
                                $presult = mysqli_query($connect, $pquery);
                                while ($prow = mysqli_fetch_assoc($presult)) {
                                    echo "<option value=" . $prow['PACKAGE_TYPE_ID'] . ">" . $prow['PACKAGE_TYPE_NAME'] . "</option>";
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
                                $ptquery = "SELECT * FROM PITCH";
                                $ptresult = mysqli_query($connect, $ptquery);
                                while ($ptrow = mysqli_fetch_assoc($ptresult)) {
                                    echo "<option value=" . $ptrow['PITCH_ID'] . ">" . $ptrow['PITCH_NAME'] . "</option>";
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
                                $lquery = "SELECT * FROM ASSIGNMENT.LOCATION";
                                $lresult = mysqli_query($connect, $lquery);
                                while ($lrow = mysqli_fetch_assoc($lresult)) {
                                    echo "<option value=" . $lrow['LOCATION_ID'] . ">" . $lrow['LOCATION_NAME'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="pb-15">
                        <label class="block">Duration (hr)</label>
                        <input class="w-full" type="number" name="txtpduration" placeholder="Enter Package Duration"
                            required>

                    </div>
                    <div class="pb-15">
                        <label class="block">Package Price</label>
                        <input class="w-full" type="number" name="txtpprice" placeholder="Enter Package Price" required>
                    </div>
                    <div class="pb-15">
                        <label class="block">Description 1</label>
                        <input class="w-full" type="text" name="txtpdescription1"
                            placeholder="Enter Package Description 1" required>
                    </div>
                    <div class="pb-15">
                        <label class="block">Description 2</label>
                        <input class="w-full" type="text" name="txtpdescription2"
                            placeholder="Enter Package Description 2" required>
                    </div>
                    <div class="pb-15">
                        <label class="block">Package Image 1</label>
                        <input class="w-full" type="file" name="image1" placeholder="Enter Package Image 1" required>
                    </div>
                    <div class="pb-15">
                        <label class="block">Package Image 2</label>
                        <input class="w-full" type="file" name="image2" placeholder="Enter Package Image 2" required>
                    </div>
                    <div class="pb-15">
                        <label class="block">Package Discount</label>
                        <input class="w-full" type="number" name="txtpdiscount" placeholder="Enter Package Discount"
                            required>
                    </div>
                    <div class="pb-15">
                        <label class="block">Package Status</label>
                        <input class="w-full" type="text" name="txtpstatus" placeholder="Enter Package Status" required>
                    </div>

                    <!-- Dropdown List -->

                    <div class="w-full">
                        <input class="w-full font-bold bg-primary text-white mb-5" type="submit" name="btnsave"
                            value="Save">
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