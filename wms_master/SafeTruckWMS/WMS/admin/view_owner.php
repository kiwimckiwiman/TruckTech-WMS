<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "s")){
    header("Location: ../login/login.php");
  }
  include '../modules/sadmin_nav_top.php';
  include '../modules/sadmin_nav.php';
  include '../modules/footer.php';
  include '../queries/workshop_queries.php';
  if(isset($_GET["id"])){
    $id = $_GET["id"];
    $owner = GetOwner($id)[0];
    $workshops = GetWorkshopsByOwner($id);
  }else{
    header("Location:dashboard.php");
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Owner</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="../../js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php nav_top($_SESSION["name"], $_SESSION["email"], "View owner: ".$owner["name"]) ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <?php nav(); ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $owner["name"];  ?></h4>
                      <table class="table">
                        <tr>
                            <th>
                              Name
                            </th>
                            <td>
                              <?php echo $owner["name"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                              Company
                            </th>
                            <td>
                              <?php echo $owner["company"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                              Email
                            </th>
                            <td>
                              <?php echo $owner["email"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                              Phone number
                            </th>
                            <td>
                              <?php echo $owner["phone_no"]; ?>
                            </td>
                        </tr>
                        <tr></tr>
                      </table>
                    </br>
                    <form method="POST" action="delete_owner.php">
                      <a href="contact.php?id=<?php echo $result["user_id"]; ?>" class="btn btn-primary me-2">CONTACT OWNER</a>
                      <input type="hidden" name="id" value="<?php echo $result["user_id"]; ?>">
                      <button type="submit" class="btn btn-danger me-2"><i class="mdi mdi-account-minus icon-lg"></i>UNREGISTER OWNER</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Workshops Managed</h4>
                      <div class="row">
                      <?php
                      if(empty($workshops)){
                        echo '<div class="col-md-6 grid-margin stretch-card">
                                <div class="card">
                                  <div class="card-body">
                                      <h1 class="card-title"> No Workshops Found</h1>
                                  </div>
                                </div>
                              </div>';
                      }else{
                        foreach ($workshops as $workshop) {
                          echo '<div class="col-md-6 grid-margin stretch-card">
                                  <div class="card">
                                    <div class="card-body">
                                      <h1 class="card-title">' . $workshop['name'] . '</h1>
                                      <p class="card-description">Workshop Phone Number: ' . $workshop['phone_no'] . '</p>
                                      <p class="card-description">Workshop Opening Hours: ' . $workshop['opening_hours'] . '</p>
                                      <p class="card-description">Workshop Location: ' . $workshop['location'] . '</p>
                                      <p class="card-description">Workshop Specifications: ' . $workshop['specialisations'] .'</p>
                                      <a href="view_workshop.php?id='. $workshop['workshop_id'] .'"<button class="btn btn-primary" type="submit" >View</button></a>
                                    </div>
                                  </div>
                                </div>';
                        }
                      }
                      ?>
                      </div>
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
  </di v>

  <!-- plugins:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- End custom js for this page-->
</body>
</html>
