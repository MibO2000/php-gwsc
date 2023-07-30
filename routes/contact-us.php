<?php

if (!isset($_SESSION['cid'])) {
    header('Location: /login');
    return;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="images/logo.png">
</head>

<body>
    <div class="flex justify-between flex-col min-h-screen">
        <main>
            <?php include('mobilemenu.php') ?>
            <div>
                <div class="nav">
                    <div class="logo">
                        <img src="images/logo.png" class="logoimg-width">
                        <h1>Global Wild Swimming & Camping</h1>
                    </div>

                    <div class="flex disappear">
                        <div class="flex items-center cursor-pointer" id="profile-bar" onmouseenter="toggleProfileMenu()">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="profile-logo">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="pl-7"><?php echo $_SESSION['cname']; ?></p>
                        </div>
                        <a class="flex items-center cursor-pointer" href="/cart">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="profile-logo">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="nav-bar disappear">
                    <a href="/">Home</a>
                    <a href="/about-us">Information</a>
                    <a href="/pitch">Pitch Types</a>
                    <a href="/features">Features</a>
                    <a href="/local-attraction">Local Attraction</a>
                    <a href="/packages">Availability</a>
                    <a href="/reviews">Reviews</a>
                </div>
            </div>

            <div id="myDropdown2" class="dropdown-content logout">
                <a href="/logout">Log Out</a>
            </div>
            <div class="container mx-auto">
                <div class="py-5">
                    <h2 class="heading-style">Contact Us</h2>
                </div>
                <div class="py-5">
                    <p>Interested? If you want our daily offers and news, subscribe to our mail. Submit your mail
                        address
                        here
                        and we will stay in touch with you with our special offers.
                    </p>
                    <p>
                        In the meantime, stay in touch through our various social media channels, or keep shopping at
                        our
                        <a href="/" class="mainpage">main page</a>!
                    </p>
                </div>
                <div class="grid sm-grid-cols-2 gap-5">
                    <form id="submit-form">
                        <div>
                            <div class="form-field w-half">
                                <label for="name">Name</label>
                                <input class="" id="name" type="text">
                            </div>

                            <div class="form-field w-half">
                                <label for="email">Email Address</label>
                                <input class="" id="email" type="email">
                            </div>

                            <div class="form-field w-half">
                                <label for="address">Address</label>
                                <input class="" id="address" type="text">
                            </div>

                            <div class="form-field w-half">
                                <label for="tel">Phone Number</label>
                                <input class="" id="tel" type="tel">
                            </div>
                            <a id="privacyBtn" href="#">Privacy Policy</a>
                        </div>
                        <!-- The Modal -->
                        <div id="privacyModal" class="modal">

                            <!-- Modal content -->
                            <div class="modal-content rss-scroll">
                                <div>
                                    <h2 class="font-25">Terms and Conditions</h2>
                                    <ul class="term-ul">
                                        <li>
                                            Booking and Reservation: Global Wild Swimming and Camping (GWSC) provides an
                                            online platform
                                            for
                                            users to book swimming sessions and camping pitches at their various sites.
                                            By using our
                                            website
                                            and making a reservation, customers agree to comply with our booking
                                            policies.
                                        </li>
                                        <li>
                                            Content Usage: The content featured on GWSC's website, including images,
                                            text, and
                                            interactive
                                            elements, is licensed for re-use and is intended for informational purposes
                                            only. Any
                                            unauthorized use or distribution of this content is strictly prohibited.
                                        </li>
                                        <li>
                                            Accuracy of Information: GWSC makes every effort to ensure the accuracy of
                                            the information
                                            provided on the website. However, we do not guarantee the completeness or
                                            accuracy of all
                                            details regarding pitch types, availability, local attractions, and
                                            amenities. Users are
                                            advised
                                            to verify critical information before making any reservations.
                                        </li>
                                        <li>
                                            Data Privacy: When using the contact form on the website, users may be
                                            required to provide
                                            personal information. GWSC is committed to safeguarding user data and
                                            adheres to strict
                                            privacy
                                            policies. By submitting information through the contact form, users consent
                                            to the
                                            collection
                                            and processing of their data in accordance with our Privacy Policy.
                                        </li>
                                        <li>
                                            User Responsibility: Users are responsible for ensuring that any information
                                            they provide on
                                            the
                                            website is accurate and up to date. Furthermore, users must adhere to all
                                            rules and
                                            regulations
                                            related to swimming, camping, and the use of facilities at GWSC sites.
                                        </li>
                                        <li>
                                            Reviews and Feedback: GWSC provides a platform for users to post reviews
                                            about their
                                            experiences
                                            at different sites. While we encourage honest feedback, we reserve the right
                                            to moderate and
                                            remove reviews that violate our content guidelines or contain inappropriate
                                            or offensive
                                            content.
                                        </li>
                                        <li>
                                            Intellectual Property: All intellectual property rights, including
                                            copyrights and
                                            trademarks,
                                            displayed on the website belong to GWSC. Users are prohibited from using,
                                            reproducing, or
                                            modifying any of the intellectual property without prior written consent.
                                        </li>
                                        <li>
                                            Limitation of Liability: GWSC shall not be held liable for any direct,
                                            indirect, or
                                            consequential damages arising from the use of the website or the inability
                                            to access it.
                                            This
                                            includes, but is not limited to, loss of data, profits, or business
                                            opportunities.
                                        </li>
                                        <li>
                                            Changes to Terms: GWSC reserves the right to modify these terms and
                                            conditions at any time
                                            without prior notice. Users are encouraged to review this section regularly
                                            to stay informed
                                            about any updates.
                                        </li>
                                        <li>
                                            Governing Law: These terms and conditions shall be governed by and construed
                                            in accordance
                                            with
                                            the laws of [Your Country], and any disputes arising under or in connection
                                            with this
                                            agreement
                                            shall be subject to the exclusive jurisdiction of the courts of [Your
                                            Country].
                                        </li>
                                    </ul>
                                </div>
                                <button class="close" id="closePrivacyBtn">
                                    Close
                                </button>
                            </div>

                        </div>
                        <div class="py-5">
                            <button class="submit-button">
                                Subscribe
                            </button>
                            <button class="submit-button">
                                Cancel
                            </button>
                        </div>
                    </form>
                    <div class="p-5">
                        <img src="./images/contact-us.png" class="w-half" alt="castle">
                    </div>
                </div>
            </div>

    </div>
    </main>

    <footer class="social-footer items-center">
        <div class="social-footer-left">
            <a href="/contact-us" class="social-footer-left-text">Contact Info</a>
        </div>
        <div>
            <p class="text-center copyright">Contact Us<br>© 2023, MibO.<br>All Rights Reserved.</p>
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

        // Get the privacy policy modal
        var privacyModal = document.getElementById("privacyModal");

        // Get the button that opens the privacy policy modal
        var privacyBtn = document.getElementById("privacyBtn");

        // Get the close button for the privacy policy modal
        var closePrivacyBtn = document.getElementById("closePrivacyBtn");

        // When the user clicks on the button, open the privacy policy modal
        privacyBtn.onclick = function() {
            privacyModal.style.display = "block";
        }

        // When the user clicks on the close button, close the privacy policy modal
        closePrivacyBtn.onclick = function() {
            privacyModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == privacyModal) {
                privacyModal.style.display = "none";
            }
        }
    </script>

</body>

</html>