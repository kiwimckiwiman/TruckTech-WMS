<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "a")){
    header("Location: ../../../login/login.php");
  }
  include '../../../queries/workshop_queries.php';
  include '../../../queries/inventory_queries.php';
  include '../../../modules/wadmin_nav_top.php';
  include '../../../modules/wadmin_ws_nav.php';
  include '../../../modules/footer.php';
  $workshop = GetWorkshop($_SESSION["workshop_id"], $_SESSION["id"]);
  $id = $_SESSION["job_id"];
  $page="Job ID: ".$id;
  if(empty($_POST["query"]) && ($_POST["job"] == "0") && ($_POST["inv"] == "0")){
    header("Location:view_workers.php?pages=1");
  }else{
    $query = $_POST["query"];
    $query_type = $_POST["query_type"];
    $items = GetAllWorkshopItemsSearch($_SESSION["workshop_id"], $query, $query_type);
  }
?>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Items</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../../vendors/ti-icons/css/themify-icons.css">

  <!-- inject:css -->
  <link rel="stylesheet" href="../../../../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../../../images/favicon.png" />
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
      <?php nav($workshop); ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <?php  include '../../../modules/breadcrumbs_owner.php';?>
            </div>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">All Items</h4>
                  <form method=POST action="view_items_search.php" class="search-form">
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
                            <option value="type">Category</option>
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
                          Description
                        </th>
                        <th>
                          Item Type
                        </th>
                        <th>
                          Price
                        </th>
                        <th>
                          Quantity
                        </th>
                        <th>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count = 0;
                      if(empty($items)){
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
                                <td>
                                </td>
                              </tr>';
                      }else{
                        foreach($items as $item){
                          echo '<tr onclick = "location.href=\'view_item.php?id='.$item["item_id"].'\';" style="cursor:pointer;">
                                  <td>
                                    '.$item["name"].'
                                  </td>
                                  <td>
                                    '.$item["description"].'
                                  </td>
                                  <td>
                                    '.$item["item_type"].'
                                  </td>
                                  <td>
                                    '.$item["price"].'
                                  </td>

                                    ';
                          if($item["quantity"] < $item["min_stock"]){
                            echo '<td class="text-danger">'.$item["quantity"].' (LOW STOCK)';
                          }else{
                            echo '<td>'.$item["quantity"];
                          }
                          echo '
                                  </td>
                                  <td>
                                    <a href="add_step.php?item='.$item["item_id"].'" class="btn btn-primary me-2">SELECT ITEM</a>
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
                                    <td>
                                    </td>
                                  </tr>';
                          }
                        }
                     ?>
                   </tbody>
                  </table>
                </div>
                </br>
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
  <script src="../../../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../../../js/template.js"></script>

  <!-- endinject -->
  <!-- End custom js for this page-->
</body>
</html>
