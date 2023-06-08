<?php
include('header.php');
session_start();

if (isset($_SESSION['checkin']) && isset($_SESSION['checkout']) && isset($_SESSION['num_days'])) {
  $checkin = $_SESSION['checkin'];
  $checkout = $_SESSION['checkout'];
  $num_days = $_SESSION['num_days'];

  echo "<p style='font-size: 24px;'>From: <span style='color: blue;'>$checkin</span> To: <span style='color: blue;'>$checkout</span></p>";

  echo "<h2>Days between dates: " . $num_days . "</h2><br>";

}

// Step 2: Querying the database to retrieve the room information
$sql = "SELECT * FROM room r WHERE NOT EXISTS (SELECT * FROM reservation rn WHERE r.RoomNUM = rn.RoomNUM AND (rn.ResCheckInDate < '$checkout' AND rn.ResCheckOutDate > '$checkin'));";
//$sql = "SELECT * FROM 'reservation' ";
$result = $conn->query($sql);


// Step 3: Create an HTML table to display the information
echo "<form action='FinalReservation.php' method='post'>";
echo "<table>";
echo "<tr><th>Room Number</th><th>Room Price</th><th>People per Room</th><th>Room Description</th><th>Room Type</th><th>Select</th></tr>";
// Step 4: Loop over the data and add a new row to the table for each room
if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $row["RoomNUM"] . "</td>";
      echo "<td>" . $row["RoomPrice"] . "</td>";
      echo "<td>" . $row["NumberOfRooms"] . "</td>";
      echo "<td>" . $row["RoomDescription"] . "</td>";
      
      if ($row["RoomType"] == "Single") {
        echo "<td><a href='images/single.jpg' target='_blank'><img src='images/single.jpg' alt='Single Room' class='room-image'></a></td>";
      } elseif ($row["RoomType"] == "Double") {
        echo "<td><a href='images/double.jpg' target='_blank'><img src='images/double.jpg' alt='Double Room' class='room-image'></a></td>";
      } elseif ($row["RoomType"] == "Family") {
        echo "<td><a href='images/family.jpg' target='_blank'><img src='images/family.jpg' alt='Family Room' class='room-image'></a></td>";
      } else {
        echo "<td>No Image Available</td>";
      }
      
      echo "<td><input type='radio' name='RoomNUM' value='" . $row["RoomNUM"] . "'></td>";
      echo "</tr>";
  }
} else {
  echo "0 results";
}

echo "</table>";

// Submit button
echo '<input type="submit" value="Reserve Room" style="padding: 10px 20px; background-color: #eee; color:black; border: none; border-radius: 4px; cursor: pointer;">';

echo "</br></form>";

// Go Back Button
echo '<button style="padding: 10px 20px; background-color: #eee; border: none; border-radius: 4px; cursor: pointer;" onclick="goBack()">Go Back</button>';

// Redirect the user to the previous page when the button is clicked
echo '<script>function goBack() {window.history.back();}</script>';

include('footer.php');
?>



