<?php
include "inventory_queries.php";
$item_name = $_POST['itemname'];
$item_id = $_POST['item_id'];
$workshop_id= $_POST['workshop_id'];
$desc= $_POST['itemdescription'];
$price = $_POST['price'];
$min_stock = $_POST['min_stock'];
$quantity = $_POST['quantity'];
UpdateItem($_POST);





?>