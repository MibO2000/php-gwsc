<?php

if (!isset($_SESSION['loginError'])) {
    header('Location: /login');
    return;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel and Tour - Login Error</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="images/logo.png">
    </script>
</head>

<body>
    <div class="h-screen flex items-center justify-center">
        <div class="flex items-center justify-between flex-col flex-column loginError-container loginError-padding">
            <img src="images/error-logo.png" class="w-50">
            <p>
                You cannot login. Please try again in
                <span id="demo" class="loginError-sec"></span>
            </p>
        </div>
    </div>
    <form id="clearSessionForm" action="/logout" method="post">
        <!-- You can add any additional hidden inputs if needed -->
    </form>
    <script>
        var countDownDate = new Date().getTime() + 600000;
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s";
            if (distance < 0) {
                clearInterval(x);
                // Submit the form to clear the session variable
                document.getElementById("clearSessionForm").submit();
            }
        }, 1000);
    </script>
</body>

</html>