<?php
  include('header.php');
  session_start();

  // Check if the user is logged in
  $is_customer_logged_in = isset($_SESSION['customerusername']);
  //echo $_SESSION['customerusername'];

  //Retrieving the check-in date, check-out date, and number of days
  if (isset($_SESSION['checkin']) && isset($_SESSION['checkout']) && isset($_SESSION['num_days'])) {
    $checkin = $_SESSION['checkin'];
    $checkout = $_SESSION['checkout'];
    $num_days = $_SESSION['num_days'];
  }  

  // Step 1: Retrieve the selected room number from the form submission
  if (isset($_POST['RoomNUM'])) {
    $room_num = $_POST['RoomNUM'];
  } else {
    echo "Error: Room number not specified.";
    exit();
  }

  // Step 2: Query the database to retrieve the room information
  $sql = "SELECT * FROM `room` WHERE `RoomNUM` = '$room_num'";
  $result = $conn->query($sql);

  // Step 3: Display the room information in an HTML table
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    //Step 3.1 Calculating the total cost per room 
    $total_cost = $num_days * $row["RoomPrice"];
    echo "<h2>Room Information</h2>";
    echo "<table>";
    echo "<tr><th>Room Number</th><td>" . $row["RoomNUM"] . "</td></tr>";
    echo "<tr><th>Room Price</th><td>" . $row["RoomPrice"] . "</td></tr>";
    echo "<tr><th>People per Room</th><td>" . $row["NumberOfRooms"] . "</td></tr>";
    echo "<tr><th>Room Description</th><td>" . $row["RoomDescription"] . "</td></tr>";
    echo "<tr><th>Room Type</th><td>" . $row["RoomType"] . "</td></tr>";
    echo "<tr><th>Check-In Date</th><td>" . $checkin . "</td></tr>";
    echo "<tr><th>Check-Out Date</th><td>" . $checkout . "</td></tr>";
    echo "<tr><th>Days Staying</th><td>" . $num_days ." Days" ."</td></tr>";
    echo "<tr><th>Total Cost</th><td>€" . $total_cost . "</td></tr>";
    echo "</table>";

    // Store the selected roomNum as a session variable
    $_SESSION['RoomNUM'] = $room_num;

    // Step 4: Display the reservation form
    if (!$is_customer_logged_in) {
      echo "<div class='reservation-form'>";
      echo "<h2>Reservation Details</h2>";
      echo "<form action='processReservation.php' method='post'>";
      echo "<label for='customer_login'>Username:</label>";
      echo "<input type='text' id='customer_login' name='customer_login' placeholder='Enter a Username' required title='Please enter a username'><br>";
      echo "<div class='input-group'>";
      echo "<label for='customer_password'>Password:</label>";
      echo "<div class='input-container'>";
      echo "<input type='password' id='customer_password' name='customer_password' placeholder='Enter your Password' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}' required title='Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters'>";
      echo "<span class='password-eye' onclick='togglePasswordVisibility()'><i class='fa fa-eye' aria-hidden='true'></i></span>";
      echo "<span class='password-help' onclick='showPasswordHelp()'><i class='fa fa-question-circle' aria-hidden='true'></i></span>";
      echo "</div>";
      echo "<div id='password-help-text' style='display:none;'>";
      echo "<p>Password must contain at least one number, one uppercase and lowercase letter, and at least 8 or more characters.</p>";
      echo "</div>";
      echo "<label for='customer_email'>Email:</label>";
      echo "<input type='email' id='customer_email' name='customer_email' placeholder='Enter your Email' required title='Please enter your email'><br>";
      echo "<label for='customer_name'>Name:</label>";
      echo "<input type='text' id='customer_name' name='customer_name' placeholder='Enter your Name' required title='Please enter your name'><br>";
      echo "<label for='customer_surname'>Surname:</label>";
      echo "<input type='text' id='customer_surname' name='customer_surname' placeholder='Enter your Surname' required title='Please enter your surname'><br>";
      echo "<label for='customer_phoneNum'>Phone:</label>";
      echo "<input type='text' id='customer_phoneNum' name='customer_phoneNum' placeholder='Enter your Phone Number' required title='Please enter your phone number'><br>";
      //Credit Card Information
      echo "<div class='credit-card-section'>";
      echo "<h3>Credit Card Information</h3>";
      echo "<div class='credit-card-row'>";
      echo "<div><label for='credit_card'>Credit Card:</label>";
      echo "<input type='text' id='credit_card' name='credit_card' placeholder='1234 5678 9012 3456' pattern='[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}' maxlength='19' required title='Please enter your credit card in format xxxx xxxx xxxx xxxx'></div>";
      echo "<div><label for='credit_card_expire'>Expire Date:</label>";
      echo "<input type='text' name='credit_card_expire' placeholder='MM/YYYY' pattern='(0[1-9]|1[0-2])\/[0-9]{4}' maxlength='7' required title='Please enter the valid expiration date in the format MM/YYYY'></div>";
      echo "</div>";
      echo "<div class='credit-card-row'>";
      echo "<div><label for='credit_card_security'>Card Security:</label>";
      echo "<input type='text' name='credit_card_security' placeholder='123' pattern='[0-9]{3}' minlength='3' maxlength='3' required title='Please enter the 3-digit security code.'></div>";
      echo "</div>";
      echo "</div>";
      echo "<input type='hidden' name='room_num' value='" . $row["RoomNUM"] . "'>";
      echo "<input type='submit' value='Make Reservation'>";
      echo "</form>";
      echo "</div>";
    } else {
      echo "<form action='processReservationCustomer.php' method='post'>";
      echo "<p>You are already logged in. Please proceed to make a reservation.</p>";
      echo "<input type='hidden' name='room_num' value='" . $row["RoomNUM"] . "'>";
      echo "<input type='submit' value='Make Reservation'>";
      echo "</form>";
    }
  } else {
    echo "Error: No room found with the specified room number.";
  }
  $conn->close();

  echo "<script>
  function togglePasswordVisibility() {
    const passwordInput = document.getElementById('customer_password');
    const passwordEye = document.querySelector('.password-eye i');

    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      passwordEye.classList.add('fa-eye-slash');
      passwordEye.classList.remove('fa-eye');
    } else {
      passwordInput.type = 'password';
      passwordEye.classList.add('fa-eye');
      passwordEye.classList.remove('fa-eye-slash');
    }
  }

  function showPasswordHelp() {
    const helpText = document.getElementById('password-help-text');
    if (helpText.style.display === 'none') {
      helpText.style.display = 'block';
    } else {
      helpText.style.display = 'none';
    }
  }
  </script>";

  include('footer.php');
?>      

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <!--Styling for the form for the user entering their details-->
  <style>
    form {
    max-width: 500px;
    margin: 0 auto;
}

form h2 {
    text-align: center;
}

form label {
    display: block;
    margin: 10px 0;
}

form input[type="text"],
form input[type="email"],
form input[type="password"] {
    width: 100%;
    padding: 5px;
    box-sizing: border-box;
}

form input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    font-size: 16px;
    padding: 10px 20px;
    margin: 10px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

form input[type="submit"]:hover {
    background-color: #45a049;
}

.credit-card-section {
  background-color: #f9f9f9;
  padding: 20px;
  margin: 10px 0;
  border-radius: 4px;
}

.credit-card-section h3 {
  text-align: center;
  margin-bottom: 10px;
}

.credit-card-row {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.credit-card-row div {
  flex-basis: 48%;
}

/*Eye icon button and ? icon button CSS in the password textbox*/
.input-group {
  position: relative;
}

.help-button {
  position: absolute;
  top: 2px;
  right: 45px;
  background-color: #999;
  color: white;
  border: none;
  cursor: pointer;
  padding: 4px 8px;
  font-size: 14px;
  border-radius: 50%;
}

.eye-icon {
  position: absolute;
  top: 8px;
  right: 10px;
  cursor: pointer;
  font-size: 18px;
}

.eye-icon:hover {
  color: #4CAF50;
}

.input-container {
  position: relative;
  display: inline-block;
  width: 100%;
}

.password-eye,
.password-help {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
}

.password-eye {
  right: 45px;
}

.password-help {
  right: 20px;
}

</style>
  </style>
</body>
</html>