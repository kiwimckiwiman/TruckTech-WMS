<?php
/*
fill form
choose broadcast or specific ws
*/
//session_start();
//$customer_id = $_SESSION['id'];
//for testing
$customer_id = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Star Admin2 </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../../vendors/select2/select2.min.css">
  <link rel="stylesheet" href="../../vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
  <!-- Wokshop Modal CSS -->
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
    <style>
        .w3-modal{z-index:3;display:none;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:100%;
            overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)}
        .w3-modal-content{margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:600px}
        @media (max-width:600px){.w3-modal-content{margin:0 10px;width:auto!important}.w3-modal{padding-top:30px}}
        @media (max-width:768px){.w3-modal-content{width:500px}.w3-modal{padding-top:50px}}
        @media (min-width:993px){.w3-modal-content{width:900px}}
        .w3-display-topright {
            position: absolute;
            right: 0;
            top: 0;
        }
        .w3-btn, .w3-button {
            border: none;
            display: inline-block;
            padding: 8px 16px;
            vertical-align: middle;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            background-color: inherit;
            text-align: center;
            cursor: pointer;
            white-space: nowrap;
        }
    </style>
</head>

<?php include "bookingCustomerQueries.php";?>

<body>
<p id="demo"></p>
<div class="main-panel">        
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h4 class="card-title">Booking form</h4>
                    <p class="card-description">
                        Booking Form
                    </p>
                    <form class="forms-sample" method="POST" action="bookingConfirmation.php">
                        <div class="form-group">
                            <label for="vehicle_plate">Vehicle Plate</label>
                            <input type="text" class="form-control" id="vehicle_plate" name="vehicle_plate" placeholder="QW 1234 AS" required>
                        </div>
                        <div class="form-group">
                            <label for="vehicle_make">Vehicle Make</label>
                            <input type="text" class="form-control" id="vehicle_make" name="vehicle_make" placeholder="Toyota" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Problem</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="The vehicle can't start" required>
                        </div>
                        <button type="button" onclick="document.getElementById('workshopmodal').style.display='block'" class="btn btn-primary btn-icon-text">
                            <i class="mdi mdi-worker btn-icon-prepend"></i>
                            Select a workshop of your choice
                        </button>
                        <div id="workshopmodal" class="w3-modal">
                            <div class="w3-modal-content">
                                <div class="card">
                                    <div class="card-body">
                                    <h4 class="card-title">Workshops</h4>
                                    <input type="text" id="filter_keyword" class="form-control d-none d-lg-block" placeholder="Search for name, location, etc.">
                                    <span onclick="document.getElementById('workshopmodal').style.display='none'" class="w3-button w3-display-topright"><i class="mdi mdi-close-box "></i></span>
                                        <div class="table-responsive">
                                            <table class="table" id="workshop_table">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Location</th>
                                                        <th>Opening Hours</th>
                                                        <th>Specialisation</th>
                                                        <th>Phone Number</th>
                                                        <th>Select</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $workshops = ViewWorkshops();
                                                    foreach ($workshops as $workshop) {
                                                        echo "<tr>
                                                                <td>". $workshop['name'] . "</td>
                                                                <td>". $workshop['location'] . "</td>
                                                                <td>". $workshop['opening_hours'] . "</td>
                                                                <td>". $workshop['specialisations'] . "</td>
                                                                <td>". $workshop['phone_no'] . "</td>
                                                                <td><button type='button' onclick='selectWorkshop(". $workshop['workshop_id'] . ")' class='btn btn-primary'>Select Workshop</button></td>
                                                            </tr>";
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="card-description" id='workshopselectionnotice' style="display:none;">
                            A workshop has been selected!
                        </p>
                        <input type="hidden" class="form-control" id="workshop_id" name="workshop_id" placeholder="Workshop">
                        <div class="form-check form-check-flat form-check-primary">
                            <label class="form-check-label">
                                <input type="checkbox" name="workshop_id" value="null" class="form-check-input">
                                Send request to nearby workshops instead
                                <i class="input-helper">
                                </i>
                            </label>
                        </div>
                        <button type="button" onclick="getLocation()" class="btn btn-inverse-success btn-icon">
                            <i class="ti-location-pin btn-icon-prepend"></i> Get your coordinate
                        </button>
                        <div class="form-group">      
                            <label for="description">Coordinate</label>
                            <input type="text" class="form-control" id="customer_lng" name="customer_lng" value="" required readonly>
                        </div>
                        <div class="form-group">      
                            <input type="text" class="form-control" id="customer_ltd" name="customer_ltd" value="" required readonly>
                        </div>
                        <input type="hidden" class="form-control" id="customer_id " name="customer_id" value="<?php echo $customer_id; ?>">
                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<script>
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  }
}

function showPosition(position) {
    document.getElementById("customer_lng").value = position.coords.longitude;
    document.getElementById("customer_ltd").value = position.coords.latitude;
}

function selectWorkshop(workshop_id){
    document.getElementById("workshop_id").value = workshop_id;
    document.getElementById('workshopmodal').style.display='none';
    document.getElementById('workshopselectionnotice').style.display='block';
}

function filterTable(event) {
    var filter = event.target.value.toUpperCase();
    var rows = document.querySelector("#workshop_table tbody").rows;
    
    for (var i = 0; i < rows.length; i++) {
        var firstCol = rows[i].cells[0].textContent.toUpperCase();
        var secondCol = rows[i].cells[1].textContent.toUpperCase();
        if (firstCol.indexOf(filter) > -1 || secondCol.indexOf(filter) > -1) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }      
    }
}

document.querySelector('#filter_keyword').addEventListener('keyup', filterTable, false);
</script>