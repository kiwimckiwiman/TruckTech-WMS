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
  if(isset($_POST["step_id_confirm"])){
    FinishStep($_POST["step_id_confirm"]);
  }
  if(isset($_GET["id"])){
    $id = $_GET["id"];
    $_SESSION["job_id"] = $id;
    $jobs = ViewWorkshopJob($_SESSION["workshop_id"], $id);
    $steps = GetAllSteps($id);
    if($jobs == null){
      header("Location:view_jobs.php?pages=1");
    }
    $page="Job ID: ".$id;
  }else{
    header("Location:view_jobs.php?pages=1");
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Steps</title>
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
                    <h4 class="card-title">Job ID: <?php echo $id; ?></h4>
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>
                            Description
                          </th>
                          <th>
                            Time Created
                          </th>
                          <th>
                            Item Used
                          </th>
                          <th>
                            Item Quantity
                          </th>
                          <th>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        if(empty($steps)){
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
                          foreach($steps as $step){
                            echo '<tr';

                            if($step["finish"] == 1){
                              echo ' class="table-success"';
                            }

                            echo '>
                                    <td>
                                      '.$step["description"].'
                                    </td>
                                    <td>
                                      '.$step["time_created"].'
                                    </td>
                                    <td>
                                      '.GetItem($_SESSION["workshop_id"], $step["item_id"])["name"].'
                                    </td>
                                    <td>
                                      '.$step["quantity"].'
                                    </td>
                                    <td>';
                              if($step["finish"] == 0){

                                echo '<form method="POST" action="view_job.php?id='.$id.'">
                                        <input type="hidden" name="step_id_confirm" value="'.$step["step_id"].'">
                                        <button type="submit" class="btn btn-success me-2">FINISH</button>
                                      </form>';
                              }
                                  echo  '</td>
                                  </tr>';
                            }
                          }
                       ?>
                     </tbody>
                    </table>
                    </table>
                    </br>
                    <form method="POST" action="delete_job.php">
                      <a href="add_step.php" class="btn btn-primary me-2">ADD STEP</a>
                      <a href="finish_job.php?id=<?php echo $id; ?>" class="btn btn-success me-2">FINISH JOB</a>
                      <input type="hidden" name="id" value="<?php echo $id; ?>">
                      <button type="submit" class="btn btn-danger me-2">DELETE JOB</button>
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
