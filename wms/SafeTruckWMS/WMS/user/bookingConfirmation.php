<?php
/*
fill form
choose broadcast or specific ws
*/
//session_start();
//$customer_id = $_SESSION['id'];
//for testing
$customer_id = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Star Admin2 </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../../vendors/select2/select2.min.css">
  <link rel="stylesheet" href="../../vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
</head>

<?php include "bookingCustomerQueries.php";?>

<?php
$customer_id = $_POST['customer_id'];
if($_POST['workshop_id'] == 'null'){
    $workshop_id = NULL;
}else{
    $workshop_id = $_POST['workshop_id'];
}
$vehicle_plate = $_POST['vehicle_plate'];
$vehicle_make = $_POST['vehicle_make'];
$customer_lng = $_POST['customer_lng'];
$customer_ltd = $_POST['customer_ltd'];
$description = $_POST['description'];
$accepted_status = 'pending';
CreateBooking($customer_id, $workshop_id, $vehicle_plate, $vehicle_make, $customer_lng, $customer_ltd, $description, $accepted_status);
//add redirect to booking list page here
?>
<body>
<p>You will be redirected in 3 seconds</p>
    <script>
        var timer = setTimeout(function() {
            window.location='viewCustomerBooking.php'
        }, 3000);
    </script>
</body>