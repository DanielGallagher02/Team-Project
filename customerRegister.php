<?php

    // include the header
    include("header.php");
?>
<!-- form to add customer to the customer table in hotel database -->
<div class="containerReg">

<form action="customerRegister.php" method="POST">
    
        <h1>Registration Form</h1>
        <hr>
        <h1>Please fill in this form to create an account.</h1>
        <!-- customer registration fields -->
        <label for="firstname"><b>Name</b></label></br>
        <input type="text" placeholder="Enter First Name" name="firstname" id="firstname" required=""></br>

        <label for="surname"><b>Surname</b></label></br>
        <input type="text" placeholder="Enter Surname" name="surname" id="surname" required=""></br>
        <label for="login"><b>Login</b></label></br>
        <input type="text" placeholder="Enter Login" name="login" id="login" required=""></br>

        <label for="password"><b>Password</b></label></br>
        <input type="password" placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" name="password" id="password" required=""></br>

        <label for="email"><b>Email</b></label></br>
        <input type="email" placeholder="Enter Email" name="email" id="email" required=""></br>

        <label for="phonenumber"><b>Phone Number</b></label></br>
        <input type="text" placeholder="Enter Phone Number" pattern="[0-9]{10}" maxlength="10" name="phonenumber" id="phonenumber" required title="enter your 10 digit phone number"></br>

        
        <!-- paragraph about TOS and submit button -->
        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
        <button type="submit" class="field" id="custRegisterButton" name="custRegisterButton">Register</button>
    </div>
    <!-- If customer already have an account they can go back and log in at -->
    <p>Already have an account:</p>
    <div class="containerSignin">
        
        <a href="customerLogin.php">Sign in</a>
    </div>
    <br>
</form>
<?php

    // if the funny button is pressed
    if(isset($_POST['custRegisterButton'])) {
        // get values from post
        $login = $_POST['login'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];
        $firstname = $_POST['firstname'];
        $surname = $_POST['surname'];

        // create sql select to check if login is already in db
        $select = mysqli_query($conn, "SELECT * FROM customer where CustomerLogin = '$login';");
        if (mysqli_num_rows($select) > 0) {
            echo '<script type="text/javascript">';
            echo 'alert("User is taken! Try Again!");';
            echo 'window.location.href = "customerRegister.php";';
            echo '</script>';
        } else {
            // create sql statement
            $sql = "INSERT INTO customer (CustomerLogin, CustomerPassword, CustomerEmail, CustomerName, CustomerSurname, CustomerPhoneNum)
                    VALUES ('$login', '$password', '$email', '$firstname', '$surname', '$phonenumber');";
            // run sql query
            $query = mysqli_query($conn, $sql);
            // if successful then good else bad
            if($query) {
                echo '<script type="text/javascript">';
                echo 'alert("Successfully Registered! You can now Login!");';
                echo 'window.location.href = "customerLogin.php";';
                echo '</script>';
            } else {
                echo '<script type="text/javascript">';
                echo 'alert("There was an Error! Try again!");';
                echo 'window.location.href = "customerRegister.php";';
                echo '</script>';
            }
        }
    }
    // include the footer
    include("footer.php");
    
?>