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
    if($jobs == null || !empty($jobs["finish_time"])){
      header("Location:view_jobs.php?pages=1");
    }
    $page="Job ID: ".$id;
  }else{
    header("Location:view_jobs.php?pages=1");
  }
  if(isset($_POST["finish"])){
    FinishWorkshopJob($_SESSION["job_id"], $_POST["service_fee"], $_POST["comment"]);
    header("Location:view_job_history.php");
  }
  if(isset($_POST["delete"])){
    header("Location:delete.php");
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
                                      ';
                            if($step["item_id"] == null){
                              echo "n/a";
                            }else{
                              echo GetItem($_SESSION["workshop_id"], $step["item_id"])["name"];
                            }
                            echo '</td>
                                    <td>
                                      ';
                            if($step["quantity"] == null){
                              echo "n/a";
                            }else{
                              echo $step["quantity"];
                            }
                            echo '</td>
                                    <td>';
                              if($step["finish"] == 0){

                                echo '<form method="POST" action="view_job.php?id='.$_SESSION["job_id"].'">
                                        <input type="hidden" name="step_id_confirm" value="'.$step["step_id"].'">
                                        <button type="submit" class="btn btn-success me-2">FINISH</button>
                                        <a href="#" onclick="deleteStep('.$step["step_id"].')" class="btn btn-danger me-2">DELETE STEP</a>
                                      </form>';
                              }else{
                                echo '<a href="#" onclick="deleteStep('.$step["step_id"].')" class="btn btn-danger me-2">DELETE STEP</a>';
                              }
                                  echo  '</td>
                                  </tr>';
                            }
                          }
                       ?>
                     </tbody>
                    </table>
                    </br>
                    <a href="add_step.php" class="btn btn-primary me-2">ADD STEP</a>
                    <form method="POST" action="view_job.php?id=<?php echo $_SESSION["job_id"];?>" onsubmit="return confirm('Do you wish to complete the job?');">
                    </br>
                      <div class="form-group">
                        <label> Service fee </label>
                        <input type="text" class="form-control" name="service_fee" placeholder="Service Fee" pattern="\d*" required>
                      </div>
                      <div class="form-group">
                        <label> Notes </label>
                        <input type="text" class="form-control" name="comment" placeholder="Note" required>
                      </div>
                      <button type="submit" class="btn btn-success me-2"  name="finish"
                      <?php
                        if(empty($steps)){
                          echo "disabled";
                        }
                        foreach($steps as $step){
                          if($step["finish"] == 0){
                            echo "disabled";
                            break;
                          }
                        }
                      ?>>FINISH JOB</button>
                      <a href="#" onclick="deleteJob()" class="btn btn-danger me-2">DELETE JOB</a>
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
  </div>

  <!-- plugins:js -->
  <script src="../../../../vendors/js/vendor.bundle.base.js"></script>
  <script>
  function deleteJob() {
    var result = confirm("Do you wish to delete job? This action cannot be undone");
    if (result) {
      window.location.href = "delete_job.php";
    }
  }
  function confirmFinish() {
    return confirm("Do you wish to complete the job?");
  }
  function deleteStep(id) {
    var result = confirm("Do you wish to delete step? This action cannot be undone");
    if (result) {
      window.location.href = "delete_step.php?id=" + id;
    }
  }
  </script>
  <!-- endinject -->
  <!-- End custom js for this page-->
</body>
</html>
