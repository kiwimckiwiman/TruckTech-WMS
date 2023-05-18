<?php
session_start();
include '../../../queries/inventory_queries.php';
include '../../../queries/job_queries.php';

  if(isset($_POST["stepDescr"])){
    $stepDescr = $_POST['stepDescr'];
    if($_POST["id"] == 0){
      $item_id = null;
    }else{
      $item_id = $_POST['id'];
    }
    $quantity = $_POST['quantity'];
    $comment = $_POST['comment'];
    $job_id = $_SESSION['job_id'];
    $totalPrice = GetItem($_SESSION['workshop_id'], $item_id)['price']* $quantity;
    $worker_id = $_SESSION["id"];
    $finish = 0;

    AddStep($job_id, $stepDescr, $worker_id, $comment, $item_id, $quantity, $totalPrice, $finish);
  }




 ?>
