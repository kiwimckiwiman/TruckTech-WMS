<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "a")){
    header("Location: ../../../login/login.php");
  }
  include '../../../queries/workshop_queries.php';
  include '../../../queries/worker_queries.php';
  include '../../../modules/wadmin_nav_top.php';
  include '../../../modules/wadmin_ws_nav.php';
  include '../../../modules/footer.php';
  $workshop = GetWorkshop($_SESSION["workshop_id"], $_SESSION["id"]);
  $owner = GetOwner($_SESSION["id"]);

  if((isset($_POST['email']) && !empty($_POST['email']))){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $DOB = $_POST['DOB'];
    $phone_no = $_POST['phone_no'];
    $inv = $_POST["inv"];
    $job = $_POST["job"];
    $msg = AddWorker($name, $email, $gender, $DOB, $phone_no, $owner["company"], $inv, $job, $_SESSION["workshop_id"]);
  }else{
    $msg = ">&#8203";
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Register Worker</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../../vendors/ti-icons/css/themify-icons.css">

  <!-- endinject -->
  <!-- Plugin css for this page -->
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
                    <h4 class="card-title">Create Workshop Worker</h4>
                      <form class="forms-sample" method="POST" action="register_worker.php">
                      <div class="form-group">
                        <label for="name">Worker Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                      </div>
                      <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email"placeholder="Email" required>
                      </div>
                      <div class="form-group">
                        <label for="gender">Gender</label>
                          <select class="form-control" id="gender" name="gender" required>
                            <option>Male</option>
                            <option>Female</option>
                          </select>
                      </div>
                      <div class="form-group">
                        <label for="DOB">Date of Birth</label>
                        <input type="date" class="form-control" id="DOB" name="DOB" required>
                      </div>
                      <div class="form-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="text" class="form-control" id="phone_no" name="phone_no" required placeholder="Phone Number (012-3456-7890)" maxlength="13" pattern="\d{3}-\d{3,4}-\d{3,4}">
                      </div>
                      <div class="form-group" >
                        <label for="access">Access Controls</label>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="hidden" class="form-check-input" name="inv" value="0">
                            <input type="checkbox" class="form-check-input" name="inv" value="1">
                                Inventory module
                            <i class="input-helper"></i></label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="hidden" class="form-check-input" name="job" value="0">
                            <input type="checkbox" class="form-check-input" name="job" value="1">
                                Jobs module
                            <i class="input-helper"></i></label>
                        </div>
                      </div>
                      <?php echo "<h6".$msg."</h6>";?>
                      <button type="submit" class="btn btn-primary me-2">SUBMIT</button>
                    </form>
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
  <script src="../../../../js/template.js"></script>

</body>
</html>
