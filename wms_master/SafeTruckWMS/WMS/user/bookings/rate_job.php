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
    $job = ViewCustomerPrevJob($_SESSION["id"], $_GET["job_id"]);
    if(empty($job)){
      header("Location:view_history.php");
    }
  }else{
    header("Location:view_history.php");
  }
  if(isset($_POST['job_id']) && isset($_POST['feedback']) && isset($_POST['rate'])){
    UpdateCustomerJobFeedbackRating($_POST['job_id'],$_POST['feedback'],$_POST['rate']);
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
                    <h4 class="card-title">Rate Job : <?php echo $job['vehicle_plate'];?></h4>
                    <p>Start time:<?php echo date('D | d-M | h:i A', strtotime($job["start_time"]));?></p>
                    <p>Finish time:<?php echo date('D | d-M | h:i A', strtotime($job["finish_time"]));?></p>
                    <p>Description:<?php echo $job["description"];?></p>
                    <p>Total Price:<?php echo $job["total_price"];?></p>
                    </br>
                    <form class="forms-sample" method="POST" action="rate_job.php" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="jobfeedback">Feedback to Workshop:</label>
                        <input type="text" class="form-control" id="feedback" name="feedback" required>
                      </div>
                      <div class="form-group">
                        <label for="rate">Rate out of 5:</label>
                      </br>
                      <div class="rate">
                        <input type="radio" id="star5" name="rate" value="5" />
                        <label for="star5" title="text">5 stars</label>
                        <input type="radio" id="star4" name="rate" value="4" />
                        <label for="star4" title="text">4 stars</label>
                        <input type="radio" id="star3" name="rate" value="3" />
                        <label for="star3" title="text">3 stars</label>
                        <input type="radio" id="star2" name="rate" value="2" />
                        <label for="star2" title="text">2 stars</label>
                        <input type="radio" id="star1" name="rate" value="1" />
                      <label for="star1" title="text">1 star</label>
                      </div>
                      </div>
                      </br></br></br>
                      <input type="hidden" id="job_id" name="job_id" value="<?php echo $job['job_id'] ?>"></input>
                      <a href="view_history.php" class="btn btn-primary me-2">BACK</a>
                      <button type="submit" class="btn btn-primary me-2" >SUBMIT</button>
                    </form>
                  </div>
                </div>
              </div>
            <div>
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
