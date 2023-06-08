<?php

    // include the header
    include('header.php')

?>

<form action="ratePage.php" method="POST">

  <div class="stars">
    <input class="star star-5" id="star-5" type="radio" name="rating" value="5"/>
    <label class="star star-5" for="star-5"></label>
    <input class="star star-4" id="star-4" type="radio" name="rating" value="4"/>
    <label class="star star-4" for="star-4"></label>
    <input class="star star-3" id="star-3" type="radio" name="rating" value="3"/>
    <label class="star star-3" for="star-3"></label>
    <input class="star star-2" id="star-2" type="radio" name="rating" value="2"/>
    <label class="star star-2" for="star-2"></label>
    <input class="star star-1" id="star-1" type="radio" name="rating" value="1"/>
    <label class="star star-1" for="star-1"></label></br>
    </br><label for="name">Name:</label>
    <input type="text" id="name" name="name"></br>
    </br><textarea class="comment" name="comment">Type your comment here.</textarea>
    <br>
    
    <input type="submit" name="submitReview" id="submitReview" value="Send">
  </div>
</form>


<!-- <form action="ratePage.php" method="POST">
    <textarea class="comment" name="comment">Type your comment here.</textarea>
    <br>
    <input type="submit" name="submitReview" id="submitReview" value="Send">
</form> -->

<?php
    if(isset($_POST['submitReview'])) {
      // get values from post
      $comment = $_POST['comment'];
      $rating = $_POST['rating'];
      $name = $_POST['name'];
  
      // create sql statement
      $sql = "INSERT INTO review (ReviewDescription, Rating, name) VALUES ('$comment', '$rating', '$name')";
  
      // run sql query
      $query = mysqli_query($conn, $sql);
  
      // if successful then good else bad
      if($query) {
          echo '<script type="text/javascript">';
          echo 'alert("Successfully saved to database!");';
          echo 'window.location.href = "ratePage.php";';
          echo '</script>';
      } else {
          echo '<script type="text/javascript">';
          echo 'alert("There was an Error! Try again!");';
          echo 'window.location.href = "ratePage.php";';
          echo '</script>';
      }
  }
  

    // retrieve all comments from the database
$sql = "SELECT Name, ReviewDescription, Rating FROM review ORDER BY DateAdded DESC";
$result = mysqli_query($conn, $sql);

// loop through the result set and display each comment
while ($row = mysqli_fetch_assoc($result)) {
  echo '<div class="comment">';
  echo '<div class="name">' . (isset($row['Name']) ? $row['Name'] : '') . '</div>';
  echo '<div class="stars">';
  for($i = 1; $i <= $row['Rating']; $i++) {
      echo '<span class="star">&#9733;</span>';
  }
  echo '</div>';
  echo '<p>' . $row['ReviewDescription'] . '</p>';
  echo '</div>';
}






    // include the footer
    include("footer.php");
?>
