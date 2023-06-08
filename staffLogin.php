<?php
    // start session
    session_start();
    // then destroy it and start again
    session_destroy();
    session_start();
    // include the header
    include("header.php");
?>

<style>
/*Styling for eye icon in text box*/
 .input-container {
        position: relative;
    }

    .icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .eye-icon {
        right: 5px;
    }
</style>

<div class="containerLogin">
<h1>Staff Login:</h1>
<form action="staffLogin.php" method="post">
  
    <label for="staffusername"><b>Username</label></br>
    <input type="text" placeholder="Enter Username" id="staffusername" name="staffusername" placeholder="Username" required=""></br>
    <label for="staffpass"><b>Password</label></br>
    <div class="input-container">
        <input type="password" placeholder="Enter Password" id="staffpass" name="staffpass" placeholder="Password" required="">
        <span class="password-eye" onclick="togglePasswordVisibility()"><i class="fa fa-eye"></i></span>
    </div>
    <button type="submit" class="field" id="stafflogin" name="stafflogin">Login</button>
  
</form>
</div>

<script>
function togglePasswordVisibility() {
    var passwordInput = document.getElementById("staffpass");
    var eyeIcon = document.querySelector(".password-eye i");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}
</script>

<?php

  // after clicking submit
  if (isset($_POST['stafflogin'])) {
    // extract customer username and password
    $staffusername = $_POST['staffusername'];
    $staffpass = $_POST['staffpass'];

    // create a select query and get the row from the result
    $select = mysqli_query($conn, "SELECT * FROM staff where StaffLogin = '$staffusername' and StaffPassword = '$staffpass'");
    $row = mysqli_fetch_array($select);

    // compare user input with that in the tables
    if (is_array($row)) {
        $_SESSION['staffusername'] = $row['StaffLogin'];
        $_SESSION['staffpass'] = $row['StaffPassword'];
    } else {
        // do nothing for now
        echo '<script type="text/javascript">';
        echo 'alert("Invalid Username or Password");';
        echo 'window.location.href = "staffLogin.php";';
        echo '</script>';
    }
  }
  // if user login is correct, redirect to staffHub.php
  if (isset($_SESSION['staffusername'])) {
    header("Location: staffHub.php");
  }
  // include the footer
  include("footer.php");
    
?>
