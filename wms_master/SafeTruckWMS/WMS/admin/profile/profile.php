<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "s")){
    header("Location: ../../login/login.php");
  }
  include '../../modules/sadmin_nav_top.php';
  include '../../modules/footer.php';
  include '../../queries/account_queries.php';

  $account = GetAccount($_SESSION["id"]);

?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Profile</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">

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
                        <h4 class="card-title">Account Details</h4>
                        <form class="forms-sample" method="POST" action="profile_save.php">
                          <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"  value="<?php echo $account["name"]?>" required>
                          </div>
                          <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $account["email"]?>" required>
                          </div>
                          <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="text" class="form-control" id="company" name="company" value="<?php echo $account["company"]?>" required>
                          </div>
                          <div class="form-group">
                              <label for="phoneNumber">Phone Number</label>
                              <input type="text" class="form-control" id="phone_no" name="phone_no" required value="<?php echo $account["phone_no"]?>" placeholder="Phone Number (012-3456-7890)" maxlength="13" pattern="\d{3}-\d{3,4}-\d{3,4}">
                          </div>
                          <input type="hidden" name="id" value="<?php echo $_SESSION["id"] ?>">
                          <button type="submit" class="btn btn-primary me-2">SAVE</button>
                          <a href="change_pass.php" class="btn btn-primary me-2">CHANGE PASSWORD</a>

                        </form>
                      </div>
                    </div>
                  </div>
                </div>
        </div>
        <?php footer(); ?>
      </div>
    </div>
  </div>
  <script src="../../../../vendors/js/vendor.bundle.base.js"></script>
</body>
</html>
