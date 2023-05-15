<?php
  include '../../../queries/worker_queries.php';
  if(isset($_POST["type"])){
    UpdateAccess($_POST["type"], $_POST["id"]);
    header("Location:view_worker.php?id=".$_POST["id"]);
  }
?>
