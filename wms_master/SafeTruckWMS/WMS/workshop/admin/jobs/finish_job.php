<?php
session_start();

include '../../../queries/job_queries.php';

if(isset($_SESSION["job_id"])){
  FinishWorkshopJob($_SESSION["job_id"], 100);
  header("Location:view_jobs.php?pages=1");
}


 ?>
