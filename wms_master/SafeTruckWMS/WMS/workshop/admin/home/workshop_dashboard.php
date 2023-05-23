<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "a")){
    header("Location: ../../../login/login.php");
  }
  include '../../../queries/workshop_queries.php';
  include '../../../queries/data_queries.php';
  include '../../../modules/wadmin_nav_top.php';
  include '../../../modules/wadmin_ws_nav.php';
  include '../../../modules/footer.php';
  if(isset($_GET["workshop"])){
    $_SESSION["workshop_id"]=$_GET["workshop"];
    $workshop = GetWorkshop($_SESSION["workshop_id"], $_SESSION["id"]);
    if(empty($workshop)){
      header("Location:dashboard.php");
    }
  }else{
    header("Location:dashboard.php");
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $workshop["name"] ?></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../../vendors/mdi/css/materialdesignicons.min.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../../../../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="../../../../js/select.dataTables.min.css">
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
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="tab-content tab-content-basic">
                  <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                  <div class="row">
                      <div class="col-sm-12">
                        <div class="statistics-details d-flex align-items-center justify-content-between">
                          <div>
                            <p class="statistics-title">Total Booking</p>
                            <h3 class="rate-percentage"> <?php echo getAllBookings($_SESSION['workshop_id']); ?></h3>


                            <!-- <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>-0.5%</span></p> -->
                          </div>
                          <div>
                            <p class="statistics-title">Total Inventory Items</p>
                            <h3 class="rate-percentage"><?php echo getInventoryItemCount($_SESSION['workshop_id']); ?></h3>

                            <!-- <p class="text-success d-flex"><i class="mdi mdi-menu-up"></i><span>+0.1%</span></p> -->
                          </div>
                          <div>
                            <p class="statistics-title">Number of Employees</p>
                            <!-- <h3 class="rate-percentage">120</h3> -->
                            <h3 class="rate-percentage"><?php echo getEmployeeCount($_SESSION['workshop_id']); ?></h3>


                          </div>
                          <div class="d-none d-md-block">
                            <p class="statistics-title">Sales</p>
                            <h3 class="rate-percentage">$ <?php echo calculateSales($_SESSION['workshop_id']); ?></h3>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-8 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                   <h4 class="card-title card-title-dash">Weekly Sales Line Chart</h4>
                                   </div>

                                </div>
                                <div class="chartjs-wrapper mt-5">
                                <div id="sales-chart" style="width: 100%; height: 170px;"></div>
                                
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                            <div class="card bg-primary card-rounded">
                              <div class="card-body pb-0">
                              <h4 class="card-title card-title-dash text-white mb-4">Booking Summary: ( Total Bookings: <?php echo getAllBookings($_SESSION['workshop_id']); ?>)</h4>


                                <div class="row">


                                  <div class="col-sm-4">
                                    <p class="status-summary-ight-white mb-1">Accepted</p>
                                    <h2 class="text-info"> <?php echo getAcceptedBookingsCount($_SESSION['workshop_id']); ?></h2>

                                  </div>

                                  <div class="col-sm-4">
                                    <p class="status-summary-ight-white mb-1">Pending </p>
                                    <h2 class="text-info"> <?php echo getPendingBookingsCount($_SESSION['workshop_id']); ?></h2>
                                  </div>

                                  <div class="col-sm-4">
                                    <p class="status-summary-ight-white mb-1">Rejected</p>
                                    <h2 class="text-info"> <?php echo getRejectedBookingsCount($_SESSION['workshop_id']); ?></h2>
                                  </div>
                                  <!-- <div class="col-sm-8">
                                    <div class="status-summary-chart-wrapper pb-4">
                                      <canvas id="status-summary"></canvas>
                                    </div>
                                  </div> -->
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="row">
                                <div class="col-sm-6">
                                    <div class="d-flex justify-content-between align-items-center mb-2 mb-sm-0">
                                      <div class="circle-progress-width">
                                        <div id="totalVisitors" class="progressbar-js-circle pr-2"></div>
                                      </div>
                                      <div>
                                        <p class="text-small mb-2">Acceptance Rate</p>
                                        <h4 class="mb-0 fw-bold"><?php echo getAcceptedBookingsPercentage($_SESSION['workshop_id']); ?>%</h4>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="d-flex justify-content-between align-items-center">
                                      <div class="circle-progress-width">
                                        <div id="visitperday" class="progressbar-js-circle pr-2"></div>
                                      </div>
                                      <div>
                                        <p class="text-small mb-2">Rejection Rate</p>
                                        <h4 class="mb-0 fw-bold"><?php echo getRejectedBookingsPercentage($_SESSION['workshop_id']); ?>%</h4>
                                      </div>
                                    </div>
                                  </div>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                   </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php footer() ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->


  <!-- plugins:js -->
  <script src="../../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="../../../../vendors/progressbar.js/progressbar.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  // Fetch the data from the backend using the SalesChart PHP function
  var chartData = <?php echo json_encode(SalesChart($_SESSION['workshop_id'])); ?>;

  var data = new google.visualization.DataTable();
  data.addColumn('string', chartData[0][0]);
  data.addColumn('number', chartData[0][1]);

  // Iterate over the chartData array starting from index 1 to skip the header row
  for (var i = 1; i < chartData.length; i++) {
    data.addRow(chartData[i]);
  }

  var options = {

    curveType: 'function',
    legend: { position: 'bottom' },
    hAxis: {
      title: 'Date',
      titleTextStyle: {
        color: '#333'
      }
    },
    vAxis: {
      title: 'Sales',
      minValue: 0
    },
    chartArea: {
      width: '80%',
      height: '80%'
    },
    colors: ['#4285F4'], // Customize the line color
    backgroundColor: {
      fill: 'transparent' // Set the background color to transparent
    }
  };

  var chart = new google.visualization.LineChart(document.getElementById('sales-chart'));
  chart.draw(data, options);
}
  </script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../../../../js/off-canvas.js"></script>
  <script src="../../../../js/hoverable-collapse.js"></script>
  <script src="../../../../js/template.js"></script>
  <script src="../../../../js/settings.js"></script>
  <script src="../../../../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../../../js/dashboard.js"></script>
  <script src="../../../../js/Chart.roundedBarCharts.js"></script>
</body>

</html>
