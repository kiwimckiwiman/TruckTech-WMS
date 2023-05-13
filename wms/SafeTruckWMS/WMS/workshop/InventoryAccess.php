<?php
include "queries.php";
session_start();
if(isset($_POST['worker_id'])) {
  $workerId = $_POST['worker_id'];
  $boolean = $_POST['access_mode'];
  ChangeInventoryAccess($workerId,$boolean);
}
?>