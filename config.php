<?php
$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>