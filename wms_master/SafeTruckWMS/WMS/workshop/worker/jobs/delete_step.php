<?php
  session_start();
  include '../../../queries/job_queries.php';
  DeleteStep($_GET["id"]);
  header("Location:view_job.php?id=".$_SESSION["job_id"]);
 ?>
