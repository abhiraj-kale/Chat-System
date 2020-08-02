<?php
$servername = "fdb30.awardspace.net";
$username = "3529139_chatsystem";
$password = "abhiraj123";
$dbname = "3529139_chatsystem";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection went wrong: " . $conn->connect_error); 
  } 
  
?>