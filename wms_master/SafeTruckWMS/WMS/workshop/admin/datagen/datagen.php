<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "a")){
    header("Location: ../../../login/login.php");
  }
  include '../../../queries/workshop_queries.php';
  include '../../../queries/inventory_queries.php';
  include '../../../queries/booking_queries_admin.php';
  include '../../../queries/booking_queries_customer.php';
  include '../../../queries/worker_queries.php';
  include '../../../modules/wadmin_nav_top.php';
  include '../../../modules/wadmin_ws_nav.php';
  include '../../../modules/footer.php';
  $workshop = GetWorkshop($_SESSION["workshop_id"], $_SESSION["id"]);

  if(isset($_POST["query_type"])){
    switch($_POST["query_type"]){
      case "BookingsS":
        for($x = 0; $x < intval($_POST["no"]); $x++){
          CreateBooking("1", $_SESSION["workshop_id"], "dummy plate ".$x, "dummy make", "110.346644", "1.574966", "dummy desc", "1", "Pending");
        }
        break;
      case "BookingsB":
        for($x = 0; $x < intval($_POST["no"]); $x++){
          CreateBooking("1", "1", "dummy plate ".$x, "dummy make", "110.346644", "1.574966", "dummy desc", "1", "Pending");
        }
        break;
      case "Workers":
        $owner = GetOwner($_SESSION["id"]);
        for($x = 0; $x < intval($_POST["no"]); $x++){
          AddWorker("dummy name", uniqid(), "Male", date("d-m-y"), "000000000", $owner["company"], strval($x % 2), strval($x % 2), $_SESSION["workshop_id"]);
        }
        break;
      case "Inventory":
            $type = array(
            "Engine",
            "Transmission",
            "Suspension",
            "Electrical",
            "Cooling",
            "Exhaust",
            "Filters",
            "Wheels",
            "Brakes",
            "Others"
        );
        for($x = 0; $x < intval($_POST["no"]); $x++){
          AddItem($_SESSION["workshop_id"], "dummy name ".$x, "dummy desc", 100, 6, 5, "dummy image", $type[$x]);
        }
        break;
      case "InventoryLS":
            $type = array(
            "Engine",
            "Transmission",
            "Suspension",
            "Electrical",
            "Cooling",
            "Exhaust",
            "Filters",
            "Wheels",
            "Brakes",
            "Others"
        );
        for($x = 0; $x < intval($_POST["no"]); $x++){
          AddItem($_SESSION["workshop_id"], "dummy name ".$x, "dummy desc", 100, 5, 6, "dummy image", $type[$x]);
        }
        break;
      default:
        break;
    }
  }

?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
   integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
   crossorigin=""/>

 <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
    integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
    crossorigin=""></script>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>datagen</title>
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
                        <h4 class="card-title">MAKE SURE EMAIL IS DISABLED FOR WORKER QUERIES IF ADDING WORKERS</h4>
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
                                  <option value="BookingsS">Bookings select this workshop</option>
                                  <option value="BookingsB">Bookings broadcast</option>
                                  <option value="Workers">Workers</option>
                                  <option value="Inventory">Inventory</option>
                                  <option value="InventoryLS">Inventory low stock</option>
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
  <script src="../../../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../../../vendors/js/Leaflet.LocationShare.js"></script>
</body>
</html>
