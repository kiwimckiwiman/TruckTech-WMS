<!DOCTYPE html>
<html lang="en">

<?php
/*
fill form
choose broadcast or specific ws
*/
//session_start();
//$customer_id = $_SESSION['id'];
//for testing
$customer_id = 1;
?>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Star Admin2 </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
</head>

<?php
include "bookingCustomerQueries.php";
if (isset ($_POST['deletebutton'])){
  DeleteCustomerBooking($_POST['deletebutton']);
}
?>

<body>

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Basic Table</h4>
                  <p class="card-description">
                    Add class <code>.table</code>
                  </p>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Booking ID</th>
                          <th>Plate Number</th>
                          <th>Created</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            $bookings = ViewCustomerBookings($customer_id);
                            foreach ($bookings as $booking) {
                                echo "<tr>
                                        <td>". $booking['booking_id'] . "</td>
                                        <td>". $booking['vehicle_plate'] . "</td>
                                        <td>". $booking['time_created'] . "</td>
                                        <td><form method='post' action='viewCustomerBooking.php'>
                                          <button type='submit' name='deletebutton' value=". $booking['booking_id'] . " class='btn btn-outline-success btn-icon-text'>
                                          <i class=' mdi mdi-delete-forever btn-icon-prepend'></i> Delete
                                          </button>
                                          </form>
                                          </td>
                                    </tr>";
                            }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>

</body>
</html>