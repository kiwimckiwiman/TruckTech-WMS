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
  if(isset($_POST["id"])){
    $id = $_POST["id"];
    $owner = GetOwner($id);
    $page = $owner["name"];
    if($owner == null){
      header("Location:view_owners.php?pages=1");
    }    $workshops = GetWorkshopsByOwner($id);
  }else{
    header("Location:view_owner.php?pages=1");
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Delete Owner</title>
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
                    <h4 class="card-title"> Do you wish to unregister owner: <?php echo $owner["name"];  ?>?</h4>
                    <h5 class="text-danger"> This action cannot be undone </h5>
                    <h5 class="text-danger"> All associated workshops will also be unregistered </h5>
                    <h5 class="text-danger"> Reassign any workshops to avoid unregistrations of associated workshops </h5>
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
                    <form method="POST" action="delete_owner_confirm.php">
                      <a href="view_owner.php?id=<?php echo $id ?>" class="btn btn-primary me-2">BACK</a>
                      <input type="hidden" name="id" value="<?php echo $id; ?>">
                      <button type="submit" class="btn btn-danger me-2">UNREGISTER OWNER</button>
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
