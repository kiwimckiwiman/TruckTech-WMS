<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "a")){
    header("Location: ../../../login/login.php");
  }
  include '../../../queries/job_queries.php';
  include '../../../modules/worker_nav_top.php';
  include '../../../modules/footer.php';
  include '../../../queries/inventory_queries.php';
  if(isset($_SESSION["job_id"])){
    $id = $_SESSION["job_id"];
    $steps = GetAllSteps($_SESSION["job_id"]);
    $page="Job ID: ".$_SESSION["job_id"];
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
      <?php  include '../../../modules/worker_nav.php';?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <?php  include '../../../modules/breadcrumbs_worker.php';?>
            </div>
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Add Step</h4>
                    <form class="forms-sample" method="POST" action="add_step_process.php">
                      <div class="form-group">
                        <?php
                          if(isset($_GET["item"])){
                            $item = GetItem($_SESSION["workshop_id"], $_GET["item"]);
                            if(!empty($item)){
                              echo '<label for="workshop-owner">Inventory Item:</label>
                                    <input type="text" disabled class="form-control" placeholder="Item" value="'.$item["name"].'">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" required max="'.$item["quantity"].'" min="1">
                                    <input type="hidden" class="form-control" id="item_id" name="item_id" value="'.$item["item_id"].'">';

                              if($item["quantity"] < $item["min_stock"]){
                                echo '<label class="text-danger">WARNING: Stock is at '.$item["quantity"].'</label>';
                              }
                            }
                          }
                         ?>
                         </br>
                        <a href="add_items.php?page=1" class="btn btn-primary me-2">SELECT INVENTORY ITEM</a>
                      </div>
                      <div class="form-group">
                        <label for="name">Step Description</label>
                        <input type="text" class="form-control" id="stepDescr" name="stepDescr" placeholder="Description" required>
                      </div>
                      <div class="form-group">
                        <label for="comment">Comment</label>
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
  </div>

  <!-- plugins:js -->
  <script src="../../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- End custom js for this page-->
</body>
</html>
