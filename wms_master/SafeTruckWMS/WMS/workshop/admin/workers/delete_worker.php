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
  if(isset($_POST["id"])){
    $id = $_POST["id"];
    $worker = GetWorker($id);
    if($worker == null){
      header("Location:view_workers.php?pages=1");
    }
    $page=$worker["name"];
  }else{
    header("Location:view_workers.php?pages=1");
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Delete Owner</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../../vendors/mdi/css/materialdesignicons.min.css">
  <!-- endinject -->

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
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"> Do you wish to unregister worker: <?php echo $worker["name"];  ?>?</h4>
                    <h5 class="text-danger"> This action cannot be undone </h5>
                    <table class="table">
                      <tr>
                          <th>
                            Name
                          </th>
                          <td>
                            <?php echo $worker["name"]; ?>
                          </td>
                      </tr>
                      <tr>
                          <th>
                            Email
                          </th>
                          <td>
                            <?php echo $worker["email"]; ?>
                          </td>
                      </tr>
                      <tr>
                          <th>
                            Phone number
                          </th>
                          <td>
                            <?php echo $worker["phone_no"]; ?>
                          </td>
                      </tr>
                      <tr></tr>
                  </table>
                    </br>
                    <form method="POST" action="delete_worker_confirm.php">
                      <a href="view_worker.php?id=<?php echo $id ?>" class="btn btn-primary me-2">BACK</a>
                      <input type="hidden" name="id" value="<?php echo $id; ?>">
                      <button type="submit" class="btn btn-danger me-2">UNREGISTER WORKER</button>
                    </form>
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
  </di v>

  <!-- plugins:js -->
  <script src="../../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- End custom js for this page-->
</body>
</html>
