<?php
  function nav($workshops){
    echo '
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">
            <i class="mdi mdi-grid-large menu-icon"></i>
            <span class="menu-title">All Workshops</span>
          </a>
        </li>
        <li class="nav-item nav-category">Workshops</li>';

        if(empty($workshops)){
          echo '<li class="nav-item">
            <a class="nav-link">
              <i class="mdi mdi-home-variant menu-icon"></i>
              <span class="menu-title">No workshop registered</span>
            </a>
          </li>';
        }else{
          foreach($workshops as $workshop){
            echo '<li class="nav-item">
              <a class="nav-link" href="workshop_dashboard.php?workshop='. $workshop['workshop_id'] .'">
                <i class="mdi mdi-home-variant menu-icon"></i>
                <span class="menu-title">'.$workshop["name"].'</span>
              </a>
            </li>';
          }
        }
    echo '<li class="nav-item nav-category">Tools</li>
          <li class="nav-item">
            <a class="nav-link" href="profile.php">
              <i class="mdi mdi-account menu-icon"></i>
              <span class="menu-title">Profile</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../login/login.php">
              <i class="mdi mdi-power menu-icon"></i>
              <span class="menu-title">Logout</span>
            </a>
          </li>
      </ul>
    </nav>';
  }
?>
