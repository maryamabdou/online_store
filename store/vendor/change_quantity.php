<?php
require "../classes/Vendors.php";
require "upload.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantity = validation();
    $product_id = $_POST["product_id"];
    $add = new Vendors();
    $add->change_quantity($quantity, $product_id);
}

function validation()
{
    $quantity = "";

    if (empty($_POST["quantity"])) {
        header("Location:edit_page.php?error=Quantity is required");
        exit();
    } else {
        $quantity = test_input($_POST["quantity"]);
    }
    
    return $quantity;
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>