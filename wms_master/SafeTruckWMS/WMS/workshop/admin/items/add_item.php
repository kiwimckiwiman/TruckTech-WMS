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
  $workshop = GetWorkshop($_SESSION["workshop_id"], $_SESSION["id"]);
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add Item</title>
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
                    <h4 class="card-title">Add Inventory Item</h4>
                    <form class="forms-sample" method="POST" enctype="multipart/form-data" action="add_item_process.php">
                      <div class="form-group">
                        <label for="itemName">Item Name</label>
                        <input type="text" class="form-control" id="itemName" name="itemName"  required placeholder="Item Name">
                      </div>
                      <div class="form-group">
                        <label for="itemType">Item Category</label>
                        <select class="form-control" name="itemType" required>
                          <option value="Engine">Engine</option>
                          <option value="Transmission">Transmission</option>
                          <option value="Suspension">Suspension</option>
                          <option value="Electrical">Electrical</option>
                          <option value="Cooling">Cooling</option>
                          <option value="Exhaust">Exhaust</option>
                          <option value="Filters">Filters</option>
                          <option value="Wheels">Wheels</option>
                          <option value="Brakes">Brakes</option>
                          <option value="Others">Others</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="desc">Item Description</label><br/>
                        <input type="text" style="width: 100%; height: 100px;" placeholder="Description of the Product" id="desc" name="desc" required >
                      </div>
                      <div class="form-group">
                        <label for="price">Item Price</label>
                        <input type="text" class="form-control"   id="price" name="price" required pattern="\d*\.*\d*">
                      </div>
                      <div class="form-group">
                        <label for="minStockVal">Minimum Stock Value</label>
                        <input type="text" class="form-control"  id="minStockVal" name="minStockVal" required pattern="\d*">
                      </div>
                      <div class="form-group">
                        <label for="myFile">Upload Item Image</label>
                        <br/>
                        <input type="file" id="image" name="image" required>
                      </div>
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
  <script>
  const imageInput = document.getElementById('image');

  if (imageInput.value.trim() !== '') {
    const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    const maxFileSize = 500 * 1024; // 500KB

    const fileExtension = imageInput.value.match(allowedExtensions);
    const fileSize = imageInput.files[0].size;

    if (!fileExtension) {
      errors.push('Invalid file type. Only JPG, JPEG and PNG images are allowed.');
    }
    if (fileSize > maxFileSize) {
      errors.push('File size exceeds 500KB limit.');
    }
  }

  // Display any errors
  if (errors.length > 0) {
    alert(errors.join('\n'));
  } else {
    // If no errors, submit the form
    form.submit();
  }
  </script>

</body>
</html>
