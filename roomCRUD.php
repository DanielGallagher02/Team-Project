<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // start session and connect to the hotel database
    session_start();
    // include the header
    include('header.php');

    // select statement and run it
    $sql = "SELECT * FROM room;";
    $result = mysqli_query($conn, $sql);

?>

<div id="container">
<div class="staffLog">
    <hr>
    <h1>Welcome to the Staff Hub, <?php echo $_SESSION['staffusername']; ?>!</h1>
    Click <a href="staffHub.php">here</a> to go back to the Staff Hub!
    <hr>
    <h1>List of Rooms:</h1>
    
    Click <a href="roomCRUDcreate.php">here</a> to create a room!<br>
    <?php

        // html table and table headers
        echo "<form action='roomCRUD.php' method='POST'>";
        echo "<table>";
        echo "<tr><th>Room Number</th><th>Room Price</th><th>People per Room</th><th>Room Description</th><th>Room Type</th><th colspan='2'>Operations</th></tr>";
        // loop over $result data
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $RoomNUM = $row["RoomNUM"];
                $RoomPrice = $row["RoomPrice"];
                $NumberOfRooms = $row["NumberOfRooms"];
                $RoomDesc = $row["RoomDescription"];
                $RoomType = $row["RoomType"];
                echo "<tr>";
                echo "<td><input type='number' placeholder='' name='RoomNUM[$RoomNUM]' value='$RoomNUM' required=''></td>";
                echo "<td><input type='number' placeholder='' name='RoomPrice[$RoomNUM]' value='$RoomPrice' required=''></td>";
                echo "<td><input type='number' placeholder='' name='NumberOfRooms[$RoomNUM]' value='$NumberOfRooms' required=''></td>";
                echo "<td><input type='text' placeholder='' name='RoomDesc[$RoomNUM]' value='$RoomDesc' required=''></td>";
                echo "<td><select id='Roomtype' placeholder='' name='RoomType[$RoomNUM]' required=''>";
                echo   "<option value='$RoomType'>$RoomType</option>";
                echo   "<option value='Single'>Single</option>";
                echo   "<option value='Double'>Double</option>";
                echo   "<option value='Family'>Family</option>";
                echo "</select>";
                echo "</td>";
                echo "<td><input type='submit' value='Update!' id='update' name='update'></td>";
                echo "<td><input type='submit' value='Delete!' id='delete' name='delete[$RoomNUM]'></td>";
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
    foreach($_POST['RoomNUM'] as $room => $value) {
        // get values from post
        $room = mysqli_real_escape_string($conn, $_POST['RoomNUM'][$room]);
        $price = mysqli_real_escape_string($conn, $_POST['RoomPrice'][$room]);
        $numofrooms = mysqli_real_escape_string($conn, $_POST['NumberOfRooms'][$room]);
        $desc = mysqli_real_escape_string($conn, $_POST['RoomDesc'][$room]);
        $type = mysqli_real_escape_string($conn, $_POST['RoomType'][$room]);

        // create sql statement
        $sql = "UPDATE room
                SET RoomNUM = '$room', RoomPrice = '$price', NumberOfRooms = '$numofrooms',
                RoomDescription = '$desc', RoomType = '$type'
                WHERE RoomNUM = '$room'";
        // run sql query
        $query = mysqli_query($conn, $sql);
        // if successful then good else bad
        if($query) {
            echo '<script type="text/javascript">';
            echo 'alert("The room was successfully edited!");';
            echo 'window.location.href = "roomCRUD.php";';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("There was an Error! Try again!");';
            echo 'window.location.href = "roomCRUD.php";';
            echo '</script>';
        }
    }
}


// if the funny delete button is pressed
if(isset($_POST['delete'])) {
    // Get the Room Number of the row to be deleted
    $roomToDelete = key($_POST['delete']);
    // sql to select
    $sql_select = "SELECT * FROM room WHERE RoomNUM='$roomToDelete'";
    // get results of select sql
    $result_select = mysqli_query($conn, $sql_select);
    // check if result is not 0
    if(mysqli_num_rows($result_select) == 0) {
        echo '<script type="text/javascript">';
        echo 'alert("Record does not exist!");';
        echo 'window.location.href = "roomCRUD.php";';
        echo '</script>';
    } else { // if exists
        // sql to delete
        $sql_delete = "DELETE FROM room WHERE RoomNUM='$roomToDelete'";
        // if deletes, good
        if(mysqli_query($conn, $sql_delete)) {
            echo '<script type="text/javascript">';
            echo 'alert("Record deleted successfully!");';
            echo 'window.location.href = "roomCRUD.php";';
            echo '</script>';
        } else { // if not, bad
            echo '<script type="text/javascript">';
            echo 'alert("There was an Error! Try again!");';
            echo 'window.location.href = "roomCRUD.php";';
            echo '</script>';
        }
    }
}

include('footer.php');
?>