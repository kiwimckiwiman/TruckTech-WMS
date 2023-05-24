<?php
include '../../../queries/inventory_queries.php';
session_start();
if(isset($_SESSION["item_id"])) {
  DeleteItem($_SESSION['workshop_id'], $_SESSION["item_id"]);
  header("Location:view_items.php?pages=1");
}else{
  header("Location:view_items.php?pages=1");
}
?>
