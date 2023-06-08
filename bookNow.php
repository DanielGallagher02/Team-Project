<?php

    // include the header
    include('header.php')

?>
<style>
  /* Style for the button */
  .button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 0;
    cursor: pointer;
    border-radius: 5px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.3);
  }
  
  /* Hover effect */
  .button:hover {
    background-color: #3e8e41;
  }
</style>

<div id=roomGalary1>
<h1>Welcome to our room gallery!!!</h1>
  <img src=" images/single.jpg">
  <table>
    <tr>
      <th>Apartments Type</th>
      <th>Price per Night</th>
      <th>Facilities</th>
    </tr>
    <tr>
      <td>Single Room</td>
      <td>€50-60</td>
      <td>Free parking,</br>Pool,</br> Balcony,</br>Breakfast Included,</br></td>
    </tr>
  </table>
  <a href="index.php" class="button">Book this Room!</a></br>
  <p>Double Room</p></br>
  <img src=" images/double.jpg">

  <table >
    <tr>
      <th>Apartments Type</th>
      <th>Price per Night</th>
      <th>Facilities</th>
    </tr>
    <tr>
      <td>Double Room</td>
      <td>€100-120</td>
      <td>Free parking,</br>Pool,</br> Balcony,</br>Breakfast Included</td>
    </tr>
  </table></br>
  <a href="index.php" class="button">Book this Room!</a></br>
  <img src=" images/family.jpg">
  <p>Family room</p>
  <table >
    <tr>
      <th>Apartments Type</th>
      <th>Price per Night</th>
      <th>Facilities</th>
    </tr>
    <tr>
      <td>Family Room</td>
      <td>€120-150</td>
      <td>Free parking,</br>Pool,</br> Balcony,</br>Breakfast Included</td>
    </tr>
  </table></br>
  <a href="index.php" class="button">Book this Room!</a></br>
  </tr>
  
</div>

<?php

    // include the header
    include('footer.php')

?>