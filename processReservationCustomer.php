<?php
  //Daniel Gallagher

  //Including the Header
  include('header.php');
  session_start();

  // Check if the user is logged in
  $is_customer_logged_in = isset($_SESSION['customerusername']);

  if ($is_customer_logged_in) {
    // Retrieve customer ID from session
    $customer_id = $_SESSION['customer_id'];

    //Step 1: Retriving the check in date and check out date and the form information
    if (isset($_SESSION['checkin']) && isset($_SESSION['checkout']) && isset($_SESSION['num_days'])) {
      $checkin = $_SESSION['checkin'];
      $checkout = $_SESSION['checkout'];
      $num_days = $_SESSION['num_days'];
      $room_num = $_SESSION['RoomNUM'];

      //Step 2. Insert reservation information into the "reservation" table
      $sql = "INSERT INTO `reservation` (`RoomNUM`, `CustomerID`, `ResCheckInDate`, `ResCheckOutDate`, `CustomerCheckedIn`) 
              VALUES ('$room_num', '$customer_id', '$checkin', '$checkout', '0')";
      if ($conn->query($sql) === TRUE) {
        echo "New reservation created successfully.";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    } else {
      echo "Required information for reservation is missing.";
    }
  } else {
    echo "Please log in to continue with the reservation process.";
    echo '<a href="login.php"><button>Login</button></a>';
  }

  // Go Home button
  echo '<br>';
  echo '<a href="index.php"><button>Go Home</button></a>';

  //Including the Footer
  include('footer.php');
?>