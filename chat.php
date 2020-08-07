<?php 
require 'connect.inc.php';
ob_start();
session_start();
$_SESSION['username'];
$_SESSION['password']; 
$_SESSION['email'];
$_SESSION['logged_in'];
$_SESSION['receiver'] = null;
$_SESSION['id'];

if($_SESSION['logged_in']==false){
    header('Location: index.php');
};
global $conn;
$query="SELECT id FROM user_info WHERE username='".$_SESSION['username']."' OR email='".$_SESSION['username']."'";
   if ($result = mysqli_query($conn,$query)){
       $row = mysqli_fetch_assoc($result);
		 $_SESSION['id'] = $row['id'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="stylesheet/chat.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>
<body>
    <div class="center">
     <div>
         <div class="inbox">
             <div class="inbox-head">
                <label id="l1">Chat System</label><br>
                <label id="l2">Inbox</label> <button class="logout">Log Out</button>
             </div>
             <input type="search" placeholder="Search or start new chat" class="search">
             <div class="unread_lists">

             </div>
             <div class="in_list">

                <br>
                Enter the username you want to chat with
             </div>            
         </div>
         <div class="chatbox">
                <div class="convo_name" id="">
                    <label></label>
                    <center><label style="font-size:20px;color:gray"></label></center>
                </div>
                <div class="convo">
                    <table>
                    <tr style="display: none;"><td><div class='' id=''><p></p></div></td></tr>
                    </table>
                 </div>
                <div class="type-div"><textarea id="type" class="type" placeholder="Type your message here" maxlength="150"></textarea></div>
                <div class="send-div"><input class="send-msg" type="button" value="Send" disabled></div>            
         </div>
     </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/chat.js"></script>
</body>
</html>