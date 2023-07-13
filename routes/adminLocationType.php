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
if (isset($_SESSION['FAIL'])) {
    unset($_SESSION['FAIL']);
    $isError = true;
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']);
}

if (isset($_POST['btnsave'])) {
    $ptid = $_POST['txtptid'];
    $ptname = $_POST['txtptname'];
    $ptdes = $_POST['txtptdes'];
    $check = "SELECT * FROM gwsc_location_type WHERE location_type_name = '$ptname'";
    $count = mysqli_num_rows(mysqli_query($connect, $check));
    if ($count > 0) {
        echo "<script>window.alert('Location Type Already exists!')</script>";
    } else {
        $insert = "INSERT INTO gwsc_location_type (location_type_id, location_type_name, location_description)
        VALUES ('$ptid','$ptname', '$ptdes')";
        $run = mysqli_query($connect, $insert);
        if ($run) {
            $_SESSION['SUCCESS_REGISTER'] = true;
        } else {
            $_SESSION['FAIL'] = true;
            $_SESSION['error'] = "Fail to add a new location type";
        }
        header('Location: /admin-location-type');
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADM-Location-Type</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <div class="flex justify-between flex-col min-h-screen">
        <main>
            <?php if ($isSuccess) { ?>
                <div class="alert alert-success">
                    <p>Local Attraction added SUCCESSFULLY!</p>
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
                    <a href="/admin-package">Package</a>
                    <a href="/admin-package-type">Package Type</a>
                    <a href="/admin-local">Local Attraction</a>
                    <a class="active" href="/admin-location-type">Location Type</a>
                </div>
            </div>

            <div id="myDropdown2" class="dropdown-content" style="top:72px;right:25px;">
                <a href="/logout">Log Out</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>LOCATION_TYPE_ID</th>
                        <th>LOCATION_TYPE_NAME</th>
                        <th>LOCATION_TYPE_DESCRIPTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $query = "SELECT * FROM gwsc_location_type";
                    $result = mysqli_query($connect, $query);

                    // Loop through each row and display the data
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['location_type_id'] . "</td>";
                        echo "<td>" . $row['location_type_name'] . "</td>";
                        echo "<td>" . $row['location_description'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>


            <h2>Add Location Type</h2>
            <div class="flex form-container justify-center items-center">
                <form class="form-card" action="/admin-location-type" method="POST">
                    <div>
                        <div class="pb-15">
                            <label class="block">Location Type Id</label>
                            <input class="w-full" type="text" name="txtptid" value="<?php echo AutoID('gwsc_location_type', 'location_type_id', 'locty', 4); ?>" readonly>
                        </div>
                        <div class="pb-15">
                            <label class="block">Package Type Name</label>
                            <input class="w-full" type="text" name="txtptname" placeholder="Enter Location Type name" required>
                        </div>
                        <div class="pb-15">
                            <label class="block">Package Type Description</label>
                            <input class="w-full" type="text" name="txtptdes" placeholder="Enter Location Type Description" required>
                        </div>

                        <div class="w-full">
                            <input class="w-full font-bold bg-primary text-white mb-5" type="submit" name="btnsave" value="Save">
                            <a href="/admin-location-type">
                                <input class="w-full font-bold bg-secondary text-white" type="button" value="Cancel">
                            </a>
                        </div>
                    </div>
                </form>
            </div>

        </main>

        <footer class="social-footer items-center">
            <div class="social-footer-left">
                <p class="social-footer-left-text">Location Type</p>
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