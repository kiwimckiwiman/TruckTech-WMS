<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "a")){
    header("Location: ../../../login/login.php");
  }
  include '../../../queries/workshop_queries.php';
  include '../../../modules/wadmin_nav_top.php';
  include '../../../modules/wadmin_ws_nav.php';
  include '../../../modules/footer.php';
  $workshop = GetWorkshop($_SESSION["workshop_id"], $_SESSION["id"]);
?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
   integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
   crossorigin=""/>

 <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
    integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
    crossorigin=""></script>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $workshop["name"]; ?></title>
  <link rel="stylesheet" href="../../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../../css/vertical-layout-light/style.css">
  <link rel="shortcut icon" href="../../../../images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <?php nav_top($_SESSION["name"], $_SESSION["email"]) ?>
    <div class="container-fluid page-body-wrapper">
      <?php nav($workshop); ?>
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <?php  include '../../../modules/breadcrumbs_owner.php';?>
              </div>
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Workshop Details</h4>
                        <form class="forms-sample" method="POST" action="workshop_details_save.php">
                          <div class="form-group">
                            <label for="workshopname">Workshop Name</label>
                            <input type="text" class="form-control" id="workshopname" name="workshop_name"  required placeholder="Workshop Name" value="<?php echo $workshop["name"]; ?>">
                          </div>
                          <div class="form-group">
                            <label for="workshoplocation">Workshop Location</label>
                            <div style="display: flex;  align-items: center;">
                              <button type="button" id="search" class="btn btn-primary btn-sm" style="margin-right:20px;">SEARCH</button>
                              <input type="text" class="form-control"  id="address" name="address" required placeholder="Address or enter Latitude, Longitude" value="<?php echo $workshop["workshop_ltd"].", ".$workshop["workshop_lng"]; ?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class='col-12 grid-margin stretch-card'>
                              <div id='map' style='width:100%;height:500px;'></div>
                            </div>
                            <input type="hidden" id="loc" name="loc" required>
                          </div>
                          <?php
                          $times = explode(" to ", $workshop["opening_hours"]);
                          $startTime = trim($times[0]);
                          $endTime = trim($times[1]);
                          $startTime = date("H:i", strtotime($startTime));
                          $endTime = date("H:i", strtotime($endTime));
                          ?>
                          <div class="form-group">
                            <label for="opening_hrs">Workshop Opening Hours</label>
                            <input type="time" class="form-control"  id="opening_hrs" name="opening_hrs" required value="<?php echo $startTime; ?>">
                          </div>
                          <div class="form-group">
                            <label for="closing_hrs">Workshop Closing Hours</label>
                            <input type="time" class="form-control"  id="closing_hrs" name="closing_hrs" required  value="<?php echo $endTime; ?>">
                          </div>
                          <div class="form-group">
                            <label for="workshop_special">Workshop Specialisation</label>
                            <input type="text" class="form-control" id="workshop_special" name="workshop_special" placeholder="Workshop Specialisation" required value="<?php echo $workshop["specialisations"]; ?>">
                          </div>
                            <div class="form-group">
                                <label for="phone_no">Phone Number</label>
                                <input type="text" class="form-control" id="phone_no" name="phone_no" required placeholder="Phone Number (012-3456-7890)" maxlength="13" pattern="\d{3}-\d{3,4}-\d{3,4}" value="<?php echo $workshop["phone_no"]; ?>">
                            </div>
                          <a href="../home/workshop_dashboard.php?workshop=<?php echo $_SESSION["workshop_id"]; ?>" class="btn btn-primary me-2">BACK</a>
                          <button type="submit" class="btn btn-primary me-2">SUBMIT</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
        </div>
        <?php footer(); ?>
      </div>
    </div>
  </div>
  <script src="../../../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../../../vendors/js/Leaflet.LocationShare.js"></script>
</body>
</html>
