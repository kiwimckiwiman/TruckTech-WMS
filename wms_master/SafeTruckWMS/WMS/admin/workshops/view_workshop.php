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
  if(isset($_GET["id"])){
    $id = $_GET["id"];
    $result = GetWorkshopAndOwner($id);
    $page = $result["workshop_name"];
    if($result == null){
      header("Location:view_workshops.php?pages=1");
    }
  }else{
    header("Location:view_workshops.php?pages=1");
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Workshop</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <!-- endinject -->

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
                              <a href = "<?php echo "https://www.google.com/maps?q=".$result["workshop_ltd"].",".$result["workshop_lng"];?>"><?php echo $result["location"]; ?></a>
                            </td>
                        </tr>
                        <tr></tr>
                      </table>
                    </br>
                      <form method="POST" action="delete_workshop.php">
                        <a href="../owners/view_owner.php?id=<?php echo $result["user_id"]; ?>" class="btn btn-primary me-2">VIEW OWNER</a>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <a href="reassign_workshop.php?id=<?php echo $id; ?>" class="btn btn-primary me-2">REASSIGN WORKSHOP</a>
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
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- End custom js for this page-->
</body>
</html>
