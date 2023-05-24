<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  if(!($_SESSION["loggedin"]) && ($_SESSION["type"] != "a")){
    header("Location: ../../../login/login.php");
  }
  include '../../../queries/inventory_queries.php';
  include '../../../modules/worker_nav_top.php';
  include '../../../modules/footer.php';

  switch($_POST["query_type"]){
    case "name":
      if(isset($_POST["query"])){
        $items = GetAllWorkshopItemsSearch($_SESSION["workshop_id"], $_POST["query"], $_POST["query_type"]);
      }else{
        header("Location:view_items.php?pages=1");
      }
      break;
    case "type":
      if(isset($_POST["query"])){
        $items = GetAllWorkshopItemsSearch($_SESSION["workshop_id"], $_POST["query"], $_POST["query_type"]);
      }else{
        header("Location:view_items.php?pages=1");
      }
      break;
    case "low_stock":
      $items = GetAllWorkshopItemsSearch($_SESSION["workshop_id"], "none", $_POST["query_type"]);
      break;
    case "empty_stock":
      $items = GetAllWorkshopItemsSearch($_SESSION["workshop_id"], "none", $_POST["query_type"]);
      break;
    default:
      header("Location:view_items.php?pages=1");
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
      <?php  include '../../../modules/worker_nav.php';?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <?php  include '../../../modules/breadcrumbs_worker.php';?>
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
                            <option value="low_stock">Low Stock</option>
                            <option value="empty_stock">Empty Stock</option>
                          </select>
                        </td>
                      </tr>
                    </table>
                    </br>
                    <button type="submit" class="btn btn-primary me-2">SUBMIT</button>
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
                          echo '<tr onclick = "location.href=\'view_item.php?id='.$item["item_id"].'\';" style="cursor:pointer;" ';

                          if($item["quantity"] == "0"){
                            echo ' class="table-danger"';
                          }else if($item["quantity"] < $item["min_stock"]){
                            echo ' class="table-warning"';
                          }

                          echo    '>
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
                          if($item["quantity"] == "0"){
                            echo '<td class="text-danger">'.$item["quantity"].' (EMPTY STOCK)';
                          }else if($item["quantity"] < $item["min_stock"]){
                            echo '<td class="text-warning">'.$item["quantity"].' (LOW STOCK)';
                          }else{
                            echo '<td>'.$item["quantity"];
                          }
                          echo '
                                  </td>
                                  <td>
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
                  <a href="add_item.php" class="btn btn-success me-2">+ ADD ITEM</a>
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
