<?php
  if(isset($_POST['token']) && !empty($_POST['token'])){
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

    $token = $_POST['token'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = "New User";
    $type = "c";

    $stmt = $conn->prepare("SELECT DISTINCT 1 FROM new_login_table WHERE email = :email AND token = :token");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':token', $token, PDO::PARAM_INT);
    $stmt->execute() or die($conn->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $chk = $stmt->fetch();

    if ($chk == true) {
      $stmt = $conn->prepare("INSERT INTO users (name, email, password, type) VALUES (:name, :email, :password, :type)");
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':password', $password);
      $stmt->bindParam(':type', $type, PDO::PARAM_STR);
      $stmt->execute() or die($conn->error);

      $stmt = $conn->prepare("DELETE FROM new_login_table WHERE email = :email");
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->execute() or die($conn->error);

      header('Location: login.php?success=true');
    }else{
      $stmt = $conn->prepare("DELETE FROM new_login_table WHERE email = :email");
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->execute() or die($conn->error);
      $conn = null;
      header('Location: register.php?error=inc');
    }
  }
?>
