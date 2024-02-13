<?php
require "../classes/Users.php";
// use classes\users\userLogin as userLogin;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = validation();
    // make token for user
    $string = md5(rand());
    $token = substr($string, 0, 32);
    $signUp = new Users();
    $signUp->signUp($input[0], $input[1], $input[2], $input[3], $input[4], $input[5], $input[6], $input[7], $token);
}

function validation()
{
    $name = $email = $password = $conf_password = $phone = $type = $id = $storeName = $tax = "";

    if (empty($_POST["name"])) {
        header("Location:signup_page.php?error=Name is required");
        exit();
    } else {
        $name = test_input($_POST["name"]);
    }

    if (empty($_POST["email"])) {
        header("Location:signup_page.php?error=Email is required");
        exit();
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location:signup_page.php?error=Invalid email fomat");
        exit();
        }
    }

    if (empty($_POST["password"])) {
        header("Location:signup_page.php?error=Password is required");
        exit();
    } else {
        $password = test_input($_POST["password"]);
        $password = md5($password);
    }

    if (empty($_POST["conf_password"])) {
        header("Location:signup_page.php?error=Confirm Password");
        exit();
    } else {
        $conf_password = test_input($_POST["conf_password"]);
        $conf_password = md5($conf_password);
        if($password != $conf_password){
            header("Location:signup_page.php?error=Password not same");
            exit();
        }
    }

    if (empty($_POST["phone"])) {
        header("Location:signup_page.php?error=Phone is required");
        exit();
    } else {
        $phone = test_input($_POST["phone"]);
        $pattern = "/^(\+201)((0)|(1)|(2)|(5))\d{8}$/";
        if(!preg_match($pattern, $phone)){
            header("Location:signup_page.php?error=Invalid phone no");
            exit();
        }
    }

    if (!isset($_POST['radio'])) {
        header("Location:signup_page.php?error=Check the radio button");
        exit();
    } else {
        $type = $_POST["radio"];
    }

    if($type === 'vendor'){
        if (empty($_POST["id"])) {
            header("Location:signup_page.php?error=National id is required");
            exit();
        } else {
            $id = test_input($_POST["id"]);
        }

        if (empty($_POST["storeName"])) {
            header("Location:signup_page.php?error=Store name is required");
            exit();
        } else {
            $storeName = test_input($_POST["storeName"]);
        }

        if (empty($_POST["tax"])) {
            header("Location:signup_page.php?error=Tax no is required");
            exit();
        } else {
            $tax = test_input($_POST["tax"]);
        }
    }

    return [$name, $email, $password, $phone, $type, $id, $storeName, $tax];
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>