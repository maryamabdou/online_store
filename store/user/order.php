<?php
require "../classes/Users.php";

if (isset($_POST['total'])) {
    if($_POST['total'] != 0){
        $order = new Users();
        $order->buy_product($_POST['total']);
    }
    else{
        header("Location:user_page.php?error=The cart is empty");
        exit();
    }
    
}
?>