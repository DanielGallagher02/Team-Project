<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Start a session and connect to the hotel database
session_start();
// include the header file for the page
include('header.php');
?>

<!-- Add the CSS for the buttons -->
<style>
.btn-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.btn {
    display: inline-block;
    color: white;
    text-align: center;
    font-size: 14px;
    padding: 10px 20px;
    margin: 10px 2px;
    cursor: pointer;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    transition-duration: 0.4s;
}

.btn-edit {
    background-color: #4CAF50;
}

.btn-request {
    background-color: #FFA500;
}

.btn-logout {
    background-color: #008CBA;
}

.btn-delete {
    background-color: #f44336;
}

.btn-generate {
    background-color: #6c757d;
}

.btn:hover {
    opacity: 0.8;
}
</style>

<h1>Welcome to the Customer Hub,
    <?php echo $_SESSION['customerusername']; ?>!
</h1>

<?php
// Get the customer's username from the session
$CustomerName = $_SESSION['customerusername'];

// Query the database to retrieve the customer's ID
$query = "SELECT CustomerID FROM customer WHERE CustomerLogin = '$CustomerName'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $custid = $row['CustomerID'];
    
    // Query the customer information table using the customer's ID
    $query2 = "SELECT reservation.*, room.RoomPrice, SUM(booked_extras.ExtraPrice) AS AdditionalCharges FROM reservation INNER JOIN room ON reservation.RoomNUM = room.RoomNUM LEFT JOIN booked_extras ON reservation.ReservationID = booked_extras.ReservationID WHERE reservation.CustomerID = '$custid' GROUP BY reservation.ReservationID";
    $result2 = mysqli_query($conn, $query2);

    // Start the form and table to display reservation data
    echo "<form action='customerHub.php' method='POST'>";
    echo "<table>";
    echo "<tr><th>Reservation ID</th><th>Check-In date</th><th>Check-out date</th><th>Customer ID</th><th>Room Number</th><th>Total Cost</th><th>Additional Charges</th><th>Total Bill</th><th>Operations</th></tr>";
    
    // loop over $result data
    if (mysqli_num_rows($result2) > 0) {
        while ($row = mysqli_fetch_assoc($result2)) {
            // Display the customer information on the web page
            $ReservationID = $row["ReservationID"];
            $RoomCheckIn = $row["ResCheckInDate"];
            $RoomCheckOut = $row["ResCheckOutDate"];
            $CustomerId = $row["CustomerID"];
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

            // Display the table row with reservation data and a delete button
            echo "<tr>";
            echo "<td>" . $row["ReservationID"] . "</td>";
            echo "<td>" . $row["ResCheckInDate"] . "</td>";
            echo "<td>" . $row["ResCheckOutDate"] . "</td>";
            echo "<td>" . $row["CustomerID"] . "</td>";
            echo "<td>" . $row["RoomNUM"] . "</td>";
            echo "<td>€" . $TotalCost . "</td>";
            echo "<td>€" . $AdditionalCharges . "</td>";
            echo "<td>€" . $TotalBill . "</td>";

            echo "<td>";
            echo "<input type='submit' value='Delete!' class='btn btn-delete' name='delete[$ReservationID]'>";
            echo "<a href='generateBill.php?reservationID=$ReservationID' class='btn btn-generate' style='margin-left: 5px;'>Generate Bill</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "0 results";
    }
    // End table and form
    echo "</table>";
    echo "</form>";
}
// if the delete button is pressed
if (isset($_POST['delete'])) {
    // Get the reservation ID of the row to be deleted
    $reservationToDelete = key($_POST['delete']);

    // SQL to select the reservation
    $sql_select = "SELECT * FROM reservation WHERE ReservationID='$reservationToDelete'";

    // Get the result of the select SQL
    $result_select = mysqli_query($conn, $sql_select);

    // Check if the result is not empty
    if (mysqli_num_rows($result_select) == 0) {
        echo '<script type="text/javascript">';
        echo 'alert("Record does not exist!");';
        echo 'window.location.href = "customerHUB.php";';
        echo '</script>';
    } else { // If the reservation exists
         // SQL to delete the reservation
        $sql_delete = "DELETE FROM reservation WHERE ReservationID='$reservationToDelete'";
        // If the reservation is deleted, display a success message
        if (mysqli_query($conn, $sql_delete)) {
            echo '<script type="text/javascript">';
            echo 'alert("Record deleted successfully!");';
            echo 'window.location.href = "customerHUB.php";';
            echo '</script>';
        } else { // If the reservation is not deleted, display an error message
            echo '<script type="text/javascript">';
            echo 'alert("There was an Error! Try again!");';
            echo 'window.location.href = "customerHUB.php";';
            echo '</script>';
        }
    }}

?>

<!-- Buttons container -->
<div class='btn-container'>

<!-- Edit details button -->
<form action="customerEditDetails.php" method="post">
    <input type="submit" value="Edit Your Details" class="btn btn-edit">
</form>

<!-- Request an extra button -->
<form action="customerRequestExtra.php" method="post">
    <input type="submit" value="Request an Extra" class="btn btn-request">
</form>

<!-- Logout button -->
<form action="customerLogout.php" method="post">
    <input type="submit" value="Logout" class="btn btn-logout">
</form>

</div>

<?php
// include the footer file for the page
include('footer.php');
?>
