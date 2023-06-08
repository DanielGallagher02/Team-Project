<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // start session and connect to the hotel database
    session_start();
    // include the header
    include('header.php');

    // select statement and run it
    $sql = "SELECT * FROM booked_extras;";
    $result = mysqli_query($conn, $sql);

    $sql2 = "SELECT * FROM extra_list;";
    $result2 = mysqli_query($conn, $sql2);

?>

<div id="container">
    <hr>
    <div class="staffLog">
    <h1>Welcome to the Extras CRUD, <?php echo $_SESSION['staffusername']; ?>!</h1>
    Click <a href="staffHub.php">here</a> to go back to the Staff Hub!
    <hr>
    <h1>List of current available extras:</h1>
    <?php

        // html table and table headers
        echo "<form action='extraCRUD.php' method='POST'>";
        echo "<table>";
        echo "<tr><th>Extra Name</th><th>Price</th><th colspan='2'>Operations</th></tr>";
        // loop over $result data
        if (mysqli_num_rows($result2) > 0) {
            while($row = mysqli_fetch_assoc($result2)) {
                $ExtraName = $row["ExtraName"];
                $ExtraPrice = $row["ExtraPrice"];
                echo "<tr>";
                echo "<td><input type='text' placeholder='' name='ExtraName[$ExtraName]' value='$ExtraName' required=''></td>";
                echo "<td><input type='number' placeholder='' name='ExtraPrice[$ExtraName]' value='$ExtraPrice' required=''></td>";
                echo "<td><input type='submit' value='Update!' id='update2' name='update2'></td>";
                echo "<td><input type='submit' value='Delete!' id='delete2' name='delete2[$ExtraName]'></td>";
                echo "</tr>";
            }
        } else {
            echo "0 results";
        }
        // end table
        echo "</table>";
        echo "<h3>Add new extra</h3>";
        echo "<label for='newExtraName'><b>Create Name:</b></label>";
        echo "<input type='text' placeholder='' name='newExtraName' value=''>";
        echo "</br><label for='newExtraPrice'><b>Set Price:</b></label>";
        echo "<input type='number' placeholder='' name='newExtraPrice' value=''>";
        echo "</br><input type='submit' value='Add new extra!' id='addNewExtra' name='addNewExtra'>";
        echo "</form>";
    ?>
    <hr>
    <hr>
    <h1>List of booked Extras:</h1>
    <?php

        // html table and table headers
        echo "<form action='extraCRUD.php' method='POST'>";
        echo "<table>";
        echo "<tr><th>Extra ID</th><th>Reservation ID</th><th>Price</th><th>Extra Description</th><th colspan='2'>Operations</th></tr>";
        // loop over $result data
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $ExtraID = $row["ExtraID"];
                $ReservationID = $row["ReservationID"];
                $ExtraPrice = $row["ExtraPrice"];
                $ExtraDesc = $row["ExtraDescription"];
                echo "<tr>";
                echo "<td><input type='text' placeholder='' name='ExtraID[$ExtraID]' value='$ExtraID' required=''></td>";
                echo "<td>$ReservationID</td>";
                echo "<td><input type='number' placeholder='' name='ExtraPrice[$ExtraID]' value='$ExtraPrice' required=''></td>";
                echo "<td><input type='text' placeholder='' name='ExtraDesc[$ExtraID]' value='$ExtraDesc' required=''></td>";
                echo "<td><input type='submit' value='Update!' id='update' name='update'></td>";
                echo "<td><input type='submit' value='Delete!' id='delete' name='delete[$ExtraID]'></td>";
                echo "</tr>";
            }
        } else {
            echo "0 results";
        }
        // end table
        echo "</table>";
        echo "</form>";
    ?>
    <hr>
</div>

<?php

if(isset($_POST['update'])) {
    // loop over each room
    foreach($_POST['ExtraID'] as $extra => $value) {
        // get values from post
        $extra = mysqli_real_escape_string($conn, $_POST['ExtraID'][$extra]);
        $price = mysqli_real_escape_string($conn, $_POST['ExtraPrice'][$extra]);
        $desc = mysqli_real_escape_string($conn, $_POST['ExtraDesc'][$extra]);

        // create sql statement
        $sql = "UPDATE booked_extras
                SET ExtraPrice = '$price', ExtraDescription = '$desc'
                WHERE ExtraID = '$extra'";
        // run sql query
        $query = mysqli_query($conn, $sql);
        // if successful then good else bad
        if($query) {
            echo '<script type="text/javascript">';
            echo 'alert("The extra was successfully edited!");';
            echo 'window.location.href = "extraCRUD.php";';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("There was an Error! Try again!");';
            echo 'window.location.href = "extraCRUD.php";';
            echo '</script>';
        }
    }
}

// if the delete button is pressed
if(isset($_POST['delete'])) {
    // Get the Extra ID of the row to be deleted
    $extraToDelete = key($_POST['delete']);
    // sql to select
    $sql_select = "SELECT * FROM booked_extras WHERE ExtraID='$extraToDelete'";
    // get results of select sql
    $result_select = mysqli_query($conn, $sql_select);
    if (!$result_select) {
        // handle SQL error
        echo "Error: " . mysqli_error($conn);
    } else if(mysqli_num_rows($result_select) == 0) {
        echo '<script type="text/javascript">';
        echo 'alert("Record does not exist!");';
        echo 'window.location.href = "extraCRUD.php";';
        echo '</script>';
    } else { // if exists
        // sql to delete
        $sql_delete = "DELETE FROM booked_extras WHERE ExtraID = '$extraToDelete'";
        // if deletes, good
        if(mysqli_query($conn, $sql_delete)) {
            echo '<script type="text/javascript">';
            echo 'alert("Record deleted successfully!");';
            echo 'window.location.href = "extraCRUD.php";';
            echo '</script>';
        } else { // if not, bad
            echo '<script type="text/javascript">';
            echo 'alert("There was an Error! Try again!");';
            echo 'window.location.href = "extraCRUD.php";';
            echo '</script>';
        }
    }
}

// updates available extras List
if(isset($_POST['update2'])) {
    // loop over each room
    foreach($_POST['ExtraName'] as $extra => $value) {
        // get values from post
        $extra = mysqli_real_escape_string($conn, $_POST['ExtraName'][$extra]);
        $price = mysqli_real_escape_string($conn, $_POST['ExtraPrice'][$extra]);

        // create sql statement
        $sql = "UPDATE extra_list
                SET ExtraPrice = '$price'
                WHERE ExtraName = '$extra'";
        // run sql query
        $query = mysqli_query($conn, $sql);
        // if successful then good else bad
        if($query) {
            echo '<script type="text/javascript">';
            echo 'alert("The extra was successfully edited!");';
            echo 'window.location.href = "extraCRUD.php";';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("There was an Error! Try again!");';
            echo 'window.location.href = "extraCRUD.php";';
            echo '</script>';
        }
    }
}

// if the delete button is pressed
if(isset($_POST['delete2'])) {
    // Get the Extra Name of the row to be deleted
    $extraToDelete = key($_POST['delete2']);
    // sql to select
    $sql_select = "SELECT * FROM extra_list WHERE ExtraName='$extraToDelete'";
    // get results of select sql
    $result_select = mysqli_query($conn, $sql_select);
    if (!$result_select) {
        // handle SQL error
        echo "Error: " . mysqli_error($conn);
    } else if(mysqli_num_rows($result_select) == 0) {
        echo '<script type="text/javascript">';
        echo 'alert("Record does not exist!");';
        echo 'window.location.href = "extraCRUD.php";';
        echo '</script>';
    } else { // if exists
        // sql to delete
        $sql_delete = "DELETE FROM extra_list WHERE ExtraName = '$extraToDelete'";
        // if deletes, good
        if(mysqli_query($conn, $sql_delete)) {
            echo '<script type="text/javascript">';
            echo 'alert("Record deleted successfully!");';
            echo 'window.location.href = "extraCRUD.php";';
            echo '</script>';
        } else { // if not, bad
            echo '<script type="text/javascript">';
            echo 'alert("There was an Error! Try again!");';
            echo 'window.location.href = "extraCRUD.php";';
            echo '</script>';
        }
    }
}
// if the add button is pressed
if(isset($_POST['addNewExtra'])) {
    // Get the Name of the row to be added
    $extraToAdd = $_POST['newExtraName'];
    $extraPrice2 = $_POST['newExtraPrice'];
    // sql to select
    $sql_select = "SELECT * FROM extra_list WHERE ExtraName='$extraToAdd'";
    // get results of select sql
    $result_select = mysqli_query($conn, $sql_select);
    if (mysqli_num_rows($result_select) > 0) {
        // extra already exists
        echo '<script type="text/javascript">';
        echo 'alert("Extra type already exists!");';
        echo 'window.location.href = "extraCRUD.php";';
        echo '</script>';
    } else { // if !exists
        // sql to add
        $sql_add = "INSERT INTO extra_list (ExtraName, ExtraPrice) VALUES ('$extraToAdd', '$extraPrice2')";
        // if adds, good
        if(mysqli_query($conn, $sql_add)) {
            echo '<script type="text/javascript">';
            echo 'alert("New extra type added successfully!");';
            echo 'window.location.href = "extraCRUD.php";';
            echo '</script>';
        } else { // if not, bad
            echo "Error: " . mysqli_error($conn);
            echo '<script type="text/javascript">';
            echo 'alert("There was an Error! Try again!");';
            echo 'window.location.href = "extraCRUD.php";';
            echo '</script>';
        }
    }
}
?>

</div>
</body>
</html>