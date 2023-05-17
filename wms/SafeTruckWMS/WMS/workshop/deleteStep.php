<?php
include "jobWorkshopQueries.php";
session_start();
  $jobId = $_POST['stepId'];
  $stepQty = $_POST['stepQty'];
  $itemId = $_POST['itemId'];
  $itemQty =$_POST['itemQty'];
  $newQty = $itemQty + $stepQty;
  AlterInventory($itemId,$newQty);
  DeleteStep($jobId);
?>