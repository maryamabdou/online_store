<?php
require "../classes/Users.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        header("Location:reset_page.php?error=Email is required");
        exit();
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location:reset_page.php?error=Invalid emial format");
            exit();
        }
    }
    $_SESSION['reset_email'] = $email;
    $message = "<b>To reset your password </b>
                            <a href=\"http://localhost/store/login/reset_page.php\">Click Here</a>";
    $subject = 'Reset Password';
    $send = new Users();
    $send->send_mail($email, $message, $subject);
    
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>