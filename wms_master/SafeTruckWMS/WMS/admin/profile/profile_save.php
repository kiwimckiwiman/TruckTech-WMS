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

  if(isset($_POST['name'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];
    $company = $_POST['company'];
    $id = $_POST['id'];
  }
  UpdateAdminAccount($name, $email, $phone_no, $company, $id);
  $_SESSION["name"] = $account["name"];
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Profile</title>
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../css/vertical-layout-light/style.css">
  <link rel="shortcut icon" href="../../../images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <?php nav_top($_SESSION["name"], $_SESSION["email"]) ?>
    <div class="container-fluid page-body-wrapper">
      <?php include '../../modules/sadmin_nav.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <?php include '../../modules/breadcrumbs_admin.php'; ?>
              </div>
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                      <h4 class="card-title">Changes saved successfully</h4>
                      <a href="profile.php" class="btn btn-primary me-2">BACK</a>
                    </div>
                  </div>
                </div>
        </div>
        <?php footer(); ?>
      </div>
    </div>
  </div>
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
</body>
</html>
