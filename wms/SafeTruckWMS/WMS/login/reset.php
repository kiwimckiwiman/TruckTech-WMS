<?php
$msg = "&#8203";
  if((isset($_POST['email']) && !empty($_POST['email']))){
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
    $stmt = $GLOBALS['conn']->prepare("SELECT DISTINCT 1 FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $chk = $stmt->fetch();

    if ($chk == true) {
      $token = rand(100000,999999);
      $token = password_hash($token, PASSWORD_DEFAULT);
      $stmt = $GLOBALS['conn']->prepare("INSERT INTO password_reset_tokens (email, token) VALUES (:email, :token)");
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':token', $token);
      $stmt->execute() or die($GLOBALS['conn']->error);
      $GLOBALS['conn'] = null;

      $site = "localhost/wms/SafeTruckWMS/WMS/index/reset-password.php?token=".$token;
      $content = "<!DOCTYPE html>>
                    <html>
                    <head>
                    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                    </head>
                    <body>

                    <div>
                            <h3>Here is the link to reset your password</h3>
                            <a href =\"".$site."\"><h4>".$site."</h4></a>
                            </br>
                            <p>If you did not authorise this email, please change your password immediately</p>
                    </div>
                    </body>
                    </html>";
        $headers  = "From: loll8441@gmail.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

      mail($email, 'Reset Password', $content, $headers);
      $msg = "Email sent!";
    }else{
      header('Location: login.php');
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
