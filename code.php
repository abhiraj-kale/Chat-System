<?php 
require 'connect.inc.php';
ob_start();
session_start();
$_SESSION['username'];
$_SESSION['password']; 
$_SESSION['email'];
$_SESSION['logged_in'];
$_SESSION['receiver'];
$_SESSION['id'];

if($_SESSION['logged_in']==false){
    header('Location: index.php');
};
global $conn;
if (isset($_POST['msg']) && !empty($_POST['msg'])) {
    global $conn;
    $msg =  mysqli_real_escape_string($conn, $_POST['msg']);
    $id = $_SESSION['id'];
    $receiver = $_SESSION['receiver'];

    $query="INSERT INTO chat(sender, receiver, message) VALUES($id, $receiver , '$msg')";
    if ($conn->query($query) === TRUE) {
        global $conn;
        $q = "SELECT message_id FROM chat WHERE sender=$id ORDER BY message_id DESC LIMIT 1;";
        if ($result = mysqli_query($conn,$q)) {
            $row = mysqli_fetch_assoc($result);
            $message_id = $row['message_id'];
            echo "<tr><td><div class='send_message' id='$message_id'><p>$msg</p></div></td></tr>";
        } else{
            echo "Failure";
        }       
    }else {
        echo "failure";
    }
    $conn->close();
}

if (isset($_POST['receive_id']) && !empty($_POST['receive_id'])) {
    global $conn;
    $receive_id = $_POST['receive_id'];
    $receiver = $_SESSION['receiver'];
    $q = "SELECT message_id,message FROM chat WHERE sender=$receiver AND receiver=".$_SESSION['id']." ORDER BY message_id DESC LIMIT 1";
    if ($result = mysqli_query($conn,$q)) {
        if(mysqli_num_rows($result)==1){
            $row = mysqli_fetch_assoc($result);
            $message_id = $row['message_id'];
            $msg = $row['message']; 
            if($receive_id != $message_id ){
                echo "<tr><td><div class='receive_message' id='$message_id'><p>$msg</p></div></td></tr>";
            }
        }
        
    }
    $conn->close();
}

if (isset($_POST['get_convo']) && !empty($_POST['get_convo'])) {
    $id = $_SESSION['id'];
    $receiver = $_POST['get_convo'];
    $_SESSION['receiver'] = $receiver;
    $query = "SELECT sender,message_id,message FROM chat WHERE (sender=$id AND receiver=$receiver)OR(sender=$receiver AND receiver=$id) ORDER BY message_id";
    if ($result = mysqli_query($conn,$query)) {
        while($row = mysqli_fetch_assoc($result)){
            if (mysqli_num_rows($result)>=0) {
                $message_id = $row['message_id'];
                $msg = $row['message'];
                if ($row['sender']==$id) {
                    echo "<tr><td><div class='send_message' id='$message_id'><p>$msg</p></div></td></tr>";
                }else if($row['sender']==$receiver){
                    echo "<tr><td><div class='receive_message' id='$message_id'><p>$msg</p></div></td></tr>";
                }
            }
        }
    }
    $conn->close();
}

if (isset($_GET['text']) && !empty($_GET['text'])) {
    $query = "SELECT id,username FROM `user_info` WHERE username LIKE '%".$_GET['text']."%' ";
    if ($result = mysqli_query($conn,$query)) {
    while($row = mysqli_fetch_assoc($result)){
        if (mysqli_num_rows($result)>0) {
            if($row['id']!=$_SESSION['id']){
                echo   "<div class='inbox_messsage' id='inbox_messsage'>
                <label class='message_name' id='".$row['id']."'>".$row['username']."</label>
                </div>";
            }
        }else {
            echo "<label>No results found.</label>";
        }
       }
      }
      $conn->close();
    }

    if (isset($_POST['logout']) && !empty($_POST['logout'])) {
        $query = "UPDATE user_info SET status='Inactive' WHERE id = ".$_SESSION['id']."";
        if ($conn->query($query) === TRUE) {
            $_SESSION['logged_in'] = false;
            echo true;
        }else{
            echo false;
        }
    }

?>