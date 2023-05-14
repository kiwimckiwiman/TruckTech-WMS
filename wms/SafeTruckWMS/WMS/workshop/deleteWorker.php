<?php
include "queries.php";
session_start();
if(isset($_POST['workerId'])) {
  $workerId = $_POST['workerId'];
  deleteWorker($workerId,$_SESSION['workshop_id']);
}
?>