<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start a session and connect to the hotel database
session_start();

// include the header file for the page
include('header.php');

// Get the Reservation ID from the URL
$reservationID = $_GET['reservationID'];

// Query the database to retrieve the customer's reservation details
$query = "SELECT reservation.*, customer.*, room.RoomPrice, SUM(booked_extras.ExtraPrice) AS AdditionalCharges FROM reservation INNER JOIN customer ON reservation.CustomerID = customer.CustomerID INNER JOIN room ON reservation.RoomNUM = room.RoomNUM LEFT JOIN booked_extras ON reservation.ReservationID = booked_extras.ReservationID WHERE reservation.ReservationID = '$reservationID' GROUP BY reservation.ReservationID";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    
    // Reservation details
    $RoomCheckIn = $row["ResCheckInDate"];
    $RoomCheckOut = $row["ResCheckOutDate"];
    $RoomNum = $row["RoomNUM"];
    $PricePerNight = $row["RoomPrice"];

    // Calculate the number of nights and total cost
    $date1 = new DateTime($RoomCheckIn);
    $date2 = new DateTime($RoomCheckOut);
    $interval = $date1->diff($date2);
    $numNights = (int)$interval->format('%a');
    $TotalCost = $numNights * $PricePerNight;

    // Additional Charges
    $AdditionalCharges = $row["AdditionalCharges"] ? $row["AdditionalCharges"] : 0;

    // Calculate Total Bill
    $TotalBill = $TotalCost + $AdditionalCharges;

    // Customer details
    $CustomerName = $row["CustomerName"] . ' ' . $row["CustomerSurname"];
    $CustomerEmail = $row["CustomerEmail"];

    // Display the bill in a table
    echo "<h1>Bill for Reservation ID: $reservationID</h1>";
    echo "<table>";
    echo "<tr><td>Name:</td><td>$CustomerName</td></tr>";
    echo "<tr><td>Email:</td><td>$CustomerEmail</td></tr>";
    echo "<tr><td>Room Number:</td><td>$RoomNum</td></tr>";
    echo "<tr><td>Check-In Date:</td><td>$RoomCheckIn</td></tr>";
    echo "<tr><td>Check-Out Date:</td><td>$RoomCheckOut</td></tr>";
    echo "<tr><td>Days Staying:</td><td>$numNights</td></tr>";
    echo "<tr><td>Total Room Cost:</td><td>€" . $TotalCost . "</td></tr>";
    echo "<tr><td>Additional Charges:</td><td>€" . $AdditionalCharges . "</td></tr>";
    echo "<tr><td>Total Bill:</td><td>€" . $TotalBill . "</td></tr>";
    echo "</table>";


    // Save the bill to a text file
    $filename = "bill_" . $reservationID . ".txt";
    $file = fopen($filename, "w") or die("Unable to open file!");

    $billContent = "Bill for Reservation ID: $reservationID\n";
    $billContent .= "Name: $CustomerName\n";
    $billContent .= "Email: $CustomerEmail\n";
    $billContent .= "Room Number: $RoomNum\n";
    $billContent .= "Check-In Date: $RoomCheckIn\n";
    $billContent .= "Check-Out Date: $RoomCheckOut\n";
    $billContent .= "Days Staying: $numNights\n";
    $billContent .= "Total Room Cost: " . $TotalCost . "\n";
    $billContent .= "Additional Charges: " . $AdditionalCharges . "\n";
    $billContent .= "Total Bill: " . $TotalBill . "\n";

    fwrite($file, $billContent);
    fclose($file);

    echo "<p>Bill saved as <a href='$filename'>$filename</a></p>";
} else {
    echo "<p>Reservation not found.</p>";
}
?>

<!-- Go Back to Customer Hub button -->
<div class='btn-container'>
    <form action="customerHub.php" method="post">
        <input type="submit" value="Go Back to Customer Hub" class="btn btn-back">
    </form>
</div>

<?php
// include the footer file for the page
include('footer.php');
?>

<style>
    .btn-back {
    background-color: #555;
}
</style>


