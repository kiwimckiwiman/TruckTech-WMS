<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "s")){
    header("Location: ../../login/login.php");
  }
  include '../../modules/sadmin_nav_top.php';
  include '../../modules/footer.php';
  include '../../queries/workshop_queries.php';
  if(isset($_POST["query"]) && !(empty($_POST["query"]))){
    $query = $_POST["query"];
    $type = $_POST["query_type"];
    $results = GetOwnerSearch($query, $type);
  }else{
    header("Location:view_owners.php?pages=1");
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Owners</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <!-- endinject -->

  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../../images/favicon.png" />
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
      <?php include '../../modules/sadmin_nav.php'; ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <?php include '../../modules/breadcrumbs_admin.php'; ?>
            </div>
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">All owners</h4>
                    <form method=POST action="view_owners_search.php" class="search-form">
                      <table style="width:100%;">
                        <tr>
                          <td>
                            <input type="text" class="form-control" name="query" placeholder="Enter your search query"></input>
                          </td>
                          <td style="width:10%;padding-left:20px;">
                            Search criteria:
                          </td>
                          <td>
                            <select class="form-control" name="query_type" required>
                              <option value="name">Name</option>
                              <option value="company">Company</option>
                            </select>
                          </td>
                        </tr>
                      </table>
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
                            Company
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $count = 0;
                        if(empty($results)){
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
                                </tr>';
                        }else{
                          foreach($results as $owner){
                            echo '<tr onclick = "location.href=\'view_owner.php?id='.$owner["user_id"].'\';" style="cursor:pointer;">
                                    <td>
                                      '.$owner["name"].'
                                    </td>
                                    <td>
                                      '.$owner["email"].'
                                    </td>
                                    <td>
                                      '.$owner["phone_no"].'
                                    </td>
                                    <td>
                                      '.$owner["company"].'
                                    </td>
                                  </tr>';
                                  $count = $count + 1;
                            }

                          }
                       ?>
                     </tbody>
                    </table>
                  </div>
                  </br>
                    <a href="view_owners.php?pages=1" class="btn btn-primary me-2">RETURN TO ALL</a>
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
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- End custom js for this page-->
</body>
</html>
