<?php
session_start();
include '../../../queries/inventory_queries.php';
include '../../../queries/job_queries.php';

  if(isset($_POST["stepDescr"])){
    $stepDescr = $_POST['stepDescr'];
    if(isset($_POST["item_id"])){
      $item_id = $_POST["item_id"];
      $quantity = $_POST['quantity'];
      $totalPrice = GetItem($_SESSION['workshop_id'], $item_id)['price']* $quantity;
    }else{
      $item_id = null;
      $quantity = null;
      $totalPrice = null;
    }
    $comment = $_POST['comment'];
    $job_id = $_SESSION['job_id'];
    $finish = 0;

    AddStep($job_id, $stepDescr, $comment, $item_id, $quantity, $totalPrice, $finish);
    header("Location:view_job.php?id=".$job_id);
  }
 ?>
