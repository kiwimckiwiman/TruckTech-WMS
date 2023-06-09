<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "c")){
    header("Location: ../../login/login.php");
  }
  include '../../modules/cust_nav_top.php';
  include '../../modules/footer.php';
  include '../../queries/workshop_queries.php';
  if(isset($_GET["pages"])){
    $pages = $_GET["pages"];
    $results = GetAllWorkshops(intval($pages));
  }else{
    header("Location:choose_workshops.php?pages=1");
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Workshops</title>
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
      <?php include '../../modules/cust_nav.php'; ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Choose Workshop</h4>
                    <form method=POST action="choose_workshops_search.php" class="search-form">
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
                              <option value="company">Owner</option>
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
                            Specialisations
                          </th>
                          <th>
                            Phone number
                          </th>
                          <th>
                            Location
                          </th>
                          <th>
                            Owner
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
                                  <td>
                                    No data
                                  </td>
                                </tr>';
                        }else{
                          foreach($results as $workshop){
                            echo '<tr onclick = "location.href=\'choose_workshop.php?id='.$workshop["workshop_id"].'\';" style="cursor:pointer;">
                                    <td>
                                      '.$workshop["workshop_name"].'
                                    </td>
                                    <td>
                                      '.$workshop["specialisations"].'
                                    </td>
                                    <td>
                                      '.$workshop["phone_no"].'
                                    </td>
                                    <td>
                                      '.$workshop["location"].'
                                    </td>
                                    <td>
                                      '.$workshop["name"].'
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
                    <a href="choose_workshops.php?pages=<?php if($pages == 1){echo $pages;}else{echo $pages-1;} ?>" class="btn btn-primary me-2">PREVIOUS</a>
                    <a href="choose_workshops.php?pages=<?php if($count == 10){echo $pages+1;}else{echo $pages;} ?>" class="btn btn-primary me-2">NEXT</a>
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
  <script>


  </script>
  <!-- endinject -->
  <!-- End custom js for this page-->
</body>
</html>
