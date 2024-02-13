<?php
require "../classes/Users.php";
require "upload.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = validation();
    $add = new Users();
    $add->add_product($input[0], $input[1], $input[2], $input[3], $input[4]);
}

function validation()
{
    $name = $category = $price = $quantity = $img_src = "";

    if (empty($_POST["name"])) {
        header("Location:vendor_page.php?error=Name is required");
        exit();
    } else {
        $name = test_input($_POST["name"]);
    }

    if (empty($_POST["category"])) {
        header("Location:vendor_page.php?error=Category is required");
        exit();
    } else {
        $category = test_input($_POST["category"]);
    }

    if (empty($_POST["price"])) {
        header("Location:vendor_page.php?error=Price is required");
        exit();
    } else {
        $price = test_input($_POST["price"]);
    }

    if (empty($_POST["quantity"])) {
        header("Location:vendor_page.php?error=Quantity is required");
        exit();
    } else {
        $quantity = test_input($_POST["quantity"]);
    }
    $type = "add";
    $img = new upload();
    $img_name = $img->upload_image($type);

    return [$name, $category, $price, $quantity, $img_name];
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>