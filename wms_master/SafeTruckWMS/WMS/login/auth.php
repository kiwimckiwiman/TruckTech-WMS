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
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
    $stmt->execute() or die($conn->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $conn = null;

    if ($stmt->rowCount() > 0) {
    	$account = $stmt->fetch();
      $password = $_POST['password'];
    	if (password_verify($password, $account['password'])) {
        session_start();
    		$_SESSION['loggedin'] = TRUE;
    		$_SESSION['name'] = $account["name"];
    		$_SESSION['id'] = $account["user_id"];
        $_SESSION['type'] = $account["type"];
        $_SESSION['email'] = $account["email"];
        switch($_SESSION['type']){
          case "c":
            header('Location: ../user/bookings/select_type.php');
            break;
          case "a":
            header('Location: ../workshop/admin/home/dashboard.php');
            break;
          case "s":
            header('Location: ../admin/home/dashboard.php');
            break;
          case "w":
          header('Location: ../workshop/worker/home/dashboard.php');
            break;
        }
    	} else {
    		header('Location: login.php?error=inc');
    	}
    } else {
    	header('Location: login.php?error=unk');
    }
  }else{
    header('Location: login.php?error=empty');
  }
?>
