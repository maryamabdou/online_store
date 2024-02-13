<?php
require "../classes/Vendors.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $price = validation();
    $product_id = $_POST["product_id"];
    $add = new Vendors();
    $add->change_price($price, $product_id);
}

function validation()
{
    $price = "";

    if (empty($_POST["price"])) {
        header("Location:edit_page.php?error=Price is required");
        exit();
    } else {
        $price = test_input($_POST["price"]);
    }
    
    return $price;
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>