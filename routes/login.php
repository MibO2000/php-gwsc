<?php
class Config
{
    const g_key = '6Lej21MnAAAAABjQmUnRc7bmtbXM8hwUPfJUINcd';
    const g_secret = '6Lej21MnAAAAACZ0Px5vabNX3bnsdNnXFkKtuQQy';
}
$isSuccess = false;
$isError = false;
$errorMessage;

if (isset($_SESSION['cid'])) {
    header('Location: /');
    return;
}
if ($_SESSION['loginError'] > 2) {
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

    // reCAPTCHA validation
    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

        // reCAPTCHA response verification
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . Config::g_secret . '&response=' . $_POST['g-recaptcha-response']);

        // Decode JSON data
        $response = json_decode($verifyResponse);
        if ($response->success) {
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
                    unset($_SESSION['loginError']);
                    header('Location: /');
                    // echo "<script>window.alert('Customer login SUCCESSFULLY!')</script>";
                } else {
                    // echo "<script>window.alert('Fail to login!')</script>";
                    $isError = true;
                    $errorMessage = 'Fail to login!';

                    if (isset($_SESSION['loginError'])) {
                        $_SESSION['loginError']++;
                        echo $_SESSION['loginError'];
                        // $isError = true;
                        $errorMessage = "Login fail! Please try again. Attempt " . $_SESSION['loginError'];
                        if ($_SESSION['loginError'] > 2) {
                            // $_SESSION['loginError'] = 3;
                            header('Location: /login-error');
                            // return;
                        }
                    } else {
                        $_SESSION['loginError'] = 1;
                        // $isError = true;
                        $errorMessage = 'Login fail! Please try again. Attempt 1';
                    }
                }
            } else {
                $isError = true;
                $errorMessage = 'Username does not exists!';
            }
        } else {
            $isError = true;
            $errorMessage = 'Robot verification failed, please try again.';
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
    <title>Travel and Tour</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="images/logo.png">
    </script>
</head>

<body class="min-h-screen min-w-screen flex justify-center items-center bg-gray login-screen">
    <!-- The video -->
    <video autoplay muted loop class="login-video">
        <source src="videos/ads.mp4" type="video/mp4">
    </video>
    <div class="login-card">
        <div class="flex flex-col justify-center items-center text-center pb-5">
            <img src="images/logo.png" class="login-img">
            <h2 class="login-title">Global Wildlife Swimming & Camping</h2>
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
            <!-- Add hCaptcha CAPTCHA box -->
            <div class="g-recaptcha" data-sitekey="<?= Config::g_key ?>"></div>
            <div class="w-full pb-5">
                <input class="w-full font-bold bg-primary text-white" type="submit" name="btnlogin" value="Log In">
            </div>
        </form>
        <a href="/register">
            <button class="w-full font-bold bg-info" type="button">Register</button>
        </a>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>
<script>

</script>