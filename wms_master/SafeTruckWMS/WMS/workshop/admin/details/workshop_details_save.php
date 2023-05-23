<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "a")){
    header("Location: ../../../login/login.php");
  }
  include '../../../queries/workshop_queries.php';
  include '../../../modules/wadmin_nav_top.php';
  include '../../../modules/wadmin_ws_nav.php';
  include '../../../modules/footer.php';

  if(isset($_POST['workshop_name']) && !empty($_POST['workshop_name'])){
    $name = $_POST['workshop_name'];
    $address = $_POST['address'];
    $location = $_POST['loc'];
    $opening_hours = $_POST['opening_hrs'];
    $closing_hours = $_POST['closing_hrs'];
    $specialisations = $_POST['workshop_special'];
    $phone_no = $_POST['phone_no'];

    $coords = explode(",", $location);
    $lat = round(floatval(trim($coords[0])), 6);
    $lng = round(floatval(trim($coords[1])), 6);

    $hours = date('h:i A', strtotime($opening_hours)).' to '.date('h:i A', strtotime($closing_hours));

    UpdateWorkshop($_SESSION["workshop_id"], $name, $address, $hours, $specialisations, $phone_no, $lat, $lng);
  }
  $workshop = GetWorkshop($_SESSION["workshop_id"], $_SESSION["id"]);

?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $workshop["name"]; ?></title>
  <link rel="stylesheet" href="../../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../../css/vertical-layout-light/style.css">
  <link rel="shortcut icon" href="../../../../images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <?php nav_top($_SESSION["name"], $_SESSION["email"]) ?>
    <div class="container-fluid page-body-wrapper">
      <?php nav($workshop); ?>
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <?php  include '../../../modules/breadcrumbs_owner.php';?>
              </div>
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Changes saved successfully</h4>
                        <a href="../home/workshop_dashboard.php?workshop=<?php echo $_SESSION["workshop_id"]; ?>" class="btn btn-primary me-2">BACK</a>
                      </div>
                    </div>
                  </div>
                </div>
        </div>
        <?php footer(); ?>
      </div>
    </div>
  </div>
  <script src="../../../../vendors/js/vendor.bundle.base.js"></script>
</body>
</html>
