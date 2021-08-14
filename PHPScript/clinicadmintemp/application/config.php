<?php
$conn = mysqli_connect("localhost","root","","ktemplat_restaurantfinder");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?> 