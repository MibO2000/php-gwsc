<?php
class Config
{

    const GOOGLE_RECAPTCHA_SITE_KEY = '6LetQkgnAAAAAOzjV82vKe2NwCk3g2_UX6TaR7D-';

    const GOOGLE_RECAPTCHA_SECRET_KEY = '6LetQkgnAAAAAJYsCY7qH6fsCZON7F8qjLkFhjBG';
}
$isSuccess = false;
$isError = false;
$errorMessage;

if (isset($_SESSION['cid'])) {
    header('Location: /');
    return;
}
if (isset($_SESSION['login-error'])) {
    header('Location: /login-error');
    return;
}

if (isset($_SESSION['SUCCESS_REGISTER'])) {
    unset($_SESSION['SUCCESS_REGISTER']);
    // echo "<script>window.alert('Customer registered SUCCESSFULLY!')</script>";
    $isSuccess = true;
}

if (isset($_POST['btnlogin'])) {
    $txtemail = $_POST['txtcemail'];
    $txtpassword = $_POST['txtcpassword'];

    $check = "SELECT * FROM gwsc_customer WHERE email = '$txtemail'";
    $query = mysqli_query($connect, $check);
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        $data = mysqli_fetch_array($query);
        if (password_verify($txtpassword, $data['customer_password'])) {
            $txtpassword = $data['customer_password'];
            $update = "UPDATE gwsc_customer AS C SET C.view_count = C.view_count + 1 WHERE C.email = '$txtemail'";
            mysqli_query($connect, $update);
            $cid = $data['customer_id'];
            $cname = $data['first_name'];
            $_SESSION['cid'] = $cid;
            $_SESSION['cname'] = $cname;
            header('Location: /');
            // echo "<script>window.alert('Customer login SUCCESSFULLY!')</script>";
        } else {
            // echo "<script>window.alert('Fail to login!')</script>";
            $isError = true;
            $errorMessage = 'Fail to login!';
            if (isset($_SESSION['loginError'])) {
                $_SESSION['loginError'] = $countError = $_SESSION['loginError'] + 1;
                $isError = true;
                $errorMessage = "Login fail! Please try again. Attempt $countError!";
                if ($countError > 2) {
                    $_SESSION['login-error'] = true;
                    header('Location: /login-error');
                    return;
                }
            } else {
                $_SESSION['loginError'] = 1;
                $isError = true;
                $errorMessage = 'Login fail! Please try again. Attempt 1';
            }
        }
    } else {
        $isError = true;
        $errorMessage = 'Username does not exists!';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel and Tour</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="images/logo.png">
    <script src="https://www.google.com/recaptcha/api.js?render=<?= Config::GOOGLE_RECAPTCHA_SITE_KEY ?>">
    </script>
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
        <?php if ($isSuccess) { ?>
            <div class="alert alert-success">
                <p>Customer registered SUCCESSFULLY!</p>
            </div>
        <?php } ?>
        <?php if ($isError) { ?>
            <div class="alert alert-error">
                <p><?php echo $errorMessage; ?></p>
            </div>
        <?php } ?>
        <form action="/login" method="POST">
            <div class="pb-15">
                <label class="block">Email</label>
                <input class="w-full" type="email" name="txtcemail" placeholder="Enter valid email" value="<?php echo $_POST['txtcemail'] ?? ''; ?>" required>
            </div>
            <div class="pb-15">
                <label class="block">Password</label>
                <input class="w-full" type="password" name="txtcpassword" placeholder="Enter your password" required>
            </div>
            <div class="w-full pb-5">
                <input class="w-full font-bold bg-primary text-white" type="submit" name="btnlogin" value="Log In">
            </div>
        </form>
        <a href="/register">
            <button class="w-full font-bold bg-info" type="button">Register</button>
        </a>
    </div>
</body>

</html>