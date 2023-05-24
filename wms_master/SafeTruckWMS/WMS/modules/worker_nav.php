  <?php
  include '../../../queries/worker_queries.php';

    $worker = GetWorker($_SESSION["id"]);
    $_SESSION["workshop_id"] = $worker["workshop_id"]?>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="../home/dashboard.php">
            <i class="mdi mdi-home-variant menu-icon"></i>
            <span class="menu-title">Dashboard</span>
          </a>
        </li>
<?php
  if($worker["has_inventory_access"] == "1"){
    echo '
      <li class="nav-item">
        <a class="nav-link" href="../items/view_items.php?pages=1">
          <i class="mdi mdi-dropbox menu-icon"></i>
          <span class="menu-title">Inventory</span>
        </a>
      </li>';
  }
  if($worker["has_job_access"] == "1"){
    echo'<li class="nav-item">
        <a class="nav-link" href="../jobs/view_jobs.php?pages=1">
          <i class="mdi mdi-wrench menu-icon"></i>
          <span class="menu-title">Jobs</span>
        </a>
      </li>';
  }
 ?>

        <li class="nav-item nav-category">Tools</li>
        <li class="nav-item">
          <a class="nav-link" href="../profile/profile.php">
            <i class="mdi mdi-account menu-icon"></i>
            <span class="menu-title">Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../../../login/login.php">
            <i class="mdi mdi-power menu-icon"></i>
            <span class="menu-title">Logout</span>
          </a>
        </li>
      </ul>
    </nav>
