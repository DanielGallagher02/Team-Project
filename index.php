<?php
//Daniel Gallagher

// include the header
session_start(); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['checkin']) && isset($_POST['checkout'])) {
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    
    // Ensure that check-in date is before check-out date
    if (strtotime($checkin) > strtotime($checkout)) {
    //echo "<span style='color: red;'>Error: Check-in date cannot be after check-out date.</span>";
      echo '<script type="text/javascript">';
      echo 'alert("Error: Check-in date cannot be greater than the Check-out date");';
      echo 'window.location.href = "index.php";';
      echo '</script>';
    } 
    // Ensure that check-out date is not less than check-in date
    else if (strtotime($checkout) <= strtotime($checkin)) {
    //echo "<span style='color: red;'>Error: Check-out date cannot be before check-in date.</span>";
      echo '<script type="text/javascript">';
      echo 'alert("Error: Check-Out date cannot be less or equal than the Check-In date");';
      echo 'window.location.href = "index.php";';
      echo '</script>';
    } else {
      // Calculate the number of days between the check-in and check-out dates
      $datediff = strtotime($checkout) - strtotime($checkin);
      $num_days = round($datediff / (60 * 60 * 24));

      // Store the check-in, check-out, and number of days in session variables
      $_SESSION['checkin'] = $checkin;
      $_SESSION['checkout'] = $checkout;
      $_SESSION['num_days'] = $num_days;

      // Redirect to another PHP file
      header('Location: AvailableRooms.php');
      exit;
    }
  }
}
include('header.php');
?>

<div id = "h1PageOne">
<h1 >Welcome to iHotel</h1>
</div>
<div class = "wrapperForCal">
    <form method="post" action="index.php" class="booking-form">
      <label for="checkin">Check-in date:</label>
      <input type="date" id="checkin" name="checkin">

      <label for="checkout">Check-out date:</label>
      <input type="date" id="checkout" name="checkout">

      <input type="submit" value="See Availability">
    </form>
  </div>
<div class = firstPagePic>
  <a href = "bookNow.php"><img src ="images/hotelpic.jpg" ></a> 
  
</div>
  <?php
  //echo $_SESSION['customerusername'];
  ?>
</div>

<?php
// include the footer
include('footer.php');
?>

<style>
   <style>
    .wrapperForCal {
      max-width: 200px; /* Adjust this value as needed */
      margin: 0 auto;
      display: flex;
      justify-content: flex-start;
    }

    .booking-form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .booking-form label {
      margin: 10px 0;
    }

    .booking-form input[type="date"] {
      padding: 5px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .booking-form input[type="submit"] {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #007bff;
      border: none;
      border-radius: 5px;
      color: #fff;
      cursor: pointer;
      margin-top: 20px;
    }

    .booking-form input[type="submit"]:hover {
      background-color: #0056b3;
    }
  </style>
</style>