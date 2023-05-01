<?php
  if(isset($_GET['token']) && !empty($_GET['token'])){
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

    $token = $_GET['token'];

    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM password_reset_tokens WHERE token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;

    if ($stmt->rowCount() > 0) {
      $account = $stmt->fetch();
      $email = $account['email'];
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
              <h4>Reset your password</h4>
              <h6 class="fw-light">Please enter your new password</h6>
              <table class="table">
                <tr>
                  <td>
                    <form class="pt-3" method="POST" action="reset-auth.php">
                      <div class="form-group">
                        <input type="password" class="form-control form-control-lg" name="password" placeholder="Enter new Password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" maxlength="255"  required>
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control form-control-lg" placeholder="Re-enter Password" id="password2" maxlength="255" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                      </div>
                      <div class="form-group">
                        <input type="hidden" class="form-control form-control-lg" name ="email" value="<?php echo $email; ?>">
                      </div>
                      <div class="mt-3">
                        <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="login" type="submit" id="button">
                          SIGN UP
                        </button>
                      </div>
                    </form>
                  </td>
                  <td style="vertical-align:top;">
                    <h4>Password must contain:</h4>
                      <p id="letter" class="text-danger">A <b>lowercase</b> letter</p>
                      <p id="capital" class="text-danger">A <b>capital (uppercase)</b> letter</p>
                      <p id="number" class="text-danger">A <b>number</b></p>
                      <p id="length" class="text-danger">Minimum <b>8 characters</b></p>
                      <p id="match" class="text-danger">Passwords should <b>match</b></p>
                    </h3>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    var input = document.getElementById("password");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");
    var button = document.getElementById("button");

    // When the user starts to type something inside the password field
    input.onkeyup = function() {
      // Validate lowercase letters
      var lowerCaseLetters = /[a-z]/g;
      if(input.value.match(lowerCaseLetters)) {
        letter.classList.remove("text-danger");
        letter.classList.add("text-success");
      } else {
        letter.classList.remove("text-success");
        letter.classList.add("text-danger");
      }

      // Validate capital letters
      var upperCaseLetters = /[A-Z]/g;
      if(input.value.match(upperCaseLetters)) {
        capital.classList.remove("text-danger");
        capital.classList.add("text-success");
      } else {
        capital.classList.remove("text-success");
        capital.classList.add("text-danger");
      }

      // Validate numbers
      var numbers = /[0-9]/g;
      if(input.value.match(numbers)) {
        number.classList.remove("text-danger");
        number.classList.add("text-success");
      } else {
        number.classList.remove("text-success");
        number.classList.add("text-danger");
      }

      // Validate length
      if(input.value.length >= 8) {
        length.classList.remove("text-danger");
        length.classList.add("text-success");
      } else {
        length.classList.remove("text-success");
        length.classList.add("text-danger");
      }
    }

    function checkPasswords() {
      var password1 = document.getElementById("password").value;
      var password2 = document.getElementById("password2").value;

      if (password1 !== "" && password2 !== ""){
        if(password1 !== password2){
          match.classList.remove("text-success");
          match.classList.add("text-danger");
          button.disabled = true;
        }else{
          match.classList.remove("text-danger");
          match.classList.add("text-success");
          button.disabled = false;
        }
      }else{
        match.classList.add("text-danger");
        match.classList.remove("text-success");
        button.disabled = true;
      }
    }

    document.getElementById("password").addEventListener("input", checkPasswords);
    document.getElementById("password2").addEventListener("input", checkPasswords);


  </script>
</body>
</html>
