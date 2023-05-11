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
    $result = GetWorkshopAndOwner($id)[0];
  }else{
    header("Location:dashboard.php");
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Workshop</title>
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
    <?php nav_top($_SESSION["name"], $_SESSION["email"], "View result: ".$result["workshop_name"]) ?>
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
                    <h4 class="card-title"><?php echo $result["workshop_name"];  ?></h4>
                      <table class="table">
                        <tr>
                            <th>
                              Name
                            </th>
                            <td>
                              <?php echo $result["workshop_name"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                              Owner
                            </th>
                            <td>
                              <?php echo $result["name"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                              Specialisations
                            </th>
                            <td>
                              <?php echo $result["specialisations"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                              Phone number
                            </th>
                            <td>
                              <?php echo $result["phone_no"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                              Location
                            </th>
                            <td>
                              <?php echo $result["location"]; ?>
                            </td>
                        </tr>
                        <tr></tr>
                      </table>
                    </br>
                      <form method="POST" action="delete_workshop.php">
                        <a href="contact.php?id=<?php echo $result["user_id"]; ?>" class="btn btn-primary me-2">CONTACT OWNER</a>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <button type="submit" class="btn btn-danger me-2">UNREGISTER WORKSHOP</button>
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
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- End custom js for this page-->
</body>
</html>
