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
  if (isset ($_POST['deletebutton'])){
    DeleteCustomerBooking($_POST['deletebutton']);
  }
  if(isset($_GET["pages"])){
    $pages = $_GET["pages"];
    $bookings = ViewCustomerBookings($_SESSION["id"], $pages);
  }else{
    header("Location:view_bookings.php?pages=1");
  }

?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Workshops</title>
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
                    <h4 class="card-title">View Bookings</h4>
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
                            Status
                          </th>
                          <th>

                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $count = 0;
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
                                      '.$booking["time_created"].'
                                    </td>
                                    <td>
                                      '.$booking["name"].'
                                    </td>
                                    <td>
                                      '.$booking["accepted_status"].'
                                    </td>
                                    <td>
                                      <form method=post action=\'view_bookings.php?pages=1\'>
                                        <button type=\'submit\' name=\'deletebutton\' value="'. $booking["booking_id"] . '" class=\'btn btn-outline-danger btn-icon-text\'>
                                        <i class=\' mdi mdi-delete-forever btn-icon-prepend\'></i> Delete
                                        </button>
                                      </form>
                                    </td>
                                  </tr>';
                                  $count = $count + 1;
                            }

                          }
                          if($count < 10){
                            for($x = 0; $x < (10-$count); $x++){
                              echo '<tr>
                                      <td>
                                        &#8203
                                      </td>
                                      <td>
                                        &#8203
                                      </td>
                                      <td>
                                        &#8203
                                      </td>
                                      <td>
                                        &#8203
                                      </td>
                                      <td>
                                        &#8203
                                      </td>
                                    </tr>';
                            }
                          }
                       ?>
                     </tbody>
                    </table>
                  </div>
                  </br>
                    <a href="view_bookings.php?pages=<?php if($pages == 1){echo $pages;}else{echo $pages-1;} ?>" class="btn btn-primary me-2">PREVIOUS</a>
                    <a href="view_bookings.php?pages=<?php if($count == 10){echo $pages+1;}else{echo $pages;} ?>" class="btn btn-primary me-2">NEXT</a>
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
