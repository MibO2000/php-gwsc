<?php
include "connect.php";

$createPitchType = "CREATE TABLE gwsc_pitch_type
(
    pitch_type_id VARCHAR(30) NOT NULL PRIMARY KEY,
    pitch_type VARCHAR(30),
    CONSTRAINT pt_id_type UNIQUE (pitch_type_id,pitch_type)
)";
$query = mysqli_query($connect, $createPitchType);
if ($query) {
    echo "<p>Pitch Type Table Successfully created!</p><br>";
} else {
    echo "<p>Pitch Type Table Creation Unsuccessful!</p><br>";
}

$createCustomer = "CREATE TABLE gwsc_customer
(
    customer_id VARCHAR(20) NOT NULL PRIMARY KEY,
    first_name VARCHAR(20),
    surname VARCHAR(20),
    email VARCHAR(20),
    customer_password VARCHAR(100),
    phone VARCHAR(20),
    customer_address VARCHAR(50),
    view_count INT,
    CONSTRAINT c_id_email UNIQUE (customer_id,email)
)";
$query = mysqli_query($connect, $createCustomer);
if ($query) {
    echo "<p>Customer Table Successfully created!</p><br>";
} else {
    echo "<p>Customer Table Creation Unsuccessful!</p><br>";
}

$createAdmin = "CREATE TABLE gwsc_admin
(
    admin_id VARCHAR(20) NOT NULL PRIMARY KEY,
    admin_name VARCHAR(20),
    admin_address VARCHAR(255),
    email VARCHAR(20),
    admin_password VARCHAR(100),
    phone VARCHAR(20),
    CONSTRAINT a_id_email UNIQUE (admin_id,email)
)";
$query = mysqli_query($connect, $createAdmin);
if ($query) {
    echo "<p>Admin Table Successfully created!</p><br>";
} else {
    echo "<p>Admin Table Creation Unsuccessful!</p><br>";
}

$createPitch = "CREATE TABLE gwsc_pitch (
    pitch_id VARCHAR(30) NOT NULL PRIMARY KEY ,
    pitch_name VARCHAR(20),
    duration INT,
    price INT,
    pitch_description VARCHAR(100),
    pitch_image VARCHAR(255),
    pitch_type_id VARCHAR(30),
    FOREIGN KEY (pitch_type_id) REFERENCES gwsc_pitch_type (pitch_type_id),
    CONSTRAINT p_id_name UNIQUE (pitch_id,pitch_name)
)";
$query = mysqli_query($connect, $createPitch);
if ($query) {
    echo "<p>Pitch Table Successfully created!</p><br>";
} else {
    echo "<p>Pitch Table Creation Unsuccessful!</p><br>";
}

$createLocationType = "CREATE TABLE gwsc_location_type (
    location_type_id VARCHAR(30) NOT NULL PRIMARY KEY ,
    location_type_name VARCHAR(20),
    location_description VARCHAR(255),
    CONSTRAINT l_id_name UNIQUE (location_type_id,location_type_name)
  )";
$query = mysqli_query($connect, $createLocationType);
if ($query) {
    echo "<p>LocationType Table Successfully created!</p><br>";
} else {
    echo "<p>LocationType Table Creation Unsuccessful!</p><br>";
}

$createPackageType = "CREATE TABLE gwsc_package_type (
    package_type_id VARCHAR(30) NOT NULL PRIMARY KEY,
    package_type_name VARCHAR(20),
    package_description VARCHAR(255),
    picture VARCHAR(255),
    CONSTRAINT pt_id_name UNIQUE (package_type_id,package_type_name)
  )";
$query = mysqli_query($connect, $createPackageType);
if ($query) {
    echo "<p>PackageType Table Successfully created!</p><br>";
} else {
    echo "<p>PackageType Table Creation Unsuccessful!</p><br>";
}

$createLocation = "CREATE TABLE gwsc_location (
    location_id VARCHAR(30) NOT NULL PRIMARY KEY ,
    location_type_id VARCHAR(30),
    location_name VARCHAR(20),
    full_location VARCHAR(255),
    location_picture VARCHAR(255),
    location_description VARCHAR(255),
    FOREIGN KEY (location_type_id) REFERENCES gwsc_location_type (location_type_id),
    CONSTRAINT lt_id_name UNIQUE (location_id,location_name)
  )";
$query = mysqli_query($connect, $createLocation);
if ($query) {
    echo "<p>Location Table Successfully created!</p><br>";
} else {
    echo "<p>Location Table Creation Unsuccessful!</p><br>";
}

$createPackage = "CREATE TABLE gwsc_package (
    package_id VARCHAR(30) NOT NULL PRIMARY KEY ,
    package_name VARCHAR(20),
    package_type_id VARCHAR(30),
    pitch_id VARCHAR(30),
    location_id VARCHAR(30),
    duration INT,
    price INT,
    pitch_description VARCHAR(255),
    package_image VARCHAR(255),
    discount VARCHAR(10),
    FOREIGN KEY (pitch_id) REFERENCES gwsc_pitch (pitch_id),
    FOREIGN KEY (location_id) REFERENCES gwsc_location (location_id),
    CONSTRAINT p_id_name UNIQUE (package_id,package_name)
  )";
$query = mysqli_query($connect, $createPackage);
if ($query) {
    echo "<p>Package Table Successfully created!</p><br>";
} else {
    echo "<p>Package Table Creation Unsuccessful!</p><br>";
}

$createReview = "CREATE TABLE gwsc_review (
    review_id VARCHAR(30) NOT NULL PRIMARY KEY,
    customer_id VARCHAR(30),
    content VARCHAR(255),
    stars INT,
    date_time DATE,
    FOREIGN KEY (customer_id) REFERENCES gwsc_customer (customer_id),
    CONSTRAINT r_id UNIQUE (review_id)
  )";
$query = mysqli_query($connect, $createReview);
if ($query) {
    echo "<p>Review Table Successfully created!</p><br>";
} else {
    echo "<p>Review Table Creation Unsuccessful!</p><br>";
}

$createBooking = "CREATE TABLE gwsc_booking (
    booking_id VARCHAR(30) NOT NULL PRIMARY KEY,
    customer_id VARCHAR(30),
    order_time TIMESTAMP(6),
    booking_status VARCHAR(20),
    FOREIGN KEY (customer_id) REFERENCES gwsc_customer (customer_id),
    CONSTRAINT b_id UNIQUE (booking_id)
  )";
$query = mysqli_query($connect, $createBooking);
if ($query) {
    echo "<p>Booking Table Successfully created!</p><br>";
} else {
    echo "<p>Booking Table Creation Unsuccessful!</p><br>";
}

$createBookingDetail = "CREATE TABLE gwsc_booking_detail (
    booking_detail_id VARCHAR(30) NOT NULL PRIMARY KEY,
    booking_id VARCHAR(30) NOT NULL,
    package_id VARCHAR(30) NOT NULL,
    quantity INT,
    tax INT,
    price INT,
    total_price INT,
    booking_date DATETIME,
    FOREIGN KEY (booking_id) REFERENCES gwsc_booking (booking_id),
    CONSTRAINT bd_id UNIQUE (booking_detail_id)
  )";
$query = mysqli_query($connect, $createBookingDetail);
if ($query) {
    echo "<p>Booking Table Successfully created!</p><br>";
} else {
    echo "<p>Booking Table Creation Unsuccessful!</p><br>";
}
