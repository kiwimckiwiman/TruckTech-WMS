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
  $owner = GetOwner($_SESSION["id"]);
  if(isset($_GET["id"])){
    $id = $_GET["id"];
    $item = GetItem($_SESSION["workshop_id"], $id);
    if($item == null){
      header("Location:view_items.php?pages=1");
    }
    $page=$item["name"];
  }else{
    header("Location:view_items.php?pages=1");
  }
  if(isset($_POST["supplier"])){
    $supplier = $_POST['supplier'];
    $brandName = $_POST['brandName'];
    $price = $_POST['price'];
    $dPurchased = date('Y-m-d h:i:s');
    $quantity =  $_POST['quantity'];
    $item_id = $id;
    $workshop_id= $_SESSION['workshop_id'];
    $msg=AddPurchaseDetails($workshop_id, $item_id, $supplier, $brandName, $price, $dPurchased, $quantity);
  }else{
    $msg = "&#8203";
  }
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add Stock</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../../vendors/ti-icons/css/themify-icons.css">

  <!-- endinject -->
  <!-- Plugin css for this page -->
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
                    <h4 class="card-title">Add Stock for <?php echo $item["name"]; ?></h4>
                    <form class="forms-sample" method="POST" action="add_stock.php?id=<?php echo $item["item_id"]; ?>">
                      <div class="form-group">
                        <label for="itemName">Supplier Name</label>
                        <input type="text" class="form-control" id="supplier" name="supplier"  required placeholder="Supplier Name">
                      </div>
                      <div class="form-group">
                        <label for="brandName">Brand name</label>
                        <input type="text" class="form-control"  id="brandName" name="brandName" required placeholder="Brand Name">
                        </div>
                        <div class="form-group">
                          <label for="quantity">Quantity Purchased</label>
                          <input type="text" class="form-control"   id="quantity" name="quantity" required placeholder="Quantity Purchased"  pattern="\d*">
                        </div>
                        <div class="form-group">
                          <label for="price">Price</label>
                          <input type="text" class="form-control"   id="price" name="price" required placeholder="Price" pattern="\d*\.*\d*">
                        </div>
                        <?php echo "<h6 class=\"text-success\">".$msg."</h6>";?>
                      <a href="view_item.php?id=<?php echo $item["item_id"]; ?>" class="btn btn-primary me-2">BACK</a>
                      <button type="submit" class="btn btn-primary me-2">SUBMIT</button>
                    </form>
                  </div>
                </div>
              </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php footer() ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="../../../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../../../js/template.js"></script>

</body>
</html>
