<?php
  session_start();
  include '../../../queries/job_queries.php';
  DeleteJob($_SESSION["job_id"]);
  header("Location:view_jobs.php?pages=1");
 ?>
