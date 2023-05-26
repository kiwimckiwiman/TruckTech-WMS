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
  $jobs = ViewCustomerPrevJobs($_SESSION["id"]);
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
                    <h4 class="card-title">Your Previous Jobs</h4>
                  </br>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>
                            Job ID
                          </th>
                          <th>
                            Vehicle plate
                          </th>
                          <th>
                            Time Finished
                          </th>
                          <th>
                            Workshop
                          </th>
                          <th>
                            Invoice
                          </th>
                          <th>
                            Rate
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
                                  <td>
                                    No data
                                  </td>
                                  <td>
                                    No data
                                  </td>
                                </tr>';
                        }else{
                          foreach($jobs as $job){
                            echo '<tr onclick="location.href=\'view_job.php?job_id='.$job["job_id"].'\';" style="cursor:pointer;">
                                    <td>
                                      '.$job["job_id"].'
                                    </td>
                                    <td>
                                      '.$job["vehicle_plate"].'
                                    </td>
                                    <td>
                                    '.date('D | d-M | h:i A', strtotime($job["start_time"])).'
                                    </td>
                                    <td>
                                      '.$job["name"].'
                                    </td>
                                    <td>
                                      <a href="'.substr($job["invoice_link"], 3).'">View Invoice</a>
                                    </td>
                                    <td>
                                      ';
                                if($job["rating"] == null){
                                  echo '<a href="rate_job.php?job_id='.$job["job_id"].'" class="btn btn-primary btn-sm">RATE</a>';
                                }else{
                                  echo round($job["rating"]).'/5';
                                }
                                echo '
                                    </td>
                                  </tr>';
                            }
                          }
                       ?>
                     </tbody>
                    </table>
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
