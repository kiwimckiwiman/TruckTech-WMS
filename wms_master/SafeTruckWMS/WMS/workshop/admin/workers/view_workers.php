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
  $workshop = GetWorkshop($_SESSION["workshop_id"]);
  if(isset($_GET["pages"])){
    $pages = $_GET["pages"];
    $workers = GetAllWorkers($_SESSION["workshop_id"], intval($pages));
  }else{
    header("Location:view_workers.php?pages=1");
  }
?>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Workers</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../../vendors/ti-icons/css/themify-icons.css">

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
                    <h4 class="card-title">All owners</h4>
                    <form method=POST action="view_workers_search.php" class="search-form">
                      <table style="width:100%;">
                        <tr>
                          <td>
                            <input type="text" class="form-control" name="query" placeholder="Search by Name"></input>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="form-group" >
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="hidden" name="inv" value="0">
                                  <input type="checkbox" class="form-check-input" name="inv" value="1">
                                      Inventory Access
                                  </label>
                              </div>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="hidden" class="form-check-input" name="job" value="0">
                                  <input type="checkbox" class="form-check-input" name="job" value="1">
                                      Jobs Access
                                  </label>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </table>
                      <button type="submit" class="btn btn-primary me-2">SUBMIT</button>
                    </form>
                  </br>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>
                            Name
                          </th>
                          <th>
                            Email
                          </th>
                          <th>
                            Phone number
                          </th>
                          <th>
                            Inventory module access
                          </th>
                          <th>
                            Job module access
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $count = 0;
                        if(empty($workers)){
                          echo '<tr>
                                  <td>
                                    No data
                                  </td>
                                  <td>
                                    No data
                                  </td>
                                  <td>
                                    No data
                                  </td>
                                  <td>
                                    No data
                                  </td>
                                  <td>
                                    No data
                                  </td>
                                </tr>';
                        }else{
                          foreach($workers as $worker){
                            echo '<tr onclick = "location.href=\'view_worker.php?id='.$worker["user_id"].'\';" style="cursor:pointer;">
                                    <td>
                                      '.$worker["name"].'
                                    </td>
                                    <td>
                                      '.$worker["email"].'
                                    </td>
                                    <td>
                                      '.$worker["phone_no"].'
                                    </td>
                                    <td>
                                      ';
                              if($worker["has_inventory_access"]){
                                echo "<p class=\"text-success\">Given</p>";
                              }else{
                                echo "<p class=\"text-danger\">Restricted</p>";
                              }
                                echo '</td>
                                    <td>
                                      ';
                              if($worker["has_job_access"]){
                                echo "<p class=\"text-success\">Given</p>";
                              }else{
                                echo "<p class=\"text-danger\">Restricted</p>";
                              }

                                echo '
                                    </td>
                                  </tr>';
                                  $count = $count + 1;
                            }

                          }
                          if($count < 10){
                            for($x = 0; $x < (10-$count); $x++){
                              echo '<tr>
                                      <td>
                                        &#8203
                                      </td>
                                      <td>
                                        &#8203
                                      </td>
                                      <td>
                                        &#8203
                                      </td>
                                      <td>
                                        &#8203
                                      </td>
                                      <td>
                                        &#8203
                                      </td>
                                    </tr>';
                            }
                          }
                       ?>
                     </tbody>
                    </table>
                  </div>
                  </br>
                    <a href="view_workers.php?pages=<?php if($pages == 1){echo $pages;}else{echo $pages-1;} ?>" class="btn btn-primary me-2">PREVIOUS</a>
                    <a href="view_workers.php?pages=<?php if($count < 10){echo $pages+1;}else{echo $pages;} ?>" class="btn btn-primary me-2">NEXT</a>
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

  <!-- plugins:js -->
  <script src="../../../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../../../js/template.js"></script>


  <!-- endinject -->
  <!-- End custom js for this page-->
</body>
</html>
