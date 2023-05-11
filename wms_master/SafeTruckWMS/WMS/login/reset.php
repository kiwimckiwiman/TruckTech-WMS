<?php
  include '../queries/account_queries.php';
  $msg = "&#8203";
  if((isset($_POST['email']) && !empty($_POST['email']))){
    $email=$_POST['email'];
    $msg = ResetPass($email);
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SafeTruck WMS</title>
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <link rel="shortcut icon" href="../../images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-6 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="../../images/sflogo.png" alt="logo">
              </div>
              <h4>Please enter your email</h4>
              <h6 class="fw-light">We will send you a link to reset your password if you are registered</h6>
              <form class="pt-3" method="POST" action="reset.php">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" name="email" placeholder="Email" maxlength="255" required>
                </div>
                <?php
                echo "<h6 class=\"text-success\">".$msg."</h6>"?>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="reset" type="submit">
                      SEND LINK
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
