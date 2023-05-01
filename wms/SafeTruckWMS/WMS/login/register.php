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
              <h6 class="fw-light">Please enter your details</h6>
              <?php
              echo "<h6 class=\"text-danger\">";
              if(isset($_GET["error"]) && !empty($_GET["error"])){
                if($_GET["error"] == "exists"){
                  echo "Email already exists";
                }else{
                  echo "Incorrect verification code";
                }
              }else{
                echo "&#8203";
              }
              echo "</h6>";
              ?>
              <table class="table">
                <tr>
                  <td>
                    <form class="pt-3" method="POST" action="verify.php">
                      <div class="form-group">
                        <input type="email" class="form-control form-control-lg" name="email" placeholder="Email" maxlength="80" required>
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" maxlength="255"  required>
                      </div>
                      <div class="mt-3">
                        <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="login" type="submit">
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
  </script>
</body>

</html>
