<?php
  function AddWorkshopOwner($name, $email, $user, $gender, $DOB, $phone_no, $company){
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

        $stmt = $conn->prepare("SELECT DISTINCT 1 FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute() or die($GLOBALS['conn']->error);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $chk = $stmt->fetch();

        if ($chk == false) {
          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $password = '';

          for ($i = 0; $i < 10; $i++) {
              $index = rand(0, strlen($characters) - 1);
              $password .= $characters[$index];
          }

          $password_hashed = password_hash($password,PASSWORD_DEFAULT);
          $type = "a";


          // Prepare the SQL statement for inserting user data into the table
          $stmt = $conn->prepare("INSERT INTO users (name, email, username, password, DOB, phone_no, company, type, gender)
                                  VALUES (:name, :email, :username, :password, :DOB, :phone_no, :company,:type, :gender)");

          // Bind the user data values to the prepared statement parameters
          $stmt->bindParam(':name', $name);
          $stmt->bindParam(':email', $email);
          $stmt->bindParam(':username', $user);
          $stmt->bindParam(':password', $password_hashed);
          $stmt->bindParam(':type', $type);
          $stmt->bindParam(':DOB', $DOB);
          $stmt->bindParam(':phone_no', $phone_no);
          $stmt->bindParam(':company', $company);
          $stmt->bindParam(':gender', $gender);
          // Execute the prepared statement to insert the user data into the table
          $stmt->execute();

          $site = "localhost/wms/SafeTruckWMS/WMS/login/login.php";
          $content = "<!DOCTYPE html>
                        <html>
                        <head>
                        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                        </head>
                        <body>

                        <div>
                                <h3>Welcome to SafeTruck Workshop Management System</h3>
                                <h4>Here are your details:</h4?>
                                <p>Username: ".$email."</p>
                                <p>Password: ".$password."</p>
                                <p>Login here:</p>
                                <a href =\"".$site."\"><h4>".$site."</h4></a>
                                <p>You may change your password by navigating to the 'Profile' tab on the navigation bar once logged in</p>
                                </br>
                        </div>
                        </body>
                        </html>";
            $headers  = "From: loll8441@gmail.com\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

          mail($email, 'Login Details', $content, $headers);

          $conn = null;
          return " class=\"text-success\">Account has been created";
        }else{
          return " class=\"text-danger\">Email already registered";
        }
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    }

    function GetWorkshopsByOwner($id){
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

        $sql = "SELECT * FROM workshops WHERE workshop_owner_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;

        return $results;
    }

    function GetWorkshop($id){
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

        $sql = "SELECT * FROM workshops WHERE workshop_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;

        return $results;
    }

    function GetWorkshopAndOwner($id){
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

      $sql = "SELECT a.*, a.name AS workshop_name, b.user_id, b.name FROM workshops a JOIN users b ON a.workshop_owner_id = b.user_id WHERE a.workshop_id = :id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
      }
      $conn = null;

      return $results;
    }

    function GetAllWorkshops($page_no){
      $lim = 10;
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
          $stmt = $conn->prepare("SELECT * FROM workshops LIMIT :start, :fin");
          $start = ($page_no-1)*$lim;
          $stmt->bindParam(':start', $start, PDO::PARAM_INT);
          $stmt->bindParam(':fin', $lim, PDO::PARAM_INT);
          $stmt->execute();
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
      }
      $conn = null;

      return $results;
    }

    function GetWorkshopOwners(){
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
          $sql = "SELECT user_id, name, company, email, phone_no, DOB, gender FROM users WHERE type = 'a'";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
      }
      $conn = null;

      return $results;
    }

  function AddWorkshop($name, $location, $opening_hrs, $specialisations, $phone_no, $workshop_owner_id, $workshop_ltd, $workshop_lng){
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

    $stmt = $conn->prepare("INSERT INTO workshops (name, location, opening_hours, specialisations, phone_no, workshop_owner_id, workshop_lng, workshop_ltd)
                            VALUES (:name, :location, :opening_hours, :specialisations, :phone_no, :workshop_owner_id, :workshop_lng,:workshop_ltd)");

    // Bind the workshop data values to the prepared statement parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':opening_hours', $opening_hours);
    $stmt->bindParam(':specialisations', $specialisations);
    $stmt->bindParam(':phone_no', $phone_no);
    $stmt->bindParam(':workshop_owner_id', $workshop_owner_id);
    $stmt->bindParam(':workshop_ltd', $workshop_ltd);
    $stmt->bindParam(':workshop_lng', $workshop_lng);

    // Execute the prepared statement to insert the workshop data into the table
    $stmt->execute();
    // Prepare the SQL statement for inserting workshop data into the table

  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

  function GetAllOwners($page_no){
    $lim = 10;
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
        $stmt = $conn->prepare("SELECT user_id, name, company, email, phone_no, DOB, gender FROM users WHERE type = 'a' LIMIT :start, :fin");
        $start = ($page_no-1)*$lim;
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':fin', $lim, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

    return $results;
  }

  function GetOwner($id){
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
        $stmt = $conn->prepare("SELECT user_id, name, company, email, phone_no, DOB, gender FROM users WHERE type = 'a' AND user_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

    return $results;
  }

  function GetOwnerSearch($search){
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
    $search = $search . "%";
    if ( mysqli_connect_errno() ) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT user_id, name, company, email, phone_no, DOB, gender FROM users WHERE name LIKE :search");
        $stmt->bindParam(':search', $search, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

    return $results;
  }

  function GetWorkshopSearch($search){
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
    $search = $search . "%";
    if ( mysqli_connect_errno() ) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM workshops WHERE name LIKE :search");
        $stmt->bindParam(':search', $search, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

    return $results;
  }

  function DeleteWorkshop($id){
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
        $stmt = $conn->prepare("DELETE FROM workshops WHERE workshop_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
  }

  function DeleteOwner($id){
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
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
  }
?>
