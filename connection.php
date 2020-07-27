<?php
//connect to Database

$db = mysqli_connect('localhost', 'root', '' , 'userdb');/*!<Connecting to MySQL Server*/

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
