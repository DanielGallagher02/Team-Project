<div class="containerReg">
<?php

    // include the header
    session_start();
    include('header.php');

?>

<style>
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

.btn-red {
    background-color: #f44336;
}

.btn-orange {
    background-color: #FFA500;
}

.btn:hover {
    opacity: 0.8;
}

/* Styling the dropdown */
.select-dropdown {
    display: inline-block;
    width: 100%;
    max-width: 300px;
    padding: 8px 16px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    background-color: white;
    color: black;
    cursor: pointer;
}

.select-dropdown:hover {
    border-color: #888;
}
</style>

<h1>Welcome to the Request Extras page, <?php echo $_SESSION['customerusername']; ?>!</h1>
<form action="customerHub.php" method="post" style="display: inline;">
    <input type="submit" value="Back to Customer Hub" class="btn btn-orange">
</form>
<h1>Available extras</h1>
</div>

<div class="container">
<?php
// Query the database to retrieve the customer's name
$CustomerName = $_SESSION['customerusername'];

// Query the database to retrieve the customer's name
$CustomerName = $_SESSION['customerusername'];
$query5 = "SELECT * FROM extra_list";
$result5 = mysqli_query($conn, $query5);
if (mysqli_num_rows($result5) > 0) {
    echo "<table>";
    echo "<tr><th>Extra Name</th><th>Price</th></tr>";
    while ($row = mysqli_fetch_assoc($result5)) {
        // Display the customer information on the web page
        echo "<tr>";
        echo "<td>" . $row["ExtraName"] . "</td>";
        echo "<td>" . $row["ExtraPrice"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
echo "<h1>Your selected extras</h1>";

$query = "SELECT CustomerID FROM customer WHERE CustomerLogin = '$CustomerName'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $custid = $row['CustomerID'];
    // Query the customer information table using the customer's name
    $query2 = "SELECT e.* FROM booked_extras e INNER JOIN reservation r ON e.ReservationID = r.ReservationID WHERE r.CustomerID = '$custid'";
    $result2 = mysqli_query($conn, $query2);
    if ($result2) { // add this check
        echo "<form action='customerRequestExtra.php' method='POST'>";
        echo "<table>";
        echo "<tr><th>Extra ID</th><th>Reservation ID</th><th>Price</th><th>Extra Description</th><th>Operations</th></tr>";
        // loop over $result data
        if (mysqli_num_rows($result2) > 0) {
            while ($row = mysqli_fetch_assoc($result2)) {
                // Display the customer information on the web page
                $ExtraID = $row["ExtraID"];
                $ReservationID = $row["ReservationID"];
                $ExtraPrice = $row["ExtraPrice"];
                $ExtraDesc = $row["ExtraDescription"];
                echo "<tr>";
                echo "<td>" . $row["ExtraID"] . "</td>";
                echo "<td>" . $row["ReservationID"] . "</td>";
                echo "<td>" . $row["ExtraPrice"] . "</td>";
                echo "<td>" . $row["ExtraDescription"] . "</td>";
                echo "<td><input type='submit' class='btn btn-red' value='Delete!' id='delete' name='delete[$ExtraID]'></td>";
                echo "</tr>";
            }
        } else {
            echo "0 results";
        }
        // end table
        echo "</table>";
        echo "</form>";
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
}

// Retrieve available reservations for the customer
$query4 = "SELECT r.ReservationID FROM reservation r WHERE r.CustomerID = '$custid'";
$result4 = mysqli_query($conn, $query4);
$reservationIDs = [];
while ($row = mysqli_fetch_assoc($result4)) {
    $reservationIDs[] = $row['ReservationID'];
}

?>

<div class="containerReg">
    <h1>Please fill in this form to request an extra.</h1>
    <form action="customerRequestExtra.php" method="POST">
        <label for="reservationID"><b>Reservation ID</b></label></br>
        <select name="reservationID" id="reservationID" class="select-dropdown">
            <?php
                foreach ($reservationIDs as $reservationID) {
                    echo '<option value="' . $reservationID . '">' . $reservationID . '</option>';
                } 
            ?>
        </select></br>
        <label for="description"><b>Choose an extra</b></label></br>
        <select name="description" id="description" class="select-dropdown">
            <option value="Room Service">Room Service</option>
            <option value="Car Rental">Car Rental</option>
            <option value="Firmer pillows">Firmer pillows</option>
            <option value="Electric socket adapters">Electric socket adapters</option>
            <option value="Bottle of champagne">Bottle of champagne</option>
        </select>
        <label for="extraDate">Select date for extra:</label>
        <input type="date" id="extraDate" name="extraDate">
        <button type="submit" class="btn btn-orange" id="requestExtra" name="requestExtra">Request Extra</button>
    </form>
</div>

<?php
    if (isset($_POST['requestExtra'])) {
        $reservationID = $_POST['reservationID'];
        $description = $_POST['description'];
        $extradate = $_POST['extraDate'];
        $price = 15;

        $query1 = "SELECT CustomerCheckedIn, ResCheckInDate, ResCheckOutDate FROM reservation WHERE ReservationID='$reservationID'";
        $result1 = mysqli_query($conn, $query1);
        if (mysqli_num_rows($result1) > 0) {
            $row = mysqli_fetch_assoc($result1);
        }
        if ($row['CustomerCheckedIn'] == 1) {
            if($row['ResCheckInDate'] < $extradate && $extradate < $row['ResCheckOutDate']){
                $query2 = "INSERT INTO booked_extras (ReservationID, ExtraPrice, ExtraDate, ExtraDescription)
                VALUES ('$reservationID', '$price', '$extradate', '$description')";
                $result2 = mysqli_query($conn, $query2);
            
                if ($result2) {
                    echo "Extra requested successfully.";
                    echo '<script type="text/javascript">';
                    echo 'alert("Extra Requested Successfully!");';
                    echo 'window.location.href = "customerRequestExtra.php";';
                    echo '</script>';
                } else {
                    echo "Error requesting extra: " . mysqli_error($conn);
                    echo '<script type="text/javascript">';
                    echo 'alert("There was an Error! Try again!");';
                    echo 'window.location.href = "customerRequestExtra.php";';
                    echo '</script>';
                }
            }   else {
                echo "Error requesting extra: " . mysqli_error($conn);
                echo '<script type="text/javascript">';
                echo 'alert("Extras can only be requested for days between checkin and checkout dates");';
                echo 'window.location.href = "customerRequestExtra.php";';
                echo '</script>';
            }
        } else {
            echo "Error requesting extra: " . mysqli_error($conn);
            echo '<script type="text/javascript">';
            echo 'alert("Customer not checked in yet.");';
            echo 'window.location.href = "customerRequestExtra.php";';
            echo '</script>';
        }

    }
// if the delete button is pressed
if (isset($_POST['delete'])) {
    // Get the Room Number of the row to be deleted
    $extraToDelete = key($_POST['delete']);
    // sql to select
    $sql_select = "SELECT * FROM booked_extras WHERE ExtraID='$extraToDelete'";
    // get results of select sql
    $result_select = mysqli_query($conn, $sql_select);
    // check if result is not 0
    if (mysqli_num_rows($result_select) == 0) {
        echo '<script type="text/javascript">';
        echo 'alert("Record does not exist!");';
        echo 'window.location.href = "customerRequestExtra.php";';
        echo '</script>';
    } else { // if exists
        // sql to delete
        $sql_delete = "DELETE FROM booked_extras WHERE ExtraID='$extraToDelete'";
        // if deletes, good
        if (mysqli_query($conn, $sql_delete)) {
            echo '<script type="text/javascript">';
            echo 'alert("Record deleted successfully!");';
            echo 'window.location.href = "customerRequestExtra.php";';
            echo '</script>';
        } else { // if not, bad
            echo '<script type="text/javascript">';
            echo 'alert("There was an Error! Try again!");';
            echo 'window.location.href = "customerRequestExtra.php";';
            echo '</script>';
        }
    }}

    // include the header
    include('footer.php');

?>