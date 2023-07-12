<?php
include "connect.php";

$createPitchType = "CREATE TABLE PITCH_TYPE
(
    PITCH_TYPE_ID VARCHAR(30) NOT NULL PRIMARY KEY,
    PITCH_TYPE VARCHAR(30)
)";
$query = mysqli_query($connect, $createPitchType);
if ($query) {
    echo "<p>Pitch Type Table Successfully created!</p>";
} else {
    echo "<p>Pitch Type Table Creation Unsuccessful!</p>";
}

$createCustomer = "CREATE TABLE CUSTOMER
(
    CUSTOMER_ID VARCHAR(20) NOT NULL PRIMARY KEY,
    FIRST_NAME VARCHAR(20),
    SURNAME VARCHAR(20),
    EMAIL VARCHAR(20),
    PASSWORD VARCHAR(20),
    PHONE_NUMBER VARCHAR(20),
    ADDRESS VARCHAR(50),
    VIEW_COUNT INT,
    CONSTRAINT UC_email UNIQUE (CUSTOMER_ID,EMAIL)
)";
$query = mysqli_query($connect, $createCustomer);
if ($query) {
    echo "<p>Customer Table Successfully created!</p>";
} else {
    echo "<p>Customer Table Creation Unsuccessful!</p>";
}

$createAdmin = "CREATE TABLE ADMIN
(
    ADMIN_ID VARCHAR(20) NOT NULL PRIMARY KEY,
    ADDRESS VARCHAR(255),
    EMAIL VARCHAR(20),
    PASSWORD VARCHAR(20),
    PHONE VARCHAR(20),
    CONSTRAINT UC_email UNIQUE (ADMIN_ID,EMAIL)
)";
$query = mysqli_query($connect, $createAdmin);
if ($query) {
    echo "<p>Admin Table Successfully created!</p>";
} else {
    echo "<p>Admin Table Creation Unsuccessful!</p>";
}

$createPitch = "CREATE TABLE PITCH (
    PITCH_ID VARCHAR(30) NOT NULL PRIMARY KEY ,
    PITCH_NAME VARCHAR(20),
    DURATION INT,
    PRICE INT,
    DESCRIPTION_PITCH VARCHAR(100),
    PITCH_IMAGE_1 VARCHAR(255),
    PITCH_IMAGE_2 VARCHAR(255),
    PITCH_TYPE_ID VARCHAR(30),
    FOREIGN KEY (PITCH_TYPE_ID) REFERENCES PITCH_TYPE (PITCH_TYPE_ID)
)";
$query = mysqli_query($connect, $createPitch);
if ($query) {
    echo "<p>Pitch Table Successfully created!</p>";
} else {
    echo "<p>Pitch Table Creation Unsuccessful!</p>";
}

$createLocationType = "CREATE TABLE `LOCATION_TYPE` (
    `LOCATION_TYPE_ID` VARCHAR(30) NOT NULL PRIMARY KEY ,
    `LOCATION_TYPE_NAME` VARCHAR(20),
    `DESCRIPTION` VARCHAR(255)
  )";
$query = mysqli_query($connect, $createLocationType);
if ($query) {
    echo "<p>LocationType Table Successfully created!</p>";
} else {
    echo "<p>LocationType Table Creation Unsuccessful!</p>";
}

$createPackageType = "CREATE TABLE `PACKAGE_TYPE` (
    `PACKAGE_TYPE_ID` VARCHAR(30) NOT NULL PRIMARY KEY,
    `PACKAGE_TYPE_NAME` VARCHAR(20),
    `DESCRIPTION` VARCHAR(255),
    `PICTURE1` VARCHAR(255),
    `PICTURE2` VARCHAR(255)
  )";
$query = mysqli_query($connect, $createPackageType);
if ($query) {
    echo "<p>PackageType Table Successfully created!</p>";
} else {
    echo "<p>PackageType Table Creation Unsuccessful!</p>";
}

$createPackage = "CREATE TABLE `PACKAGE` (
    `PACKAGE_ID` VARCHAR(30) NOT NULL PRIMARY KEY ,
    `PACKAGE_NAME` VARCHAR(20),
    `PACKAGE_TYPE_ID` INT,
    `PITCH_TYPE_ID` INT,
    `LOCATION_ID` VARCHAR(20),
    `DURATION` INT,
    `PRICE` INT,
    `DESCRIPTION1` VARCHAR(255),
    `DESCRIPTION2` VARCHAR(255),
    `PICTURE1` VARCHAR(255),
    `PICTURE2` VARCHAR(255),
    `DISCOUNT` VARCHAR(10),
    `STATUS` VARCHAR(10),
    `VIEW_COUNT` INT
  )";
$query = mysqli_query($connect, $createPackage);
if ($query) {
    echo "<p>Package Table Successfully created!</p>";
} else {
    echo "<p>Package Table Creation Unsuccessful!</p>";
}

$createLocation = "CREATE TABLE `LOCATION` (
    `LOCATION_ID` VARCHAR(30) NOT NULL PRIMARY KEY ,
    `LOCATION_TYPE_ID` INT,
    `LOCATION_NAME` VARCHAR(20),
    `FULL_LOCATION` VARCHAR(255),
    `PICTURE` VARCHAR(255),
    `DESCRIPTION` VARCHAR(255)
  )";
$query = mysqli_query($connect, $createLocation);
if ($query) {
    echo "<p>Location Table Successfully created!</p>";
} else {
    echo "<p>Location Table Creation Unsuccessful!</p>";
}

$createBooking = "CREATE TABLE `BOOKING` (
    `BOOKING_ID` VARCHAR(30) NOT NULL PRIMARY KEY,
    `CUSTOMER_ID` VARCHAR(20),
    `PACKAGE_ID` VARCHAR(20),
    `QUANTITY` INT,
    `TAX` INT,
    `PRICE` INT,
    `TOTAL_AMOUNT` INT,
    `BOOKING_DATE` DATETIME,
    `BOOKING_STATUS` VARCHAR(20)
  )";
$query = mysqli_query($connect, $createBooking);
if ($query) {
    echo "<p>Booking Table Successfully created!</p>";
} else {
    echo "<p>Booking Table Creation Unsuccessful!</p>";
}

$createReview = "CREATE TABLE `REVIEW` (
    `REVIEW_ID` VARCHAR(30) NOT NULL PRIMARY KEY,
    `CUSTOMER_ID` VARCHAR(20),
    `CONTENT` VARCHAR(255),
    `STARS` INT,
    `DATE_TIME` DATE
  )";
$query = mysqli_query($connect, $createReview);
if ($query) {
    echo "<p>Review Table Successfully created!</p>";
} else {
    echo "<p>Review Table Creation Unsuccessful!</p>";
}
