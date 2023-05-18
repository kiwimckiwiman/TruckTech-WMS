<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "c")){
    header("Location: ../../login/login.php");
  }
  include '../../queries/booking_queries_customer.php';

  if(isset($_POST["workshop_id"])){
    $workshop_id = $_POST["workshop_id"];
  }
  $vehicle_plate = $_POST['vehicle_plate'];
  $vehicle_make = $_POST['vehicle_make'];
  if(isset($_POST['customer_lng'])){
    $customer_lng = $_POST['customer_lng'];
  }
  if(isset($_POST['customer_ltd'])){
    $customer_ltd = $_POST['customer_ltd'];
  }
  $description = $_POST['description'];
  $pickup = $_POST['pickup'];
  $accepted_status = 'Pending';
  CreateBooking($_SESSION["id"], $workshop_id, $vehicle_plate, $vehicle_make, $customer_lng, $customer_ltd, $description, $pickup, $accepted_status);
  header('Location:view_bookings.php?pages=1')
?>
