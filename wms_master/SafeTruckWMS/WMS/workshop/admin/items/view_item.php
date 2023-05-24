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
  if(isset($_GET["id"])){
    $id = $_SESSION["item_id"] = $_GET["id"];
    $item = GetItem($_SESSION["workshop_id"], $_GET["id"]);
    $purchases = GetItemPurchases($_SESSION["workshop_id"], $item["item_id"]);
    if($item == null){
      header("Location:view_items.php?pages=1");
    }
    $page="Item: ".$item["name"];
  }else{
    header("Location:view_items.php?pages=1");
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Workshop</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../../vendors/mdi/css/materialdesignicons.min.css">
  <!-- endinject -->

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
                    <h4 class="card-title"><?php echo $item["name"];  ?></h4>
                      <table class="table">
                        <th>
                          <img src="../../../../images/inventory/<?php echo $item['img_name']; ?>" alt="Item Image" style="width: 200px; height: 200px;">
                        </th>
                        <th>
                          <tr>
                              <th>
                                Name
                              </th>
                              <td>
                                <?php echo $item["name"]; ?>
                              </td>
                          </tr>
                          <tr>
                              <th>
                                Category
                              </th>
                              <td>
                                <?php echo $item["item_type"]; ?>
                              </td>
                          </tr>
                          <tr>
                              <th>
                                Price
                              </th>
                              <td>
                                <?php echo $item["price"]; ?>
                              </td>
                          </tr>
                          <tr>
                              <th>
                                Description
                              </th>
                              <td>
                                <?php echo $item["description"]; ?>
                              </td>
                          </tr>
                          <tr>
                            <th>
                              Current Stock
                            </th>
                              <?php   if($item["quantity"] < $item["min_stock"]){
                                  echo '<td class="text-danger">'.$item["quantity"].' (LOW STOCK)';
                                }else{
                                  echo '<td>'.$item["quantity"];
                                }
                                 ?>
                            </td>
                          </tr>
                          <tr></tr>
                        </th>
                    </table>
                    </br>
                      <a href="view_items.php?page=1" class="btn btn-primary me-2">BACK</a>
                      <a href="add_stock.php" class="btn btn-primary me-2">ADD STOCK</a>
                      <a href="edit_item.php" class="btn btn-success me-2">EDIT ITEM</a>
                      <a href="#" onclick="deleteItem()" class="btn btn-danger me-2">DELETE ITEM</a>
                  </div>
                  <div class="card-body">
                    <h4 class="card-title">Purchase History</h4>
                      <table class="table">
                        <tr>
                          <th>Date Purchased</th>
                          <th>Supplier</th>
                          <th>Brand</th>
                          <th>Item Cost</th>
                          <th>Quantity Purchased</th>
                          <th>Total Cost</th>
                        </tr>
                        <?php
                        if(empty($purchases)){
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
                                    No data
                                  </td>
                                </tr>';
                        }else{
                          foreach($purchases as $purchase){
                            echo '<tr>
                                    <td>
                                      '.date('D | d-M | h:i A', strtotime($purchase["date_purchased"])).'
                                    </td>
                                    <td>
                                      '.$purchase["supplier"].'
                                    </td>
                                    <td>
                                      '.$purchase["brand"].'
                                    </td>
                                    <td>
                                      '.round(($purchase["price"]/$purchase["quantity"]), 2).'
                                    </td>
                                    <td>
                                      '.$purchase["quantity"].'
                                    </td>
                                    <td>
                                      '.$purchase["price"].'
                                    </td>
                                  </tr>';
                            }

                          }
                         ?>
                      </table>
                    </br>
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
  <script>
  function deleteItem() {
    var result = confirm("Do you wish to delete this item? This action cannot be undone");
    if (result) {
      window.location.href = "delete_item.php";
    }
  }
  </script>
  <!-- endinject -->
  <!-- End custom js for this page-->
</body>
</html>
