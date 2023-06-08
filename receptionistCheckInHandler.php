<?php
  include('header.php');
  session_start();
  $input = $_POST['option'];
  //Dont ask me why but the thing breaks if I dont do this
  $cstID = substr($input, 0, 1);
  //$sql = "Update 'reservation' "
  $sql1 = "SELECT * FROM `reservation` WHERE CustomerID = $cstID";
  $result = $conn->query($sql1);
  $row = mysqli_fetch_assoc($result);
  if($row['CustomerCheckedIn'] == 0 && $row['ResCheckInDate'] == date("Y-m-d")) {
    $sql2 = "UPDATE reservation SET CustomerCheckedIn = 1 WHERE CustomerID = $cstID";
    $echoText = "CheckIn Successful";
    $connect = 1;
  }
  elseif($row['CustomerCheckedIn'] == 0 && $row['ResCheckInDate'] != date("Y-m-d")) {
    $echoText = "CheckIn Unsuccessful. Check in was not scheduled today";
    $connect = 0;
  }
  elseif($row['CustomerCheckedIn'] == 1 && $row['ResCheckOutDate'] == date("Y-m-d")) {
    $sql2 = "UPDATE reservation SET CustomerCheckedIn = 0 WHERE CustomerID = $cstID";
    $echoText = "CheckOut Successful";
    $connect = 1;
  }
  elseif($row['CustomerCheckedIn'] == 1 && $row['ResCheckOutDate'] != date("Y-m-d")) {
    $echoText = "CheckOut Unsuccessful. Check out was not scheduled today";
    $connect = 0;
  }
  if ($connect == 0){
    echo "<h2>$echoText</h2>";
  } elseif ($conn->query($sql2) === TRUE && $connect == 1) {
    echo "<h2>$echoText</h2>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
?>
<hr>
  Click <a href="receptionistCheckInPage.php">here</a> to go back to checkins!
<hr>
<?php
  include('footer.php');
?>