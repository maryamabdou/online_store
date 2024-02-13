<?php 
if(isset($_COOKIE["token"])){
    unset($_COOKIE['token']); 
    setcookie('token', '', -1, '/'); 
}
session_start();
session_unset();
session_destroy();

header("Location:homePage.html");
?>