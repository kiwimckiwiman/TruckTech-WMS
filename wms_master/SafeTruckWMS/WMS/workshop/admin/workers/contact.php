<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "a")){
    header("Location: ../../../login/login.php");
  }
  include '../../../queries/workshop_queries.php';
  include '../../../queries/worker_queries.php';
  include '../../../queries/account_queries.php';
  include '../../../modules/wadmin_nav_top.php';
  include '../../../modules/wadmin_ws_nav.php';
  include '../../../modules/footer.php';
  $workshop = GetWorkshop($_SESSION["workshop_id"]);
  if(isset($_GET["id"])){
    $id = $_GET["id"];
    $worker = GetWorker($id);
    if($worker == null){
      header("Location:view_workers.php?pages=1");
    }
    $page=$worker["name"];
  }else{
    header("Location:view_workers.php?pages=1");
  }
  $msg = "&#8203";

  if(isset($_POST["email"])){
    $msg = EmailAccount($_POST["email"], $_POST["header"]." from: ".$_SESSION["name"], $_POST["content"]);
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Contact Owner</title>
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
                      <h4 class="card-title">Contact Workshop Owner</h4>
                      <form class="forms-sample" method="POST" action="contact.php?id=<?php echo $worker["user_id"] ?>" name="email_send">
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" name="email" placeholder="Email" required value="<?php echo $worker["email"]; ?>">
                        </div>
                        <div class="form-group">
                          <label for="header">Header</label>
                          <input type="text" class="form-control" id="header" name="header" placeholder="Header" required>
                        </div>
                        <div class="form-group">
                          <label for="content">Content</label>
                        </br>
                          <textarea rows="10" id="content" name="content" required placeholder="Email content" style="width:100%;"></textarea>
                        </div>
                        <?php  echo "<h6 class=\"text-success\">".$msg."</h6>"?>
                        <a href="view_worker.php?id=<?php echo $worker["user_id"]; ?>" class="btn btn-primary me-2">BACK</a>
                        <button type="submit" class="btn btn-primary me-2" name="register">SEND EMAIL</button>
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
  <script src="../../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->


  <!-- End plugin js for this page -->
  <!-- inject:js -->

  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>
