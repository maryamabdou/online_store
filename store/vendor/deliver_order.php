<?php
require("../classes/Vendors.php");
$order_id = $_GET['order_id'];
$order = new Vendors();
$order->deliver_order($order_id);
?>