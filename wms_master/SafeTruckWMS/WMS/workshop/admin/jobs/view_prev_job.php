<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "a")){
    header("Location: ../../../login/login.php");
  }
  include '../../../queries/workshop_queries.php';
  include '../../../queries/job_queries.php';
  include '../../../modules/wadmin_nav_top.php';
  include '../../../modules/wadmin_ws_nav.php';
  include '../../../modules/footer.php';
  $workshop = GetWorkshop($_SESSION["workshop_id"], $_SESSION["id"]);
  if(isset($_POST["step_id_confirm"])){
    FinishStep($_POST["step_id_confirm"]);
  }
  if(isset($_GET["id"])){
    $id = $_GET["id"];
    $_SESSION["job_id"] = $id;
    $job = ViewWorkshopJob($_SESSION["workshop_id"], $id);
    if($job == null){
      header("Location:view_jobs.php?pages=1");
    }
    $page="Job ID: ".$id;
  }else{
    header("Location:view_jobs.php?pages=1");
  }
  if(isset($_POST["finish"])){
    FinishWorkshopJob($_SESSION["job_id"], $_POST["service_fee"], $_POST["comment"]);
    header("Location:view_job_history.php");
  }
  if(isset($_POST["delete"])){
    header("Location:delete.php");
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Job</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../../vendors/mdi/css/materialdesignicons.min.css">
  <!-- endinject -->

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
                    <h4 class="card-title">Job ID: <?php echo $id; ?></h4>
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
                                Customer name
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
                                <?php echo $job["total_price"].'<a href="'.$job["invoice_link"].'">(View Full Invoice)</a>'; ?>
                              </td>
                          </tr>
                          <tr>
                              <th>
                                Customer Rating
                              </th>
                              <td>
                                <?php
                                if($job["rating"] == null){
                                  echo 'No Rating Found';
                                }else{
                                  echo round($job["rating"]).'/5';
                                }
                                 ?>
                              </td>
                          </tr>
                          <tr>
                              <th>
                                Customer Feedback
                              </th>
                              <td>
                                <?php
                                if($job["rating"] == null){
                                  echo 'No Feedback Found';
                                }else{
                                  echo $job["feedback"];
                                }
                                 ?>
                              </td>
                          </tr>
                          <tr></tr>
                      </table>
                    </br>
                    <a href="view_jobs.php?pages=1" class="btn btn-primary me-2">BACK</a>
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
  <script>
  function deleteJob() {
    var result = confirm("Do you wish to delete job? This action cannot be undone");
    if (result) {
      window.location.href = "delete_job.php";
    }
  }
  function confirmFinish() {
    return confirm("Do you wish to complete the job?");
  }
  function deleteStep(id) {
    var result = confirm("Do you wish to delete step? This action cannot be undone");
    if (result) {
      window.location.href = "delete_step.php?id=" + id;
    }
  }
  </script>
  <!-- endinject -->
  <!-- End custom js for this page-->
</body>
</html>
