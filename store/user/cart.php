<?php
session_start();
if (isset($_POST['product_id'])) {
    $product_id = [];
    foreach ($_SESSION['cart'] as $id=>$data) {
        array_push($product_id, $id);
    }

    $array = array_diff($product_id, [$_POST['product_id']]);
    $i = 0;
    $arr = [];
    foreach ($_SESSION['cart'] as $id=>$data) {
        foreach($array as $prod_id){
            if($prod_id === $id){
                $arr[$prod_id] = $data;
                $i+=1;
            }
        }
    }
    if(count($arr) != 0){
        $_SESSION['cart'] = $arr;
    }
    else{
        $_SESSION['cart'] = [];
    }
    header("Location:cart_page.php");
}

?>