<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "a")){
    header("Location: ../../../login/login.php");
  }
  include '../../../queries/workshop_queries.php';
  include '../../../queries/booking_queries_admin.php';
  include '../../../modules/wadmin_nav_top.php';
  include '../../../modules/wadmin_ws_nav.php';
  include '../../../modules/footer.php';
  $workshop = GetWorkshop($_SESSION["workshop_id"], $_SESSION["id"]);
  if(empty($workshop)){
    header("Location:dashboard.php");
  }
  if(!(isset($_GET["pages"]))){
    header("Location:view_bookings.php?pages=1");
  }

  if(isset ($_POST['acceptbutton'])){
    $booking_id=$_POST['acceptbutton'];
    ToggleAcceptBooking($booking_id, $_SESSION["workshop_id"]);
  }

  if(isset ($_POST['acceptbuttonbyid'])){
    $booking_id=$_POST['acceptbuttonbyid'];
    ToggleAcceptBookingByID($booking_id);
  }

  if(isset ($_POST['rejectbutton'])){
    $booking_id=$_POST['rejectbutton'];
    ToggleRejectBooking($booking_id);
  }

  $pendings = ViewAllPendingBookings($workshop["workshop_lng"], $workshop["workshop_ltd"]);
  $directs = ViewAllPendingBookingsByID($_SESSION["workshop_id"]);

?>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Bookings</title>
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
      <?php nav($workshop); ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <?php  include '../../../modules/breadcrumbs_owner.php';?>
            </div>
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Nearby booking requests</h4>
                  </br>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>
                            Description
                          </th>
                          <th>
                            Time Created
                          </th>
                          <th>
                            Vehicle Make
                          </th>
                          <th>
                            Distance
                          </th>
                          <th>
                            Require Pickup
                          </th>
                          <th>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $count = 0;
                        if(empty($pendings)){
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
                          foreach($pendings as $booking){
                            echo '<tr>
                                    <td>
                                      '.$booking["description"].'
                                    </td>
                                    <td>
                                      '.$formattedDate = date('D | d-M | h:i A', strtotime($booking["time_created"])).'
                                    </td>
                                    <td>
                                      '.$booking["vehicle_make"].'
                                    </td>
                                    <td>
                                      '.round($booking["distance"], 3).' km
                                    </td>
                                    <td>
                                      ';
                            if($booking["require_pickup"] == 1){
                              echo "Yes";
                            }else{
                              echo "No";
                            };
                              echo '
                                    </td>
                                    <td>
                                      <form action=\'view_pending_bookings.php?pages=1\' method=\'POST\'>
                                          <button type=\'submit\' class=\'btn btn-success btn-rounded btn-fw\' name=\'acceptbutton\' value='.$booking['booking_id'].'>Accept</button>
                                      </form>
                                    </td>
                                  </tr>';
                            }
                          }
                       ?>
                       <tr></tr>
                     </tbody>
                    </table>
                  </div>
                  </br>
                  </div>
                  <div class="card-body">
                    <h4 class="card-title">Direct booking requests</h4>
                  </br>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>
                            Description
                          </th>
                          <th>
                            Time Created
                          </th>
                          <th>
                            Vehicle Make
                          </th>
                          <th>
                            Require Pickup
                          </th>
                          <th>
                          </th>
                          <th>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $count = 0;
                        if(empty($directs)){
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
                                  <td>
                                  </td>
                                </tr>';
                        }else{
                          foreach($directs as $booking){
                            echo '<tr>
                                    <td>
                                      '.$booking["description"].'
                                    </td>
                                    <td>
                                      '.$formattedDate = date('D | d-M | h:i A', strtotime($booking["time_created"])).'
                                    </td>
                                    <td>
                                      '.$booking["vehicle_make"].'
                                    </td>
                                    <td>';
                            if($booking["require_pickup"] == 1){
                              echo "Yes";
                            }else{
                              echo "No";
                            };
                              echo '</td>
                                    <td>
                                      <form action=\'view_pending_bookings.php?pages=1\' method=\'POST\'>
                                          <button type=\'submit\' class=\'btn btn-success btn-rounded btn-fw\' name=\'acceptbuttonbyid\' value='.$booking['booking_id'].'>Accept</button>
                                      </form>
                                    </td>
                                    <td>
                                      <form action=\'view_pending_bookings.php?pages=1\' method=\'POST\'>
                                          <button type=\'submit\' class=\'btn btn-danger btn-rounded btn-fw\' name=\'rejectbutton\' value='.$booking['booking_id'].'>Reject</button>
                                      </form>
                                    </td>
                                  </tr>';
                            }
                          }
                       ?>
                       <tr></tr>
                     </tbody>
                    </table>
                  </div>
                  </br>
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
