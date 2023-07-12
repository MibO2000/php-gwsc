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
    $lid = $_POST['txtlid'];
    $ltype = $_POST['txtltype'];
    $lname = $_POST['txtlname'];
    $lfull = $_POST['txtlfulllocation'];
    $limg = "images/" . $_FILES['image']['name'];
    $imageType = pathinfo($limg, PATHINFO_EXTENSION);
    if ($imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'png') {
        $isError = true;
        $errorMessage = "Image Type is incorrect!";
    } else {
        $isSuccess = true;
        $image = uniqid() . "-" . $_FILES['image']['name'];

        move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $image);
    }
    $ldes = $_POST['txtldescription'];
    echo $lid, $ltype, $lname, $lfull, $image, $ldes;
    $check = "SELECT * FROM ASSIGNMENT.LOCATION WHERE LOCATION_NAME = '$lname'";
    $count = mysqli_num_rows(mysqli_query($connect, $check));
    if ($count > 0) {
        echo "<script>window.alert('Location Already exists!')</script>";
    } else {
        $insert = "INSERT INTO ASSIGNMENT.LOCATION(LOCATION_ID, LOCATION_TYPE_ID, LOCATION_NAME, FULL_LOCATION, PICTURE, DESCRIPTION)
        VALUES ('$lid','$ltype', '$lname', '$lfull', '$image', '$ldes')";
        $run = mysqli_query($connect, $insert);
        if ($run) {
            echo "<script>window.alert('New Location Added!')</script>";
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
    <title>ADM-Local-Attraction</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <div class="flex justify-center flex-col min-h-screen">
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
                    <a href="/admin-package">Package</a>
                    <a href="/admin-package-type">Package Type</a>
                    <a class="active" href="/admin-local">Local Attraction</a>
                    <a href="/admin-location-type">Location Type</a>
                </div>
            </div>

            <div id="myDropdown2" class="dropdown-content" style="top:72px;right:25px;">
                <a href="/logout">Log Out</a>
            </div>


            <table>
                <thead>
                    <tr>
                        <th>LOCATION_ID</th>
                        <th>LOCATION_NAME</th>
                        <th>FULL_LOCATION</th>
                        <th>PICTURE</th>
                        <th>DESCRIPTION</th>
                        <th>LOCATION_TYPE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $query = "SELECT * FROM ASSIGNMENT.LOCATION";
                    $result = mysqli_query($connect, $query);

                    // Loop through each row and display the data
                    while ($row = mysqli_fetch_assoc($result)) {
                        $ltid = $row['LOCATION_TYPE_ID'];
                        $ltquery = "SELECT * FROM LOCATION_TYPE WHERE LOCATION_TYPE_ID = '$ltid'";
                        $locationTypeResult = mysqli_query($connect, $ltquery);
                        echo "<tr>";
                        echo "<td>" . $row['LOCATION_ID'] . "</td>";
                        echo "<td>" . $row['LOCATION_NAME'] . "</td>";
                        echo "<td>" . $row['FULL_LOCATION'] . "</td>";
                        echo "<td>" . $row['PICTURE'] . "</td>";
                        echo "<td>" . $row['DESCRIPTION'] . "</td>";
                        if ($locationTypeResult && mysqli_num_rows($locationTypeResult) > 0) {
                            $row = mysqli_fetch_assoc($locationTypeResult);
                            $locationType = $row['LOCATION_TYPE_NAME'];
                            echo "<td>" . $locationType . "</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>


            <h2>Add Local Attraction</h2>

            <div class="form-container">
                <form class="form-card justify-center items-center" action="/admin-local" method="POST"
                    enctype="multipart/form-data">
                    <div class="pb-15">
                        <label class="block">Location Id</label>
                        <input class="w-full" type="text" name="txtlid"
                            value="<?php echo AutoID('LOCATION', 'LOCATION_ID', 'LOCAL', 4); ?>" readonly>
                    </div>

                    <div class="pb-15">
                        <label class="block">Location Type</label>
                        <div class="w-full">
                            <select name="txtltype" id="txtltype">
                                <!-- <option value="">Select an option</option> -->
                                <?php
                                $ltquery = "SELECT * FROM LOCATION_TYPE";
                                $ltresult = mysqli_query($connect, $ltquery);
                                while ($ltrow = mysqli_fetch_assoc($ltresult)) {
                                    echo "<option value=" . $ltrow['LOCATION_TYPE_ID'] . ">" . $ltrow['LOCATION_TYPE_NAME'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- Dropdown List -->
                    <div class="pb-15">
                        <label class="block">Location Name</label>
                        <input class="w-full" type="text" name="txtlname" placeholder="Enter Location name" required>

                    </div>
                    <div class="pb-15">
                        <label class="block">Full Location</label>
                        <input class="w-full" type="text" name="txtlfulllocation" placeholder="Enter Full Location"
                            required>

                    </div>
                    <div class="pb-15">
                        <label class="block">Location Image</label>
                        <input class="w-full" type="file" name="image" placeholder="Enter Location Image" required>
                    </div>
                    <div class="pb-15">
                        <label class="block">Description</label>
                        <input class="w-full" type="text" name="txtldescription"
                            placeholder="Enter Location Description" required>
                    </div>

                    <div class="w-full">
                        <input class="w-full font-bold bg-primary text-white mb-5" type="submit" name="btnsave"
                            value="Save">
                        <a href="/admin-local">
                            <input class="w-full font-bold bg-secondary text-white" type="button" value="Cancel">
                        </a>
                    </div>
                </form>
            </div>


        </main>

        <footer class="social-footer items-center">
            <div class="social-footer-left">
                <p class="social-footer-left-text">Local Attractions</p>
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