<?php
    // start session
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
<!-- Login form -->
<div class="containerLogin">
<!-- Login form -->
<h1>Customer Login</h1>
<form action="customerLogin.php" method="POST">
    
    <label for="customerusername"><b>Username</label></br>
    <input type="text" placeholder="Enter Username" id="customerusername" name="customerusername" placeholder="Username" required=""></br>
    <label for="customerpass"><b>Password</label></br>
    <div class="input-container">
        <input type="password" placeholder="Enter Password" id="customerpass" name="customerpass" placeholder="Password" required="">
        <span class="password-eye" onclick="togglePasswordVisibility()"><i class="fa fa-eye"></i></span>
    </div></br>
    <button type="submit" class="field" id="customerlogin" name="customerlogin">Login</button>
</form>

<!-- If staff member is not registered they can register by clicking register button -->
</br><p>Not Registered:</p>
<form action="customerRegister.php" >
<div class = "customerRegister">
<button type="submit"  id="customerReg"class="field" >Register</button>

</form>       
</div>
</div>
<script>
// Add the JavaScript function from the previous response here
function togglePasswordVisibility() {
            var passwordInput = document.getElementById("customerpass");
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
    if (isset($_POST['customerlogin'])) {
        // extract customer username and password
        $customerusername = $_POST['customerusername'];
        $customerpass = $_POST['customerpass'];

        // create a select query and get the row from the result
        $select = mysqli_query($conn, "SELECT * FROM customer where CustomerLogin = '$customerusername' and CustomerPassword = '$customerpass'");
        $row = mysqli_fetch_array($select);

        // compare user input with that in the tables
        if (is_array($row)) {
            $_SESSION['customerusername'] = $row['CustomerLogin'];
            $_SESSION['customerpass'] = $row['CustomerPassword'];
            $_SESSION['customer_id'] = $row['CustomerID']; // Store the customer_id in the session.
        } else {
            // do nothing for now
            echo '<script type="text/javascript">';
            echo 'alert("Invalid Username or Password");';
            echo 'window.location.href = "customerLogin.php";';
            echo '</script>';
        }
    }
    // if user login is correct, redirect to staffHub.php
    if (isset($_SESSION['customerusername'])) {
        header("Location: customerHub.php");
    }
    // include the footer
    include("footer.php");

?>    
