<?php
include "jobWorkshopQueries.php";
session_start();
if(isset($_POST['jobId'])) {
  $jobId = $_POST['jobId'];
  deleteItem($jobId);
}
?>