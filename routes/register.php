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
    <link rel="icon" href="images/logo.png">
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
        <form action="/register" method="POST">
            <div class="pb-15">
                <label class="block">CustomerId</label>
                <input class="w-full" type="text" name="txtcid" value="<?php echo AutoID('gwsc_customer', 'customer_id', 'CUS', 4); ?>" readonly>
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
            <div class="pb-15">
                <input type="checkbox" name="" id="checkbox" required>
                <label for="checkbox" class="">Yes,I accept the terms and conditions.</label>
            </div>
            <div class="w-full">
                <input class="w-full font-bold bg-primary text-white mb-5" type="submit" name="btnregister" value="Register" required>
                <a href="/login">
                    <input class="w-full font-bold bg-secondary text-white" type="button" value="Cancel">
                </a>
                </input>
            </div>
        </form>
        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content rss-scroll">
                <div>
                    <h2 class="font-25">Terms and Conditions</h2>
                    <ul class="term-ul">
                        <li>
                            Booking and Reservation: Global Wild Swimming and Camping (GWSC) provides an online platform
                            for
                            users to book swimming sessions and camping pitches at their various sites. By using our
                            website
                            and making a reservation, customers agree to comply with our booking policies.
                        </li>
                        <li>
                            Content Usage: The content featured on GWSC's website, including images, text, and
                            interactive
                            elements, is licensed for re-use and is intended for informational purposes only. Any
                            unauthorized use or distribution of this content is strictly prohibited.
                        </li>
                        <li>
                            Accuracy of Information: GWSC makes every effort to ensure the accuracy of the information
                            provided on the website. However, we do not guarantee the completeness or accuracy of all
                            details regarding pitch types, availability, local attractions, and amenities. Users are
                            advised
                            to verify critical information before making any reservations.
                        </li>
                        <li>
                            Data Privacy: When using the contact form on the website, users may be required to provide
                            personal information. GWSC is committed to safeguarding user data and adheres to strict
                            privacy
                            policies. By submitting information through the contact form, users consent to the
                            collection
                            and processing of their data in accordance with our Privacy Policy.
                        </li>
                        <li>
                            User Responsibility: Users are responsible for ensuring that any information they provide on
                            the
                            website is accurate and up to date. Furthermore, users must adhere to all rules and
                            regulations
                            related to swimming, camping, and the use of facilities at GWSC sites.
                        </li>
                        <li>
                            Reviews and Feedback: GWSC provides a platform for users to post reviews about their
                            experiences
                            at different sites. While we encourage honest feedback, we reserve the right to moderate and
                            remove reviews that violate our content guidelines or contain inappropriate or offensive
                            content.
                        </li>
                        <li>
                            Intellectual Property: All intellectual property rights, including copyrights and
                            trademarks,
                            displayed on the website belong to GWSC. Users are prohibited from using, reproducing, or
                            modifying any of the intellectual property without prior written consent.
                        </li>
                        <li>
                            Limitation of Liability: GWSC shall not be held liable for any direct, indirect, or
                            consequential damages arising from the use of the website or the inability to access it.
                            This
                            includes, but is not limited to, loss of data, profits, or business opportunities.
                        </li>
                        <li>
                            Changes to Terms: GWSC reserves the right to modify these terms and conditions at any time
                            without prior notice. Users are encouraged to review this section regularly to stay informed
                            about any updates.
                        </li>
                        <li>
                            Governing Law: These terms and conditions shall be governed by and construed in accordance
                            with
                            the laws of [Your Country], and any disputes arising under or in connection with this
                            agreement
                            shall be subject to the exclusive jurisdiction of the courts of [Your Country].
                        </li>
                    </ul>
                </div>
                <button class="close" id="okBtn">
                    Ok
                </button>
            </div>

        </div>
    </div>
</body>
<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("checkbox");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    var okBtn = document.getElementById("okBtn");

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        if (btn.checked) {
            checkbox.checked = false;
            modal.style.display = "block";
            okBtn.addEventListener('click', function() {
                checkbox.checked = true;
            });
        } else {
            modal.style.display = "none";
        }
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</html>