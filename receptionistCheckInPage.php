<?php

    // start session and connect to the hotel database
    session_start();
    // include the header
    include('header.php')

?>
<div class="staffLog">
<h1>Welcome to the Check In Customers page, <?php echo $_SESSION['staffusername']; ?>!</h1>
Click <a href="staffHub.php">here</a> to go back to the Staff Hub!<br>

<?php
    // Step 2: Querying the database to retrieve the reservation information
    $sql = "SELECT * FROM `reservation`";
    //query database;
    $result = $conn->query($sql);
    echo "<form action='receptionistCheckInHandler.php' method='POST'>";
    echo "<table>";
    echo "<tr><th>Reservation ID</th><th>Room Number</th><th>Customer ID</th><th>Check In Date</th><th>Check Out Date</th><th>Customer Checked In Yet</th><th>Select</th></tr>";
    // Step 4: Loop over the data and add a new row to the table for each room
    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        if($row['ResCheckOutDate'] >= date('Y-m-d')){
          $custid = $row['CustomerID'];
          echo "<tr>";
          echo "<td>" . $row["ReservationID"] . "</td>";
          echo "<td>" . $row["RoomNUM"] . "</td>";
          echo "<td>" . $row["CustomerID"] . "</td>";
          echo "<td>" . $row["ResCheckInDate"] . "</td>";
          echo "<td>" . $row["ResCheckOutDate"] . "</td>";
          echo "<td>" . $row["CustomerCheckedIn"] . "</td>";
          echo "<td><input type='radio' name='option' value=$custid" . $row["RoomNUM"] . "'></td>";
          echo "</tr>";
        }
      }
    } else {
      echo "0 results";
    }
    echo "</table>";
    echo '<input type="submit" value="Check customer in/out">';
    echo "</form>";
    // include the header
    

?></div>
<?php
include('footer.php')
?>