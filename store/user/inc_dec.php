<?php
session_start();
if (isset($_POST['prod_quantity'])) {
    foreach ($_SESSION['cart'] as $id=>$data) {
        if ($id == $_POST['product_id']) {
            if (isset($_POST['increment'])) {
                if($_POST['left_quantity'] != $data['qty']){
                    $data['qty'] += 1;
                }
            }
            else if (isset($_POST['decrement'])) {
                if($data['qty'] != 1){
                    $data['qty'] -= 1;
                }
            }
        }
        $_SESSION['cart'][$id] = $data;
    }
    header("Location:cart_page.php");
}
?>