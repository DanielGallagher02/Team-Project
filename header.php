<?php

  // including header from the header.php
  include("connection.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <title>iHotel</title>
</head>
<body>
<div class = "headerStyle">
  <ul>
    <li><img src="images/logo1.jpg"></li>
    <li><a href="index.php">Home</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="bookNow.php">Book Now</a></li>
    <li><a href="ratePage.php">Rate</a></li>
    <!-- login button -->
<div class = "loginHover">
    <li style="float:right"><a class="active" href="customerLogin.php">Login</a></li>
</div>
  </ul>
</div>