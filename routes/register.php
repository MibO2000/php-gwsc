<?php

if (isset($_SESSION['cid'])) {
    header('Location: /');
    return;
}

if (isset($_POST['btnregister'])) {
    $cid = $_POST['txtcid'];
    $txtfname = $_POST['txtcfname'];
    $txtsname = $_POST['txtcsname'];
    $txtemail = $_POST['txtcemail'];
    $txtpassword = password_hash($_POST['txtcpassword'], PASSWORD_BCRYPT);
    $txtphone = $_POST['txtcphone'];
    $txtaddress = $_POST['txtcaddress'];
    $checkemail = "SELECT * FROM gwsc_customer WHERE email = '$txtemail'";
    $result = mysqli_query($connect, $checkemail);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        echo "<script>window.alert('Staff Email Already exists!')</script>";
    } else {
        $insert = "INSERT INTO gwsc_customer(customer_id,first_name,surname,email,customer_password,phone,customer_address,view_count) 
    VALUES ('$cid','$txtfname','$txtsname','$txtemail','$txtpassword','$txtphone','$txtaddress',1)";
        $run = mysqli_query($connect, $insert);
        if ($run) {
            // echo "<script>window.alert('Customer registered SUCCESSFULLY!')</script>";
            // echo "<script>window.location='customerRegister.php'</script>";
            $_SESSION['SUCCESS_REGISTER'] = true;
            header('Location: /login');
        } else {
            echo "<script>window.alert('Something went wrong while registering customer!')</script>";
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
            <h2 style="font-size:20px;font-weight:bold;">Global Wildlife Swimming & Camping</h2>
        </div>
        <form action="/register" method="POST">
            <div class="pb-15">
                <label class="block">CustomerId</label>
                <input class="w-full" type="text" name="txtcid" value="<?php echo AutoID('CUSTOMER', 'CUSTOMER_ID', 'CUS', 4); ?>" readonly>
            </div>
            <div class="pb-15">
                <label class="block">CustomerFirstName</label>
                <input class="w-full" type="text" name="txtcfname" placeholder="Enter customer first name" required>

            </div>
            <div class="pb-15">
                <label class="block">CustomerSurname</label>
                <input class="w-full" type="text" name="txtcsname" placeholder="Enter customer surname" required>
            </div>
            <div class="pb-15">
                <label class="block">CustomerEmail</label>
                <input class="w-full" type="email" name="txtcemail" placeholder="Enter valid customer email" required>

            </div>
            <div class="pb-15">
                <label class="block">CustomerPassword</label>
                <input class="w-full" type="password" name="txtcpassword" placeholder="Enter customer password" required>
            </div>
            <div class="pb-15">
                <label class="block">CustomerPhone</label>
                <input class="w-full" type="text" name="txtcphone" placeholder="Enter customer phone" required>
            </div>
            <div class="pb-15">
                <label class="block">CustomerAddress</label>
                <input class="w-full" type="text" name="txtcaddress" placeholder="Enter customer address" required>
                <br>
            </div>
            <div class="w-full">
                <input class="w-full font-bold bg-primary text-white mb-5" type="submit" name="btnregister" value="Register">
                <a href="/login">
                    <input class="w-full font-bold bg-secondary text-white" type="button" value="Cancel">
                </a>
                </input>
            </div>
        </form>
    </div>
</body>

</html>