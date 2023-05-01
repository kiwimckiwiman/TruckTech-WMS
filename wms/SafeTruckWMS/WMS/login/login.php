<!DOCTYPE html>
<html lang="en">
<?php
  session_start();
  session_unset();
  session_destroy();
?>
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
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="../../images/sflogo.png" alt="logo">
              </div>
              <h4>Welcome to SafeTruck Workshop Management System</h4>
              <h6 class="fw-light">Sign in to continue</h6>
              </br>
              <form class="pt-3" method="POST" action="auth.php">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="email" placeholder="Username or Email" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" required>
                </div>
                <?php
                echo "<h6 ";
                if(isset($_GET["error"]) && !empty($_GET["error"])){
                  echo "class=\"text-danger\">";
                  switch($_GET["error"]){
                    case "empty":
                      echo "Please enter your username/password";
                      break;
                    case "unk":
                      echo "Account does not exist";
                      break;
                    case "inc":
                      echo "Incorrect password";
                      break;
                  }
                }elseif(isset($_GET["success"]) && !empty($_GET["success"])){
                  echo "class=\"text-success\">";
                  if($_GET["success"] == "true"){
                    echo "Email verified! Please login";
                  }else{
                    echo "Password has been reset!";
                  }
                }else{
                  echo "&#8203";
                }
                echo "</h6>"?>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="login" type="submit">
                    SIGN IN
                  </button>
                </div>
                <div class="text-center mt-4 fw-light">
                  <a href="reset.php" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="text-center mt-4 fw-light">
                  Don't have an account? <a href="register.php" class="text-primary">Sign up</a>
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
