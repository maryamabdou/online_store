<?php
require "../classes/Vendors.php";
require "upload.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $img_name = validation();
    $product_id = $_POST["product_id"];
    $add = new Vendors();
    $add->change_photo($img_name, $product_id);
}

function validation()
{
    $img_name = "";
    $type = "change";
    $img = new upload();
    $img_name = $img->upload_image($type);
    
    return $img_name;
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>