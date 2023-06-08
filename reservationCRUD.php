<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// start session and connect to the hotel database
session_start();
// include the header
include('header.php');

// select statement and run it
$sql = "SELECT * FROM `reservation`;";
$result = mysqli_query($conn, $sql);

?>

<div class="staffLog">
    <hr>
    <h1>Welcome to the Reservation CRUD, <?php echo $_SESSION['staffusername']; ?>!</h1>
    Click <a href="staffHub.php">here</a> to go back to the Staff Hub!
    <hr></div>
    <h1>List of Reservations:</h1>
    <?php

    // html table and table headers
    echo "<form action='reservationCRUD.php' method='POST'>";
    echo "<table>";
    echo "<tr><th>Reservation ID</th><th>Check-In date</th><th>Check-out date</th><th>Customer ID</th><th>Room Number</th><th>Cucstomer Checked In (0 or 1)</th><th colspan='2'>Operations</th></tr>";
    // loop over $result data
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $ReservationID = $row["ReservationID"];
            $RoomCheckIn = $row["ResCheckInDate"];
            $RoomCheckOut = $row["ResCheckOutDate"];
            $CustomerId = $row["CustomerID"];
            $RoomNum = $row["RoomNUM"];
            $CusCheckedIN = $row["CustomerCheckedIn"];
            echo "<tr>";
            echo "<td><input type='number' placeholder='' name='ReservationID[$ReservationID]' value='$ReservationID' required=''></td>";
            echo "<td><input type='date' placeholder='' name='RoomCheckIn[$ReservationID]' value='$RoomCheckIn' required=''></td>";
            echo "<td><input type='date' placeholder='' name='RoomCheckOut[$ReservationID]' value='$RoomCheckOut' required=''></td>";
            echo "<td>" . $CustomerId . "</td>";
            echo "<td>" . $RoomNum . "</td>";
            echo "<td><select id='cusCheckedIn' placeholder='' name='CusCheckedIN[$ReservationID]' required=''>";
            echo   "<option value='$CusCheckedIN'>$CusCheckedIN</option>";
            echo   "<option value='1'>Yes</option>";
            echo   "<option value='0'>No</option>";
            echo "</select>";
            echo "</td>";
            echo "<td><input type='submit' value='Update!' id='update' name='update'></td>";
            echo "<td><input type='submit' value='Delete!' id='delete' name='delete[$ReservationID]'></td>";
            echo "</tr>";
        }
    } else {
        echo "0 results";
    }
    // end table
    echo "</table>";
    echo "</form>";
    ?>
    <hr>
</div>

<?php

if (isset($_POST['update'])) {
    // loop over each reserervation
    foreach ($_POST['ReservationID'] as $reservation => $value) {
        // get values from post
        $reservation = mysqli_real_escape_string($conn, $_POST['ReservationID'][$reservation]);
        $checkIn = mysqli_real_escape_string($conn, $_POST['RoomCheckIn'][$reservation]);
        $checkOut = mysqli_real_escape_string($conn, $_POST['RoomCheckOut'][$reservation]);
        $cusCHIn = mysqli_real_escape_string($conn, $_POST['CusCheckedIN'][$reservation]);

        // create sql statement
        $sql = "UPDATE reservation
                SET ReservationID  = '$reservation', ResCheckInDate = '$checkIn', ResCheckOutDate = '$checkOut', 
                CustomerCheckedIn = '$cusCHIn'
                WHERE ReservationID = '$reservation'";
        // run sql query
        $query = mysqli_query($conn, $sql);
        // if successful then good else bad
        if ($query) {
            echo '<script type="text/javascript">';
            echo 'alert("The reservation was successfully edited!");';
            echo 'window.location.href = "reservationCRUD.php";';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("There was an Error! Try again!");';
            echo 'window.location.href = "reservationCRUD.php";';
            echo '</script>';
        }
    }
}


// if the funny delete button is pressed
if (isset($_POST['delete'])) {
    // Get the Room Number of the row to be deleted
    $reservationToDelete = key($_POST['delete']);
    // sql to select
    $sql_select = "SELECT * FROM reservation WHERE ReservationID='$reservationToDelete'";
    // get results of select sql
    $result_select = mysqli_query($conn, $sql_select);
    // check if result is not 0
    if (mysqli_num_rows($result_select) == 0) {
        echo '<script type="text/javascript">';
        echo 'alert("Record does not exist!");';
        echo 'window.location.href = "reservationCRUD.php";';
        echo '</script>';
    } else { // if exists
        // sql to delete
        $sql_delete = "DELETE FROM reservation WHERE ReservationID='$reservationToDelete'";
        // if deletes, good
        if (mysqli_query($conn, $sql_delete)) {
            echo '<script type="text/javascript">';
            echo 'alert("Record deleted successfully!");';
            echo 'window.location.href = "reservationCRUD.php";';
            echo '</script>';
        } else { // if not, bad
            echo '<script type="text/javascript">';
            echo 'alert("There was an Error! Try again!");';
            echo 'window.location.href = "reservationCRUD.php";';
            echo '</script>';
        }
    }
}

include('footer.php');
?>