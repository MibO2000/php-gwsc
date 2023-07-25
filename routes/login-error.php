<?php

if (!isset($_SESSION['login-error'])) {
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
    <style>
        p {
            text-align: center;
            font-size: 60px;
            margin-top: 0px;
        }
    </style>
</head>

<body>
    <div>

    </div>
    <div>

    </div>
    <p id="demo"></p>

    <script>
        // Set the date we're counting down to
        var countDownDate = new Date().getTime() + 10000;
        window.alert("di york");
        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

            // Time calculations for days, hours, minutes and seconds
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s ";

            // If the count down is over, write some text 
            if (distance < 0) {
                console.log("Hello");
                clearInterval(x);
                <?php
                session_destroy();
                header('Location: /login');
                return;
                ?>
            }
        }, 1000);
    </script>
</body>

</html>