<?php
include "jobWorkshopQueries.php";
session_start();
  $stepid = $_POST['stepId'];
  FinishStep($stepid);
?>