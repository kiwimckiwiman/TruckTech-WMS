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

  if(isset($_POST["query_type"])){
    switch($_POST["query_type"]){
      case "Owner":
        for($x = 0; $x < intval($_POST["no"]); $x++){
          AddWorkshopOwner("dummy name ".$x, uniqid(),"Male", date("d-m-y"), "000", "dummy company ".$x);
        }
        break;
      case "Workshops":
        for($x = 0; $x < intval($_POST["no"]); $x++){
          AddWorkshop("dummy name ".$x, "dummy location ".$x, "dummy times ".$x, "dummy spec ".$x, "00000", "126", "1.507624", "110.366640");
        }
        break;
      default:
        break;
    }
  }

?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>datagen</title>
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../css/vertical-layout-light/style.css">
  <link rel="shortcut icon" href="../../../images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <?php nav_top($_SESSION["name"], $_SESSION["email"]) ?>
    <div class="container-fluid page-body-wrapper">
      <?php include '../../modules/sadmin_nav.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <?php include '../../modules/breadcrumbs_admin.php'; ?>
              </div>
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">MAKE SURE TO DISABLE EMAIL IF ADDING OWNER. OWNER FOR WORKSHOPS DEFAULT TO ID 126</h4>
                        <form class="forms-sample" method="POST" action="datagen.php">
                          <table style="width:100%;">
                            <tr>
                              <td>
                                <input type="text" class="form-control" name="no" placeholder="No. of rows" required></input>
                              </td>
                              <td style="width:10%;padding-left:20px;">
                                Query type:
                              </td>
                              <td>
                                <select class="form-control" name="query_type" required>
                                  <option value="Owner">Owner</option>
                                  <option value="Workshops">Workshops</option>
                                </select>
                              </td>
                            </tr>
                          </table>
                        </br>
                          <button type="submit" class="btn btn-primary me-2">GENERATE</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
        </div>
        <?php footer(); ?>
      </div>
    </div>
  </div>
  <script src="../../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../../vendors/js/Leaflet.LocationShare.js"></script>
</body>
</html>
