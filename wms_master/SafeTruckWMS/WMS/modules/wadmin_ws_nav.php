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
          <a class="nav-link" href="../details/workshop_details.php">
            <i class="mdi mdi-home-variant menu-icon"></i>
            <span class="menu-title">Details</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../bookings/view_bookings.php?pages=1">
            <i class="mdi mdi-calendar menu-icon"></i>
            <span class="menu-title">Pending Bookings</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../items/view_items.php?pages=1">
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
        <li class="nav-item">
          <a class="nav-link" href="../workers/view_workers.php?pages=1">
            <i class="mdi mdi-account-multiple menu-icon"></i>
            <span class="menu-title">Workers</span>
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
        <li class="nav-item">
          <a class="nav-link" href="../datagen/datagen.php">
            <i class="mdi mdi-power menu-icon"></i>
            <span class="menu-title">datagen</span>
          </a>
        </li>
      </ul>
    </nav>';
  }
?>
