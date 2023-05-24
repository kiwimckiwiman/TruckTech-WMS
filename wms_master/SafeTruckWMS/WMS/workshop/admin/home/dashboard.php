<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "a")){
    header("Location: ../../../login/login.php");
  }
  include '../../../queries/workshop_queries.php';
  include '../../../modules/wadmin_nav_top.php';
  include '../../../modules/wadmin_dash_nav.php';
  include '../../../modules/footer.php';
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../../css/vertical-layout-light/style.css">
  <link rel="shortcut icon" href="../../../../images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <?php nav_top($_SESSION["name"], $_SESSION["email"]) ?>
    <div class="container-fluid page-body-wrapper">
      <?php
      $workshops = GetWorkshopsByOwner($_SESSION["id"]);
      nav($workshops); ?>
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <?php  include '../../../modules/breadcrumbs_owner.php';?>
              </div>
            <?php
                // Assume you have fetched the data and stored it in a variable called $workshops
                if(empty($workshops)){
                  echo '<div class="col-md-6 grid-margin stretch-card">
                          <div class="card">
                            <div class="card-body">
                                <h1 class="card-title"> No Workshops Found</h1>
                                <p class="card-description">Please contact the admin to register your workshop</p>
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
                              <a href="workshop_dashboard.php?workshop='. $workshop['workshop_id'] .'"<button class="btn btn-primary" type="submit" >View</button></a>
                            </div>
                          </div>
                        </div>';
                }
              }
            ?>
        </div>
        </div>
        <?php footer(); ?>
      </div>
    </div>
  </div>
  <script src="../../../../vendors/js/vendor.bundle.base.js"></script>
</body>
</html>
