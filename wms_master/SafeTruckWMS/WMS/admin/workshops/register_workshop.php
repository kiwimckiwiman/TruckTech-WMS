<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "s")){
    header("Location: ../../login/login.php");
  }
  include '../../modules/sadmin_nav_top.php';
  include '../../modules/footer.php';
  include '../../queries/workshop_queries.php';

  if(isset($_POST['workshop_name']) && !empty($_POST['workshop_name'])){
    $name = $_POST['workshop_name'];
    $address = $_POST['address'];
    $location = $_POST['loc'];
    $opening_hours = $_POST['opening_hrs'];
    $closing_hours = $_POST['closing_hrs'];
    $specialisations = $_POST['workshop_special'];
    $phone_no = $_POST['phone_no'];
    $workshop_owner_id = $_POST['workshop_owner'];

    $coords = explode(",", $location);
    $lat = round(floatval(trim($coords[0])), 6);
    $lng = round(floatval(trim($coords[1])), 6);

    $hours = date('h:i A', strtotime($opening_hours)).' to '.date('h:i A', strtotime($closing_hours));

    $msg = AddWorkshop($name, $address, $hours, $specialisations, $phone_no, $workshop_owner_id, $lat, $lng);
  }else{
    $msg = "&#8203";
  }
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
   integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
   crossorigin=""/>

 <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
    integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
    crossorigin=""></script>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Register Workshop</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../../images/favicon.png" />
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
      <?php include '../../modules/sadmin_nav.php'; ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <?php include '../../modules/breadcrumbs_admin.php'; ?>
            </div>
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Register Workshop</h4>
                    <?php echo "<h6 class=\"text-success\">".$msg."</h6>";?>
                    <form class="forms-sample" method="POST" action="register_workshop.php">
                      <div class="form-group">
                        <label for="workshopname">Workshop Name</label>
                        <input type="text" class="form-control" id="workshopname" name="workshop_name"  required placeholder="Workshop Name">
                      </div>
                      <div class="form-group">
                        <label for="workshoplocation">Workshop Location</label>
                        <div style="display: flex;  align-items: center;">
                          <button type="button" id="search" class="btn btn-primary btn-sm" style="margin-right:20px;">SEARCH</button>
                          <input type="text" class="form-control"  id="address" name="address" required placeholder="Address or enter Latitude, Longitude">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class='col-12 grid-margin stretch-card'>
                          <div id='map' style='width:100%;height:500px;'></div>
                        </div>
                        <input type="hidden" id="loc" name="loc" required>
                      </div>
                      <div class="form-group">
                        <label for="opening_hrs">Workshop Opening Hours</label>
                        <input type="time" class="form-control"  id="opening_hrs" name="opening_hrs" required>
                      </div>
                      <div class="form-group">
                        <label for="closing_hrs">Workshop Closing Hours</label>
                        <input type="time" class="form-control"  id="closing_hrs" name="closing_hrs" required >
                      </div>
                      <div class="form-group">
                        <label for="workshop_special">Workshop Specialisation</label>
                        <input type="text" class="form-control" id="workshop_special" name="workshop_special" placeholder="Workshop Specialisation" required>
                      </div>
                        <div class="form-group">
                            <label for="phone_no">Phone Number</label>
                            <input type="text" class="form-control" id="phone_no" name="phone_no" required placeholder="Phone Number (012-3456-7890)" maxlength="13" pattern="\d{3}-\d{3,4}-\d{3,4}">
                        </div>

                      <div class="template-demo">
                        <div class="form-group">
                            <label for="workshop-owner">Choose Workshop Owner:</label>
                            <select class="form-control" id="workshop_owner" name="workshop_owner" required>
                            <?php
                            // need to add 2 more input fields for longitudinal and latitude locations

                            $workshopOwners = GetWorkshopOwners();
                            echo '<option value="Select">Select</option>';
                            foreach ($workshopOwners as $owner) {
                                echo '<option value="'.$owner['user_id'].'">'.$owner['name'].' | Company: '.$owner['company'].'</option>';
                            }
                            ?>
                            </select>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary me-2">SUBMIT</button>
                    </form>
                  </div>
                  </div>
                </div>
              </div>
            </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php footer(); ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../../vendors/js/Leaflet.LocationShare.js"></script>


  <!-- endinject -->
  <!-- Plugin js for this page -->

  <!-- End custom js for this page-->
</body>
</html>
