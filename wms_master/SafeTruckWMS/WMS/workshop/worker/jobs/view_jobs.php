<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "a")){
    header("Location: ../../../login/login.php");
  }
  include '../../../queries/job_queries.php';
  include '../../../modules/worker_nav_top.php';
  include '../../../modules/footer.php';
  include '../../../queries/inventory_queries.php';
  if(isset($_GET["pages"])){
    $pages = $_GET["pages"];
    $jobs = ViewAllOngoingJobs($_SESSION["workshop_id"]);
  }else{
    header("Location:view_jobs.php?pages=1");
  }
?>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Jobs</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../../vendors/ti-icons/css/themify-icons.css">

  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../../../images/favicon.png" />
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
      <?php  include '../../../modules/worker_nav.php';?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <?php  include '../../../modules/breadcrumbs_worker.php';?>
            </div>
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">All Current Jobs</h4>
                  </br>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>
                            Vehicle Plate
                          </th>
                          <th>
                            Vehicle Make
                          </th>
                          <th>
                            Description
                          </th>
                          <th>
                            Start Time
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        if(empty($jobs)){
                          echo '<tr>
                                  <td>
                                    No data
                                  </td>
                                  <td>
                                    No data
                                  </td>
                                  <td>
                                    No data
                                  </td>
                                  <td>
                                    No data
                                  </td>
                                </tr>';
                        }else{
                          foreach($jobs as $job){
                            echo '<tr onclick = "location.href=\'view_job.php?id='.$job["job_id"].'\';" style="cursor:pointer;">
                                    <td>
                                      '.$job["vehicle_plate"].'
                                    </td>
                                    <td>
                                      '.$job["vehicle_make"].'
                                    </td>
                                    <td>
                                      '.$job["description"].'
                                    </td>
                                    <td>
                                      '.date('D | d-M | h:i A', strtotime($job["start_time"])).'
                                    </td>
                                  </tr>';
                            }
                          }
                       ?>
                     </tbody>
                    </table>
                  </div>
                  </br>
                    <a href="view_job_history.php?pages=1" class="btn btn-primary me-2">JOB HISTORY</a>
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

  <!-- plugins:js -->
  <script src="../../../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../../../js/template.js"></script>


  <!-- endinject -->
  <!-- End custom js for this page-->
</body>
</html>
