<?php
function UserDropdown($name, $email){

  echo '<li class="nav-item dropdown d-none d-lg-block user-dropdown">
    <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
      <img class="img-xs rounded-circle" src="../../../images/faces/face8.jpg" alt="Profile image"> </a>
    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
      <div class="dropdown-header text-center">
        <img class="img-md rounded-circle" src="../../../images/faces/face8.jpg" alt="Profile image">
        <p class="mb-1 mt-3 font-weight-semibold">'.$name.'</p>
        <p class="fw-light text-muted mb-0">'.$email.'</p>
      </div>
      <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i>My Profile</a>
      <a href="../../login/login.php" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
    </div>
  </li>';
}
?>
