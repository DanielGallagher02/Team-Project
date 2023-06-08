<?php

    // start session and connect to the hotel database
    session_start();
    // include the header
    include('header.php');

    // select statement and run it
    $sql = "SELECT * FROM room;";
    $result = mysqli_query($conn, $sql);

?>

<!-- form to add customer to the customer table in hotel database -->
<div class="containerReg">
<form action="roomCRUDcreate.php" method="POST">
    
        <h1>Please fill in this form to create a room.</h1><hr>
        <!-- room creation form -->
        <label for="RoomNUM"><b>Room Number</b></label></br>
        <input type="text" placeholder="Enter Room Number" name="RoomNUM" id="RoomNUM" required=""></br>

        <label for="RoomPrice"><b>Room Price</b></label></br>
        <input type="text" placeholder="Enter Room Price" name="RoomPrice" id="RoomPrice" required=""></br>

        <label for="NumberOfRooms"><b>NumberOfRooms</b></label></br>
        <input type="text" placeholder="Enter Number Of Rooms" name="NumberOfRooms" id="NumberOfRooms" required=""></br>

        <label for="RoomDesc"><b>Room Description</b></label></br>
        <input type="text" placeholder="Enter Room Description" name="RoomDesc" id="RoomDesc" required=""></br>

        <label for="RoomType"><b>Room Type</b></label></br>
        <input type="text" placeholder="Enter Room Type" name="RoomType" id="RoomType" required=""></br>

        <button type="submit" class="field" id="createRoom" name="createRoom">Create Room</button>
    
    <br>
</form>
</div>
<?php

    // if the funny button is pressed
    if(isset($_POST['createRoom'])) {
        // get values from post
        $room = $_POST['RoomNUM'];
        $price = $_POST['RoomPrice'];
        $numofrooms = $_POST['NumberOfRooms'];
        $desc = $_POST['RoomDesc'];
        $type = $_POST['RoomType'];

        // create sql select to check if login is already in db
        $select = mysqli_query($conn, "SELECT * FROM room where RoomNUM = '$room';");
        if (mysqli_num_rows($select) > 0) {
            echo '<script type="text/javascript">';
            echo 'alert("Room Already Exists! Try Again!");';
            echo 'window.location.href = "roomCRUDcreate.php";';
            echo '</script>';
        } else {
            // create sql statement
            $sql = "INSERT INTO room (RoomNUM, RoomPrice, NumberOfRooms, RoomDescription, RoomType)
                    VALUES ('$room', '$price', '$numofrooms', '$desc', '$type');";
            // run sql query
            $query = mysqli_query($conn, $sql);
            // if successful then good else bad
            if($query) {
                echo '<script type="text/javascript">';
                echo 'alert("Successfully Created the room!");';
                echo 'window.location.href = "roomCRUD.php";';
                echo '</script>';
            } else {
                echo '<script type="text/javascript">';
                echo 'alert("There was an Error! Try again later!");';
                echo 'window.location.href = "roomCRUD.php";';
                echo '</script>';
            }
        }
    }
    // include the header
    include('footer.php');

?>