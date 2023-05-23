<?php
  include '../queries/account_queries.php';
  if(isset($_POST['email']) && !empty($_POST['email'])){
    $email=$_POST["email"];
    if(Verify($email) == FALSE){
      header('Location: register.php?error=exists');
    }
  }else{
      header('Location: register.php');
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
              <h4>Welcome to SafeTruck Workshop Management System</h4>
              <h6 class="fw-light">Enter the code sent to your email</h6>
              <form class="pt-3" method="POST" action="verify_auth.php">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="token" placeholder="6-digit code" maxlength="6" required>
                </div>
                <div class="form-group">
                  <input type="hidden" class="form-control form-control-lg" name="email" value=<?php echo $email; ?>>
                  <input type="hidden" class="form-control form-control-lg" name="password" value=<?php echo $_POST["password"]; ?>>
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="verify" type="submit">
                      VERIFY
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
