<?php
include "jobWorkshopQueries.php";
session_start();
if (isset($_POST['jobId'])) {
  $jobId = $_POST['jobId'];
  DeleteJob($jobId); // Call the DeleteJob function passing the jobId
}
?>