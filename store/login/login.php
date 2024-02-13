<?php
require "../classes/Users.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = validation();
    $remeber = false;
    if(isset($_POST["remeber"])){
        $remeber = true;
    }
    $login = new Users();
    $login->login($input[0], $input[1], $input[2], $remeber);
}

function validation()
{
    $login = $password = $type = "";

    if (empty($_POST["login"])) {
        header("Location:login_page.php?error=Email or phone is required");
        exit();
    } else {
        $login = $_POST["login"];
        if(is_numeric($login)){
            // $pattern = "/^(01)([0-2]){1}[0,9]{8}$/";
            // $pattern = "/^(\+201)\d{9}$/";
            $pattern = "/^(\+201)((0)|(1)|(2)|(5))\d{8}$/";
            if(!preg_match($pattern, $login)){
                header("Location:login_page.php?error=Invalid phone no");
                exit();
            }
        }
        else{
            if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
                header("Location:login_page.php?error=Invalid email format");
                exit();
            }
        } 
    }

    if (empty($_POST["password"])) {
        header("Location:login_page.php?error=Password is required");
        exit();
    } else {
        $password = test_input($_POST["password"]);
        $password = md5($password);
    }

    if (!isset($_POST['radio'])) {
        header("Location:login_page.php?error=Check the radio button");
        exit();
    } else {
        $type = $_POST["radio"];
    }

    return [$login, $password, $type];
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function remember(){
    if(isset($_POST["remeber"])){
        $string = md5(rand());
        $token = substr($string, 0, 32);
        return $token;
    }
    else{
        return NULL;
    }
}

?>