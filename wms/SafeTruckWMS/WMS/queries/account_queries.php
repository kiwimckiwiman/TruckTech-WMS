<?php
  function Verify($email){
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';

    if ( mysqli_connect_errno() ) {
    	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    try{
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT DISTINCT 1 FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute() or die($conn->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $chk = $stmt->fetch();

    if ($chk == false) {
      $token = rand(100000,999999);
      $stmt = $conn->prepare("INSERT INTO new_login_table (email, token) VALUES (:email, :token)");
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':token', $token, PDO::PARAM_STR);
      $stmt->execute() or die($conn->error);
      $conn = null;

      $content = "<!DOCTYPE html>
                    <html>
                    <head>
                    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                    </head>
                    <body>
                    <div>
                            <p>Here is your 6-digit verification code: ".$token."</p>
                            </br>
                            <p>SafeTruck Workshop Management System</p>
                    </div>
                    </body>
                    </html>";
      $headers  = "From: loll8441@gmail.com\r\n";
      $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
      mail($email, 'Verification code', $content, $headers);
    }
  }

  function ResetPass($email){
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
    if ( mysqli_connect_errno() ) {
      exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    try{
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT DISTINCT 1 FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute() or die($conn->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $chk = $stmt->fetch();

    if ($chk == true) {
      $token = rand(100000,999999);
      $token = password_hash($token, PASSWORD_DEFAULT);
      $stmt = $conn->prepare("INSERT INTO password_reset_tokens (email, token) VALUES (:email, :token)");
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':token', $token);
      $stmt->execute() or die($conn->error);
      $conn = null;

      $site = "localhost/wms/SafeTruckWMS/WMS/login/reset_password.php?token=".$token;
      $content = "<!DOCTYPE html>
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
      return $msg = "Email sent!";
    }else{
      header('Location: login.php');
    }
  }

  function VerifyToken($token){
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
    if ( mysqli_connect_errno() ) {
      exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    try{
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

    $stmt = $conn->prepare("SELECT * FROM password_reset_tokens WHERE token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute() or die($conn->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $conn = null;

    if ($stmt->rowCount() > 0) {
      $account = $stmt->fetch();
      $email = $account['email'];
      return $email;
    }else{
      header('Location: login.php');
    }
  }

  function GetAccount($id){
      $servername = 'localhost';
      $username = 'root';
      $password = '';
      $dbname = 'wms';

      if ( mysqli_connect_errno() ) {
          exit('Failed to connect to MySQL: ' . mysqli_connect_error());
      }
      try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       // replace this with your actual workshop owner id value

      $sql = "SELECT * FROM users WHERE user_id = :id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
      }
      $conn = null;

      return $results[0];
  }

  function UpdateAccount($name, $email, $wusername, $phone_no, $company, $id){
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';

    if ( mysqli_connect_errno() ) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement for inserting user data into the table
        $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email, username = :username, phone_no = :phone_no, company = :company WHERE user_id = :id");

        // Bind the user data values to the prepared statement parameters
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':username', $wusername, PDO::PARAM_STR);
        $stmt->bindParam(':phone_no', $phone_no, PDO::PARAM_INT);
        $stmt->bindParam(':company', $company, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        // Execute the prepared statement to insert the user data into the table
        $stmt->execute();

      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      $conn = null;
    }

    function UpdatePassword($id, $pass){
      $servername = 'localhost';
      $username = 'root';
      $password = '';
      $dbname = 'wms';
      if ( mysqli_connect_errno() ) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
      }

      try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pass = password_hash($pass, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = :password WHERE user_id = :id ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':password', $pass);
        $stmt->execute();

      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }

      $conn = null;
    }

    function EmailOwner($email, $header, $content){
        $content = "<!DOCTYPE html>
                      <html>
                      <head>
                      <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                      </head>
                      <body>
                      <div>
                              <p>".$content."</p>
                              </br>
                              <p>SafeTruck Workshop Management System</p>
                      </div>
                      </body>
                      </html>";
          $headers  = "From: loll8441@gmail.com\r\n";
          $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
          mail($email, $header, $content, $headers);
          return "Email sent";
      }
?>
