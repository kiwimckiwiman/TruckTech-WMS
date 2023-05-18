<?php
include "inventory_queries.php";
session_start();
if(isset($_POST['itemId'])) {
  $itemId = $_POST['itemId'];
  deleteItem($itemId,$_SESSION['workshop_id']);
}
?>