<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "c")){
    header("Location: ../../login/login.php");
  }
  include '../../queries/account_queries.php';
  include '../../modules/cust_nav_top.php';
  include '../../modules/footer.php';
  $account = GetAccount($_SESSION["id"]);
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
      <?php include '../../modules/cust_nav.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
              </div>
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Account Details</h4>
                        <form class="forms-sample" method="POST" action="profile_save.php">
                          <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"  value="<?php echo $account["name"]?>" required placeholder="Name">
                          </div>
                          <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $account["email"]?>" required placeholder="Email">
                          </div>
                          <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="text" class="form-control" id="company" name="company" value="<?php echo $account["company"]?>" required placeholder="Company Name">
                          </div>
                          <div class="form-group">
                              <label for="phoneNumber">Phone Number</label>
                              <input type="text" class="form-control" id="phone_no" name="phone_no" value="<?php echo $account["phone_no"] ?>"required placeholder="Phone Number (012-3456-7890)" maxlength="13" pattern="\d{3}-\d{3,4}-\d{3,4}">
                          </div>
                          <input type="hidden" name="id" value="<?php echo $_SESSION["id"] ?>">
                          <button type="submit" class="btn btn-primary me-2">SAVE</button>
                          <a href="change_password.php" class="btn btn-primary me-2">CHANGE PASSWORD</a>
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
