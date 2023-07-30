<?php
$currentRoute = $_SERVER['REQUEST_URI'];
?>
<div class="hamburger-menu">
    <input id="menu__toggle" type="checkbox" />
    <label class="menu__btn" for="menu__toggle">
        <span></span>
    </label>

    <ul class="menu__box">
        <li>
            <a class="menu__item pzero" href="#">
                <div class="flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="profile-logo">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="pr-7"><?php echo $_SESSION['aname']; ?></span>
                </div>
            </a>
        </li>
        <li><a class="menu__item <?php echo $currentRoute == '/admin-pitch' ? 'mactive' : '' ?>" href="/admin-pitch">Pitch</a></li>
        <li><a class="menu__item <?php echo $currentRoute == '/admin-pitch-type' ? 'mactive' : '' ?>" href="/admin-pitch-type">Pitch Type</a></li>
        <li><a class="menu__item <?php echo $currentRoute == '/admin-package' ? 'mactive' : '' ?>" href="/admin-package">Package</a></li>
        <li><a class="menu__item <?php echo $currentRoute == '/admin-package-type' ? 'mactive' : '' ?>" href="/admin-package-type">Package Type</a></li>
        <li><a class="menu__item <?php echo $currentRoute == '/admin-local' ? 'mactive' : '' ?>" href="/admin-local">Local Attraction</a></li>
        <li><a class="menu__item <?php echo $currentRoute == '/admin-location-type' ? 'mactive' : '' ?>" href="/admin-location-type">Location Type</a></li>
        </li>
        <li><a class="menu__item" href="/logout">Log Out</a></li>
    </ul>
</div>