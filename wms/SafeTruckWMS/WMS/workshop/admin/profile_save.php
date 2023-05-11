<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "a")){
    header("Location: ../../login/login.php");
  }
  include '../../queries/account_queries.php';
  include '../../queries/workshop_queries.php';
  include '../../modules/wadmin_nav_top.php';
  include '../../modules/wadmin_dash_nav.php';
  include '../../modules/footer.php';

  if(isset($_POST['name'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $phone_no = $_POST['phoneNumber'];
    $company = $_POST['company'];
    $id = $_POST['id'];
  }
  UpdateAccount($name, $email, $username, $phone_no, $company, $id);
  $account = GetAccount($_SESSION["id"]);
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
    <?php nav_top($_SESSION["name"], $_SESSION["email"], "Manage your account details") ?>
    <div class="container-fluid page-body-wrapper">
      <?php
      $workshops = GetWorkshops($_SESSION["id"]);
      nav($workshops); ?>
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <form action="profile.php">
                          <h4 class="card-title">Changes saved successfully</h4>
                          <button type="submit" class="btn btn-primary me-2" action="">RETURN</button>
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
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
</body>
</html>
