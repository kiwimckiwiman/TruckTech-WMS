<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "w")){
    header("Location: ../../../login/login.php");
  }
  include '../../../modules/worker_nav_top.php';
  include '../../../modules/footer.php';
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../../css/vertical-layout-light/style.css">
  <link rel="shortcut icon" href="../../../../images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <?php nav_top($_SESSION["name"], $_SESSION["email"]) ?>
    <div class="container-fluid page-body-wrapper">
      <?php  include '../../../modules/worker_nav.php';?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <?php  include '../../../modules/breadcrumbs_worker.php';?>
            </div>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Your modules</h4>
                  <div class="row select-type">
                    <?php
                        if($worker["has_inventory_access"] == "1"){
                          echo '
                              <div class="col-md-6 grid-margin stretch-card" >
                                <div class="card select-choice" id="select">
                                  <div class="card-body">
                                    <h3>Inventory</h3>
                                    <h5>Manage workshop inventory</h5>
                                  </div>
                                </div>
                              </div>';
                        }
                        if($worker["has_job_access"] == "1"){
                          echo'
                              <div class="col-md-6 grid-margin stretch-card">
                                <div class="card select-choice" id="geo">
                                  <div class="card-body">
                                    <h3>Jobs</h3>
                                    <h5>Manage workshop jobs</h5>
                                  </div>
                                </div>
                              </div>';
                        }
                        if($worker["has_job_access"] == "0" && $worker["has_inventory_access"] == "0"){
                          echo'
                              <div class="col-md-6 grid-margin stretch-card">
                                <div class="card select-choice">
                                  <div class="card-body">
                                    <h3>No modules assigned</h3>
                                    <h5>Please contact the workshops owner</h5>
                                  </div>
                                </div>
                              </div>';
                        }
                     ?>
                  </div>
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
  <script>
  var select = document.getElementById("select");
  select.addEventListener("click", function() {
    window.location.href = "../items/view_items.php?pages=1";
  });
  var geo = document.getElementById("geo");
  geo.addEventListener("click", function() {
    window.location.href = "../jobs/view_jobs.php";
  });
  </script>
</body>
</html>
