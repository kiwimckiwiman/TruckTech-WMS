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
  include '../../queries/job_queries_customer.php';
  if (isset ($_POST['deletebutton'])){
    DeleteCustomerBooking($_POST['deletebutton']);
  }
  $bookings = ViewCustomerBookings($_SESSION["id"]);
  $jobs = ViewCustomerJobs($_SESSION["id"]);
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Bookings</title>
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
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>
                            Booking ID
                          </th>
                          <th>
                            Vehicle plate
                          </th>
                          <th>
                            Time Created
                          </th>
                          <th>
                            Workshop
                          </th>
                          <th>

                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        if(empty($bookings)){
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
                                  </td>
                                </tr>';
                        }else{
                          foreach($bookings as $booking){
                            echo '<tr>
                                    <td>
                                      '.$booking["booking_id"].'
                                    </td>
                                    <td>
                                      '.$booking["vehicle_plate"].'
                                    </td>
                                    <td>
                                      '.date('D | d-M | h:i A', strtotime($booking["time_created"])).'
                                    </td>
                                    <td>
                                      '.$booking["name"].'
                                    </td>
                                    <td>
                                      <form method=post action=\'view_bookings.php?pages=1\'>
                                        <button type=\'submit\' name=\'deletebutton\' value="'. $booking["booking_id"] . '" class=\'btn btn-outline-danger btn-icon-text\'>
                                        <i class=\' mdi mdi-delete-forever btn-icon-prepend\'></i> Delete
                                        </button>
                                      </form>
                                    </td>
                                  </tr>';
                            }
                          }
                       ?>
                     </tbody>
                    </table>
                  </div>
                  </div>
                  <div class="card-body">
                    <h4 class="card-title">On going jobs</h4>
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
                            Description
                          </th>
                          <th>
                            Time Started
                          </th>
                          <th>
                            Workshop
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
                                </tr>';
                        }else{
                          foreach($jobs as $job){
                            echo '<tr>
                                    <td>
                                      '.$job["job_id"].'
                                    </td>
                                    <td>
                                      '.$job["vehicle_plate"].'
                                    </td>
                                    <td>
                                      '.substr($job["description"], 0, 20).'
                                    </td>
                                    <td>
                                    '.date('D | d-M | h:i A', strtotime($job["start_time"])).'
                                    </td>
                                    <td>
                                      '.$job["name"].'
                                    </td>
                                  </tr>';
                            }
                          }
                       ?>
                     </tbody>
                    </table>
                    <a href="view_history.php" class="btn btn-primary me-2">VIEW COMPLETED JOBS</a>
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
