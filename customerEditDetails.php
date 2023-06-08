<div class="containerReg">
<?php

    // start session and connect to the hotel database
    session_start();

    // include the header
    include('header.php')

?>

<style>
/*Styling for icons beside the password textbox*/
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
    right: 30px;
}

.question-icon {
    right: 5px;
}
</style>

<h1>Welcome to the details editing section, <?php echo $_SESSION['customerusername']; ?>!</h1>
<!-- Customer Hub button -->
<form action="customerHub.php" method="post" style="display: inline;">
    <input type="submit" value="Back to Customer Hub" class="btn btn-green">
</form>

<!-- Button style -->
<style>
    .btn {
        display: inline-block;
        color: white;
        text-align: center;
        font-size: 14px;
        padding: 10px 20px;
        margin: 10px 2px;
        cursor: pointer;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        transition-duration: 0.4s;
    }

    .btn-green {
        background-color: #008000;
    }

    .btn:hover {
        opacity: 0.8;
    }
</style>

<form action="customerEditDetails.php" method="POST">
    <div class="container">
        <h1>Account Edit Form</h1>
        <?php

            // save customer username into $getLogin
            $getLogin = $_SESSION['customerusername'];
            // select statement
            $select = mysqli_query($conn, "SELECT * FROM customer where CustomerLogin = '$getLogin';");
            // save results into $row
            $row = mysqli_fetch_assoc($select);

        ?>

        <hr>
        <h1>Please fill in this form to edit your account details.</h1>
        <!-- customer registration fields -->
        <label for="password"><b>Password</b></label></br>
        <div class="input-container">
            <input type="password" placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" name="password" id="password" value="<?php echo $row['CustomerPassword']; ?>" required="">
            <span class="password-eye" onclick="togglePasswordVisibility()"><i class="fa fa-eye"></i></span>
            <span class="password-question"><i class="fa fa-question-circle" onclick="showPasswordHelp()" title="Password must contain at least one number, one uppercase and lowercase letter, and at least 8 or more characters."></i></span>
        </div></br>

        <label for="email"><b>Email</b></label></br>
        <input type="email" placeholder="Enter Email" name="email" id="email" value="<?php echo $row['CustomerEmail']; ?>" required=""></br>

        <label for="phonenumber"><b>Phone Number</b></label></br>
        <input type="text" placeholder="Enter Phone Number" pattern="[0-9]{10}" maxlength="10" name="phonenumber" id="phonenumber" value="<?php echo $row['CustomerPhoneNum']; ?>" required title="Enter your 10  digit phone number"></br>

        <label for="firstname"><b>Name</b></label></br>
        <input type="text" placeholder="Enter First Name" name="firstname" id="firstname" value="<?php echo $row['CustomerName']; ?>" required=""></br>

        <label for="surname"><b>Surname</b></label></br>
        <input type="text" placeholder="Enter Surname" name="surname" id="surname" value="<?php echo $row['CustomerSurname']; ?>" required=""></br>

        <!-- Credit Card Information -->
        <div class='credit-card-section'>
            <h3>Credit Card Information</h3>
            <div class='credit-card-row'>
                <div><label for='credit_card'>Credit Card:</label>
                <input type='text' id='credit_card' name='credit_card' value="<?php echo $row['CreditCard']; ?>" pattern='[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}' maxlength='19' required title='Please enter your credit card number in format xxxx xxxx xxxx xxxx'></div>
                <div><label for='credit_card_expire'>Card Expire:</label>
                <input type='text' name='credit_card_expire' value="<?php echo $row['CreditCardExpire']; ?>" pattern='(0[1-9]|1[0-2])\/[0-9]{4}' maxlength='7' required title='Please enter the valid expiration date in the format MM/YYYY'></div>
            </div>
            <div class='credit-card-row'>
                <div><label for='credit_card_security'>Card Security:</label>
                <input type='text' name='credit_card_security' value="<?php echo $row['CreditCardSecurity']; ?>" pattern='[0-9]{3}' minlength='3' maxlength='3' required title='Please enter the 3-digit security code.'></div>
            </div>
        </div>

        <!-- paragraph about TOS and submit button -->
        <button type="submit" class="btn btn-green" id="custEditButton" name="custEditButton">Edit Details</button>
    </div>
    <!-- If customer already have an account they can go back and log in at -->

    <br>
</form>

<!-- JavaScript to toggle password visibility -->
<script>
    function showPasswordHelp() {
        alert("The password should be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.");
    }

function togglePasswordVisibility() {
    const passwordInput = document.getElementById("password");
    const passwordEye = document.querySelector(".password-eye i");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordEye.classList.remove("fa-eye");
        passwordEye.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        passwordEye.classList.remove("fa-eye-slash");
        passwordEye.classList.add("fa-eye");
    }
}
</script>

<?php
// if the funny button is pressed
if(isset($_POST['custEditButton'])) {
    // get values from post
    $login = $_SESSION['customerusername'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $firstname = $_POST['firstname'];
    $surname = $_POST['surname'];
    $credit_card = $_POST['credit_card'];
    $credit_card_expire = $_POST['credit_card_expire'];
    $credit_card_security = $_POST['credit_card_security'];

    // create sql statement
    $sql = "UPDATE customer
                SET CustomerPassword = '$password', CustomerEmail  = '$email', CustomerName = '$firstname',
        CustomerSurname = '$surname', CustomerPhoneNum = '$phonenumber', CreditCard = '$credit_card', CreditCardExpire = '$credit_card_expire', CreditCardSecurity = '$credit_card_security'
        WHERE CustomerLogin = '$login';";
        // run sql query
        $query = mysqli_query($conn, $sql);
        // if successful then good else bad
        if($query) {
            echo '<script type="text/javascript">';
            echo 'alert("Your account details have been successfully edited!");';
            echo 'window.location.href = "customerHub.php";';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("There was an Error! Try again!");';
            echo 'window.location.href = "customerEditDetails.php";';
            echo '</script>';
        }
    }

    // include the header
    include('footer.php')

?>