<?php
$servername = "localhost";
$username = "id14558518_abhiraj";
$password = "5xM%!RrK06ds69S}";
$dbname = "id14558518_chatsystem";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection went wrong: " . $conn->connect_error); 
  } 
  
  //$conn->close(); 
?>