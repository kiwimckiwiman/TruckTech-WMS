<?php
include "queries.php";
session_start();
if(isset($_POST['worker_id'])) {
  $workerId = $_POST['worker_id'];
  $boolean = $_POST['access_mode'];
  $module = $_POST['access_name'];
  if($module =="Inventory"){
    ChangeInventoryAccess($workerId,$boolean);
  }else if($module =="Job"){
    ChangeJobAccess($workerId,$boolean);
  }
  
}
?>