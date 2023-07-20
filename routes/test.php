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
    <title>TEST</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="images/logo.png">
</head>

<body>

    <?php
    $wearUrl = "https://55gadgets.com/wearable-technology/feed/";
    $wearArr = simplexml_load_file($wearUrl);
    if (isset($wearArr->channel)) {
        $wearCha = $wearArr->channel;
        echo "<h2>" . $wearCha->title . "</h2>";
        echo "<p>" . $wearCha->description . "</p>";
        foreach ($wearCha->item as $item) {
            echo '<div>';
            echo '<h3><a href="' . $item->link . '" target="_blank">' . $item->title . '</a></h3>';
            echo '<p>' . $item->description . '</a></p>';
            echo '</div>';
        }
    } else {
        print_r("invalid channel");
    }
    ?>