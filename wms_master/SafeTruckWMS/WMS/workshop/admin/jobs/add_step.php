<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "a")){
    header("Location: ../../../login/login.php");
  }
  include '../../../queries/workshop_queries.php';
  include '../../../queries/job_queries.php';
  include '../../../queries/inventory_queries.php';
  include '../../../modules/wadmin_nav_top.php';
  include '../../../modules/wadmin_ws_nav.php';
  include '../../../modules/footer.php';
  $workshop = GetWorkshop($_SESSION["workshop_id"], $_SESSION["id"]);
  if(isset($_SESSION["job_id"])){
    $id = $_SESSION["job_id"];
      $steps = GetAllSteps($id);
    
    $page="Job ID: ".$id;
  }else{
    header("Location:view_jobs.php?pages=1");
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add Steps</title>
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
                    <h4 class="card-title">Add Step</h4>
                    <form class="forms-sample" method="POST" action="add_step_process.php">
                      <div class="form-group">
                        <label for="name">Step Description</label>
                        <input type="text" class="form-control" id="stepDescr" name="stepDescr" placeholder="Description" required>
                      </div>
                      <div class="form-group">
                        <label for="workshop-owner">Choose Inventory Item:</label>
                        <input type="text" disabled class="form-control" placeholder="Item" value="<?php
                        if(isset($_GET["item"])){
                          echo GetItem($_SESSION["workshop_id"], $_GET["item"])["name"];
                        }
                         ?>">
                         <input type="hidden" class="form-control" id="id" name="id" value="<?php if(isset($_GET["item"])){echo $_GET["item"];}else{echo "0";} ?>">
                        </br>
                        <a href="add_items.php?page=1" class="btn btn-primary me-2">SELECT INVENTORY ITEM</a>
                      </div>
                      <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" required>
                      </div>
                      <div class="form-group">
                        <label for="comment">Comment </label>
                        <input type="text" class="form-control" id="comment"  required name="comment" placeholder="Your Comment">
                      </div>
                      <button type="submit" class="btn btn-primary me-2">SUBMIT</button>
                    </form>
                    </br>
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
