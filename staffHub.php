<?php

    // start session and connect to the hotel database
    session_start();
    // include the header
    include('header.php')

?>
<div class="staffLog">
<h1>Welcome to the Staff Hub, <?php echo $_SESSION['staffusername']; ?></h1>
<h3>Click here to <a href="roomCRUD.php">Manage Rooms</a><br>
Click here to <a href="extraCRUD.php">Manage Extras</a><br>
Click here to <a href="receptionistCheckInPage.php">Manage Checkins</a><br>
Click here to <a href="reservationCRUD.php">Manage Reservations</a><br>
Click here to <a href="staffLogout.php">Logout</a></h3> 
</div>
<?php

    // include the header
    include('footer.php')

?>