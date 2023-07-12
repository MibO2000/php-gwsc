<?php

if (isset($_SESSION['cid'])) {
    header('Location: /');
    return;
}

if (isset($_SESSION['aid'])) {
    header('Location: /admin-pitch');
    return;
}

if (isset($_POST['btnregister'])) {
    $id = $_POST['txtid'];
    $txtname = $_POST['txtname'];
    $txtemail = $_POST['txtemail'];
    $txtpassword = password_hash($_POST['txtpassword'], PASSWORD_BCRYPT);
    $txtphone = $_POST['txtphone'];
    $txtaddress = $_POST['txtcaddress'];
    $checkemail = "SELECT * FROM ASSIGNMENT.ADMIN WHERE EMAIL = '$txtemail'";
    $result = mysqli_query($connect, $checkemail);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        echo "<script>window.alert('Admin Email Already exists!')</script>";
    } else {
        $insert = "INSERT INTO ASSIGNMENT.ADMIN (ADMIN_ID, NAME, EMAIL, PASSWORD, PHONE, ADDRESS) 
    VALUES ('$id','$txtname','$txtemail','$txtpassword','$txtphone','$txtaddress')";
        $run = mysqli_query($connect, $insert);
        if ($run) {
            $_SESSION['SUCCESS_REGISTER'] = true;
            header('Location: /admin-login');
        } else {
            echo "<script>window.alert('Something went wrong while registering admin!')</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel & Tour</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="min-h-screen min-w-screen flex justify-center items-center bg-gray login-screen">
    <!-- The video -->
    <video autoplay muted loop style="position: fixed;right: 0;bottom: 0;min-width: 100%;min-height: 100%;">
        <source src="videos/ads.mp4" type="video/mp4">
    </video>
    <div class="login-card">
        <div class="flex flex-col justify-center items-center text-center pb-5">
            <img src="images/logo.png" style="width:120px;padding:30px 5px">
            <h2 style="font-size:20px;font-weight:bold;">GWSC Admin Portal</h2>
        </div>
        <form action="/admin-register" method="POST">
            <div class="pb-15">
                <label class="block">AdminId</label>
                <input class="w-full" type="text" name="txtcid" value="<?php echo AutoID('ADMIN', 'ADMIN_ID', 'ADM', 4); ?>" readonly>
            </div>
            <div class="pb-15">
                <label class="block">Admin Name</label>
                <input class="w-full" type="text" name="txtname" placeholder="Enter Admin name" required>

            </div>
            <div class="pb-15">
                <label class="block">Admin Email</label>
                <input class="w-full" type="email" name="txtemail" placeholder="Enter valid admin email" required>

            </div>
            <div class="pb-15">
                <label class="block">Admin Password</label>
                <input class="w-full" type="password" name="txtpassword" placeholder="Enter admin password" required>
            </div>
            <div class="pb-15">
                <label class="block">Admin Phone</label>
                <input class="w-full" type="text" name="txtphone" placeholder="Enter admin phone" required>
            </div>
            <div class="pb-15">
                <label class="block">Admin Address</label>
                <input class="w-full" type="text" name="txtcaddress" placeholder="Enter customer address" required>
                <br>
            </div>
            <div class="w-full">
                <input class="w-full font-bold bg-primary text-white mb-5" type="submit" name="btnregister" value="Register">
                <a href="/admin-login">
                    <input class="w-full font-bold bg-secondary text-white" type="button" value="Cancel">
                </a>
            </div>
        </form>
    </div>
</body>

</html>