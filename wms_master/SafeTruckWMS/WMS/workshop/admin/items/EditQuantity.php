<?php
    include "inventory_queries.php";
    session_start();
    if(isset($_POST['item_id'])){
        $workshop = $_POST['workshop_id'];
        $item_id = $_POST['item_id'];
        $quantity = $_POST['quantity'];
        addStockPerItem($workshop,$item,$quantity);
    }

?>