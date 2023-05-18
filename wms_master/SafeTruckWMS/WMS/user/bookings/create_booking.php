<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "c")){
    header("Location: ../../login/login.php");
  }
  include '../../modules/cust_nav_top.php';
  include '../../modules/footer.php';
  if(isset($_POST["workshop_id"])){
    $workshop_id = $_POST["workshop_id"];
  }else{
    $workshop_id = 1;
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Enter Details</title>
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
              <div class="row">
                  <div class="col-md-12 grid-margin stretch-card">
                      <div class="card">
                          <div class="card-body">
                          <h4 class="card-title">Enter Details</h4>
                          <h5>Please allow location access and refresh if location is not obtained</h5>
                          <h6 id="location_access" class=""></h6>

                          <form class="forms-sample" method="POST" action="confirm_booking.php">
                              <div class="form-group">
                                  <label for="vehicle_plate">Vehicle Plate</label>
                                  <input type="text" class="form-control" id="vehicle_plate" name="vehicle_plate" placeholder="QW 1234 AS" required>
                              </div>
                              <div class="form-group">
                                  <label for="vehicle_make">Vehicle Make</label>
                                  <input type="text" class="form-control" id="vehicle_make" name="vehicle_make" placeholder="Toyota" required>
                              </div>
                              <div class="form-group">
                                  <label for="description">Problem</label>
                                  <input type="text" class="form-control" id="description" name="description" placeholder="The vehicle can't start" required>
                              </div>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="hidden" class="form-check-input" name="pickup" value="0">
                                  <input type="checkbox" class="form-check-input" name="pickup" value="1">
                                      Require pickup of your vehicle
                                  <i class="input-helper"></i></label>
                              </div>
                              <input type="hidden" name="workshop_id" value="<?php echo $workshop_id; ?>">
                              <input type="hidden" id="customer_lng" name="customer_lng" value="">
                              <input type="hidden" id="customer_ltd" name="customer_ltd" value="">
                              <button type="submit" class="btn btn-primary me-2" id="submit">SUBMIT</button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <!-- plugins:js -->
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- End custom js for this page-->
</body>

<script>
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, errorCallback);
    document.getElementById("location_access").className  = "text-success";
    document.getElementById("location_access").innerHTML = "Location obtained";
    document.getElementById("submit").disabled = false;
}else{
  document.getElementById("location_access").className  = "text-danger";
  document.getElementById("location_access").innerHTML = "Location not obtained";
  document.getElementById("submit").disabled = true;
}

function showPosition(position) {
    document.getElementById("customer_lng").value = position.coords.longitude;
    document.getElementById("customer_ltd").value = position.coords.latitude;
    console.log(position.coords.longitude);
    console.log(position.coords.latitude);
}

function errorCallback(error) {
  console.log("Error occurred while getting the user's location: " + error.message);
  document.getElementById("location_access").className  = "text-danger";
  document.getElementById("location_access").innerHTML = "Location not obtained";
  document.getElementById("submit").disabled = true;
}
</script>
