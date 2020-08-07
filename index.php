<?php
require 'connect.inc.php';
ob_start();
session_start();

$_SESSION['username']='';
$_SESSION['password']='';
$_SESSION['email']='';
$_SESSION['id']='';
$_SESSION['receiver']='';
$_SESSION['logged_in'] = false;
$_SESSION['account_exists'] = false;
global $conn;
if(isset($_POST['sign_username'])&&isset($_POST['sign_password'])&&isset($_POST['sign_email'])){
    if (!empty($_POST['sign_username'])&&!empty($_POST['sign_password'])&&!empty($_POST['sign_email'])) {
        global $conn;
        $username = mysqli_real_escape_string($conn,$_POST['sign_username']);
		$email = mysqli_real_escape_string($conn,$_POST['sign_email']);
        $password =  hash("sha256",mysqli_real_escape_string($conn,$_POST['sign_password']));
        $query="SELECT id,username,email,password FROM user_info WHERE email='$email'";

		if ($result = mysqli_query($conn,$query)) {
            if(mysqli_num_rows($result)>=1){
				echo "<center>Account already exists.</center>";
			}else{
					//Insert into table
					$_SESSION['account_exists'] = false;	
					
					$sql = "INSERT INTO user_info (username, password,email) VALUES ('$username', '$password', '$email')";
	
					if ($conn->query($sql) === TRUE) {
						
						$q = "UPDATE user_info SET status='Active' WHERE username = '$username'";

						if ($conn->query($q) === TRUE) {
							  $_SESSION['logged_in'] = true;
                              $_SESSION['username']=$username;
                              echo "Created";
							  header('Location: ./chat.php');
						} else {
						 echo "<center>Couldn't create account/center> ";
						}
					} else {
					    header('Location: index.php');
					}
			}
        }else {
            echo "<center>Error</center>";
        }
        
    }else {
        echo "<center>Fields can't be empty.</center>";
    }
}
if(isset($_POST['log_username'])&&isset($_POST['log_password'])){
    if (!empty($_POST['log_username'])&&!empty($_POST['log_password'])) {
        global $conn;
        $username = mysqli_real_escape_string($conn,$_POST['log_username']);
		$email = mysqli_real_escape_string($conn,$_POST['log_username']);
        $password =  hash("sha256",mysqli_real_escape_string($conn,$_POST['log_password']));

        // Retrieving data from the databsee
	 $query="SELECT id,username,email,password FROM user_info WHERE username='$username' OR email='$email'";
     //Checking if account exists
         if ($result = mysqli_query($conn,$query)) {
             if(mysqli_num_rows($result)==0){
                echo "<center>Account does NOT exist.</center>";
             }else if (mysqli_num_rows($result)==1) {
                $row = mysqli_fetch_assoc($result);
                if ($password == $row['password']) {
                   $q = "UPDATE user_info SET status='Active' WHERE username = '$username'";

                   if ($conn->query($q) === TRUE) {
                        $_SESSION['logged_in'] = true;
                        $_SESSION['username']=$username;
                        header('Location: ./chat.php');
                   } else {
                    echo "<center>Couldn't Log In</center> ";
                   }

                }else {
                    echo "<center>Invalid Password.</center> ";
                }
           }
        }
    }else {
        echo "<center>Fields can't be empty.</center>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat System</title>
    <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
    <center><h1 id="head">Chat System</h1></center>
    <label style="float: right;">~ Created By <a href="https://github.com/abhiraj-kale">Abhiraj Kale</a></label>
<div class="login-page">
  <div class="form">
    <form class="register-form" action="index.php" method="POST">
    <h2>Register</h2>
    <center>New? Create an account</center><br>
      <input name="sign_username" type="text" placeholder="name" minlength="8"/>
      <input name="sign_password" type="password" placeholder="password" minlength="8"/>
      <input name="sign_email" type="email" placeholder="email address"/>
      <button><submit>create</submit></button>
    </form>
    </div>
    <div class="form">
    <form class="login-form" action="index.php" method="POST"> 
    <h2>Login</h2>
    <center>Already have an account? Log in</center><br>
      <input name="log_username" type="text" placeholder="username/email"/>
      <input name="log_password" type="password" placeholder="password"/>
       <button><submit>login</submit></button>
    </form>
  </div>
  <br>
</div>

<script src="js/jquery.js"></script>
<script src="js/index.js"></script>
</body>
</html>