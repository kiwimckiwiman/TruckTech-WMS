<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "c")){
    header("Location: ../../login/login.php");
  }
  include '../../modules/cust_nav_top.php';
  include '../../modules/footer.php';
  include '../../queries/job_queries_customer.php';
  if(isset($_GET["job_id"])){
    $job = ViewCustomerJob($_SESSION["id"], $_GET["job_id"]);
    if(empty($job)){
      header("Location:view_history.php");
    }
  }else{
    header("Location:view_history.php");
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Jobs</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <!-- endinject -->

  <!-- End plugin css for this page -->
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
      <?php include '../../modules/cust_nav.php'; ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Pending Bookings</h4>
                  </br>
                  <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>
                              Description
                            </th>
                            <td>
                              <?php echo $job["description"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                              Vehicle Plate
                            </th>
                            <td>
                              <?php echo $job["vehicle_plate"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                              Workshop
                            </th>
                            <td>
                              <?php echo $job["name"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                              Time Started
                            </th>
                            <td>
                              <?php echo date('D | d-M | h:i A', strtotime($job["start_time"])); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                              Time Finished
                            </th>
                            <td>
                              <?php echo date('D | d-M | h:i A', strtotime($job["finish_time"])); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                              Total Cost
                            </th>
                            <td>
                              <?php echo $job["total_price"].'<a href="'.substr($job["invoice_link"], 3).'">(View Full Invoice)</a>'; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                              Your Rating
                            </th>
                            <td>
                              <?php
                              if($job["rating"] == null){
                                echo '<a href="rate_job.php?job_id='.$job["job_id"].'" class="btn btn-primary btn-sm">RATE</a>';
                              }else{
                                echo round($job["rating"]).'/5';
                              }
                               ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                              Your Feedback
                            </th>
                            <td>
                              <?php
                              if($job["rating"] == null){
                                echo '<a href="rate_job.php?job_id='.$job["job_id"].'" class="btn btn-primary btn-sm">RATE</a>';
                              }else{
                                echo $job["feedback"];
                              }
                               ?>
                            </td>
                        </tr>
                        <tr></tr>
                    </table>
                  </br>
                    <a href="view_history.php" class="btn btn-primary me-2">BACK</a>
                  </div>
                  </div>
                  </br>
                  </div>
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
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <script>


  </script>
  <!-- endinject -->
  <!-- End custom js for this page-->
</body>
</html>
