<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "s")){
    header("Location: ../../login/login.php");
  }
  include '../../modules/sadmin_nav_top.php';
  include '../../modules/footer.php';
  include '../../queries/workshop_queries.php';

  if((isset($_POST['email']) && !empty($_POST['email']))){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $DOB = $_POST['DOB'];
    $phone_no = $_POST['phone_no'];
    $company = $_POST['company'];
    $msg = AddWorkshopOwner($name, $email, $gender, $DOB, $phone_no, $company);
  }else{
    $msg = ">&#8203";
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Register Owner</title>
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
      <?php include '../../modules/sadmin_nav.php'; ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <?php include '../../modules/breadcrumbs_admin.php'; ?>
            </div>
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Register Workshop Owner</h4>
                      <form class="forms-sample" method="POST" action="register_owner.php">
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                          <label for="email">Email address</label>
                          <input type="email" class="form-control" id="email" name="email"placeholder="Email" required>
                        </div>
                        <div class="form-group">
                          <label for="company">Company Name</label>
                          <input type="text" class="form-control" id="company"  required name="company" placeholder="Owner's Company">
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
                          <?php echo "<h6".$msg."</h6>";?>
                          <button type="submit" class="btn btn-primary me-2" name="register">SUBMIT</button>
                      </form>
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
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->


  <!-- End plugin js for this page -->
  <!-- inject:js -->

  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>
