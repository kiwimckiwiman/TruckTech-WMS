<?php
  if((isset($_POST['email'], $_POST['password'])) && !empty($_POST['email']) && !empty($_POST['password'])){
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';

    if ( mysqli_connect_errno() ) {
    	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    try{
      $GLOBALS['conn'] = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $GLOBALS['conn']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $GLOBALS['conn']->prepare("SELECT DISTINCT 1 FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $chk = $stmt->fetch();
    
    if ($chk == false) {
      $token = rand(100000,999999);
      $stmt = $GLOBALS['conn']->prepare("INSERT INTO new_login_table (email, token) VALUES (:email, :token)");
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':token', $token, PDO::PARAM_INT);
      $stmt->execute() or die($GLOBALS['conn']->error);
      $GLOBALS['conn'] = null;

      $content = "Here is your 6-digit verification code: " . $token;
      mail($email, 'Verification code', $content, 'From: loll8441@gmail.com');
    }else{
      header('Location: register.php?error=exists');
    }
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
              <form class="pt-3" method="POST" action="verify-auth.php">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="token" placeholder="6-digit code" maxlength="6" required>
                </div>
                <div class="form-group">
                  <input type="hidden" class="form-control form-control-lg" name="email" value=<?php echo $email; ?>>
                </div>
                <div class="form-group">
                  <input type="hidden" class="form-control form-control-lg" name="password" value=<?php echo $password; ?>>
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
