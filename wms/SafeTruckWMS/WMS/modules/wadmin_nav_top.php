<?php
  include 'acc_icon.php';
  function greeting(){
    $time = date("G") + 6;
    if($time > 19){
      return "Evening";
    }else if($time > 12){
      return "Afternoon";
    }else{
      return "Morning";
    }

  }
  function nav_top($name, $email, $subtext){
    echo '    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
            <div>
            <a class="navbar-brand brand-logo" href="dashboard.php">
                <img src="../../../images/sflogo.png" alt="logo" />
              </a>
              <a class="navbar-brand brand-logo-mini" href="dashboard.php">
                <img src="../../../images/logo-mini.svg" alt="logo" />
              </a>
            </div>
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-top">
            <ul class="navbar-nav">
              <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                <h1 class="welcome-text">Good '.greeting().', <span class="text-black fw-bold">'.$name.'</span></h1>
                <h3 class="welcome-sub-text">'.$subtext.'</h3>
              </li>
            </ul>
            <ul class="navbar-nav ms-auto">
              <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  '.icon($name).'
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                  <div class="dropdown-header text-center">
                    <p class="mb-1 mt-3 font-weight-semibold">'.$name.'</p>
                    <p class="fw-light text-muted mb-0">'.$email.'</p>
                  </div>
                  <a class="dropdown-item" href="profile.php"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i>My Profile</a>
                  <a href="../../login/login.php" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
                </div>
              </li>
            </ul>
          </div>
        </nav>
';
  }
?>
