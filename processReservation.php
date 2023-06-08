<?php
  //Daniel Gallagher 

  //Including the Header
  include('header.php');
  session_start();

  // Check if the user is logged in
  $is_customer_logged_in = isset($_SESSION['customerusername']);

  //Step 1: Retriving the check in date and check out date and the form information
  if (isset($_SESSION['checkin']) && isset($_SESSION['checkout']) && isset($_SESSION['num_days'])) {
    $checkin = $_SESSION['checkin'];
    $checkout = $_SESSION['checkout'];
    $num_days = $_SESSION['num_days'];
    $room_num = $_SESSION['RoomNUM'];

    //echo "From: " . "<span style='color: blue;'>$checkin</span>" . " To: " . "<span style='color: blue;'>$checkout</span>". "<br>";
    //echo "Number between dates: " . $num_days . "<br>";
    //echo "Room Number " . $room_num . "<br>";

    // Step 2: Retrieve the form data
    $customerLogin = $_POST['customer_login'];
    $customerPassword = $_POST['customer_password'];
    $customerEmail = $_POST['customer_email'];
    $customerName = $_POST['customer_name'];
    $customerSurname = $_POST['customer_surname'];
    $customerPhoneNum = $_POST['customer_phoneNum'];
    $creditCard = $_POST['credit_card'];
    $creditCardExpire = $_POST['credit_card_expire'];
    $creditCardSecurity = $_POST['credit_card_security'];
    //echo "$customerLogin";
    //echo "$checkin";

    //Step 3.. Performing additional validation here (e.g. checking that fields are not empty, credit card number is valid, etc.)
      
    //Step 4. - Works - Insert customer information into the "customer" table
    $sql = "INSERT INTO customer (CustomerLogin, CustomerPassword, CustomerEmail, CustomerName, CustomerSurname, CustomerPhoneNum, CreditCard, CreditCardExpire, CreditCardSecurity) 
            VALUES ('$customerLogin', '$customerPassword', '$customerEmail', '$customerName', '$customerSurname', '$customerPhoneNum', '$creditCard', '$creditCardExpire', '$creditCardSecurity')";

    if ($conn->query($sql) === TRUE) {
      //Retrieve the ID of the newly inserted customer record
      $customer_id = $conn->insert_id;
      echo "Your account has been created successfully with the ID: " . $customer_id . "<br>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    //Step 5. Insert reservation information into the "reservation" table
    $sql = "INSERT INTO `reservation` (`RoomNUM`, `CustomerID`, `ResCheckInDate`, `ResCheckOutDate`, `CustomerCheckedIn`) 
            VALUES ('$room_num', '$customer_id', '$checkin', '$checkout', '0')";
    if ($conn->query($sql) === TRUE) {
      echo "New reservation created successfully.";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  // Go Home button
  echo '<br>';
  echo '<a href="index.php"><button>Go Home</button></a>';

  //Including the Footer
  include('footer.php');
?>