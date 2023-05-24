<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "c")){
    header("Location: ../../login/login.php");
  }
  include '../../modules/cust_nav_top.php';
  include '../../modules/footer.php';
  include '../../queries/booking_queries_customer.php';
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Create Booking</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../../images/favicon.png" />
  <!-- Wokshop Modal CSS -->
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->

</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php nav_top($_SESSION["name"], $_SESSION["email"]) ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
    <?php include '../../modules/cust_nav.php'; ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row select-type-row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Select Booking Type</h4>
                  <div class="row select-type">
                    <div class="col-md-6 grid-margin stretch-card" >
                      <div class="card select-choice" id="select">
                        <div class="card-body">
                          <h3>Select a workshop</h3>
                          <h5>Choose a workshop of your choice</h5>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 grid-margin stretch-card">
                      <div class="card select-choice" id="geo">
                        <div class="card-body">
                          <h3>Find a workshop in your area</h3>
                          <h5>We choose a workshop near you</h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- plugins:js -->
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- End custom js for this page-->
</body>

<script>
var select = document.getElementById("select");
select.addEventListener("click", function() {
  window.location.href = "choose_workshops.php?pages=1";
});
var geo = document.getElementById("geo");
geo.addEventListener("click", function() {
  window.location.href = "create_booking.php";
});
</script>
