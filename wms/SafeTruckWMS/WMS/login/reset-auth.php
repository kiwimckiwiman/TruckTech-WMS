<?php
  if(isset($_POST['password']) && !empty($_POST['password'])){
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
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $GLOBALS['conn']->prepare("UPDATE users SET password = :password WHERE email = :email ");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $stmt = $GLOBALS['conn']->prepare("DELETE FROM password_reset_tokens WHERE email = :email ");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $GLOBALS['conn'] = null;

    header('Location: login.php?success=reset');
  }
?>
