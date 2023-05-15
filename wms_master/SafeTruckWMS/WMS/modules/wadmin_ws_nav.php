<?php
  function nav($workshop){
    echo '
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="../home/dashboard.php">
            <i class="mdi mdi-grid-large menu-icon"></i>
            <span class="menu-title">All Workshops</span>
          </a>
        </li>
        <li class="nav-item nav-category">'.$workshop["name"].'</li>
        <li class="nav-item">
          <a class="nav-link" href="../home/workshop_dashboard.php?workshop='. $workshop['workshop_id'] .'">
            <i class="mdi mdi-home-variant menu-icon"></i>
            <span class="menu-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item nav-category">Manage</li>
        <li class="nav-item">
          <a class="nav-link" href="../details/details.php">
            <i class="mdi mdi-home-variant menu-icon"></i>
            <span class="menu-title">Details</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../bookings/view_bookings.php?pages=1">
            <i class="mdi mdi-calendar menu-icon"></i>
            <span class="menu-title">Bookings</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../view_inventory.php?pages=1">
            <i class="mdi mdi-dropbox menu-icon"></i>
            <span class="menu-title">Inventory</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../jobs/view_jobs.php?pages=1">
            <i class="mdi mdi-wrench menu-icon"></i>
            <span class="menu-title">Jobs</span>
          </a>
        </li>
        <li class="nav-item nav-category">Workers</li>
        <li class="nav-item">
          <a class="nav-link" href="../workers/view_workers.php?pages=1">
            <i class="mdi mdi-account-multiple menu-icon"></i>
            <span class="menu-title">View Workers</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../workers/register_worker.php">
            <i class="mdi mdi-account-plus menu-icon"></i>
            <span class="menu-title">Register Worker</span>
          </a>
        </li>
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
    </nav>';
  }
?>
