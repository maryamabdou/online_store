<?php 
require "../classes/Users.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = validation();
    $reset = new Users();
    $reset->reset($password);
}

function validation()
{
    $password = $conf_password = "";

    if (empty($_POST["password"])) {
        header("Location:reset_page.php?error=Password is required");
        exit();
    } else {
        $password = test_input($_POST["password"]);
        $password = md5($password);
    }

    if (empty($_POST["conf_password"])) {
        header("Location:reset_page.php?error=Confirm Password");
        exit();
    } else {
        $conf_password = test_input($_POST["conf_password"]);
        $conf_password = md5($conf_password);
        if($password != $conf_password){
            header("Location:reset_page.php?error=Password not same");
            exit();
        }
    }

    return $password;
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>