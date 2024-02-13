<?php
if(isset($_POST['search'])){
    $search = $_POST['search'];
    header("Location:../user/categ_product_page.php?id=$search");
    exit();
}
?>