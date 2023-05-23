<?php
function AddWorker($name, $email, $gender, $DOB, $phone_no, $company, $inv, $job, $workshop_id){
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
        $type = "w";


        // Prepare the SQL statement for inserting user data into the table
        // start transaction
        $conn->beginTransaction();

        // prepare and execute the first query
        $stmt1 = $conn->prepare("INSERT INTO users (email, password, name, DOB, company, phone_no, type, gender)
                                 VALUES (:email, :password, :name, :DOB, :company, :phone_no, :type, :gender)");

        $stmt1->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt1->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt1->bindParam(':password', $password_hashed, PDO::PARAM_STR);
        $stmt1->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt1->bindParam(':DOB', $DOB);
        $stmt1->bindParam(':phone_no', $phone_no, PDO::PARAM_STR);
        $stmt1->bindParam(':company', $company, PDO::PARAM_STR);
        $stmt1->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt1->execute();

        // prepare and execute the second query
        $stmt2 = $conn->prepare("INSERT INTO workers
                                 VALUES ((SELECT MAX(user_id) FROM users WHERE company = :company AND type = :type), :workshop_id, :inv, :job)");

        $stmt2->bindParam(':company', $company, PDO::PARAM_STR);
        $stmt2->bindParam(':workshop_id', $workshop_id, PDO::PARAM_INT);
        $stmt2->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt2->bindParam(':inv', $inv, PDO::PARAM_INT);
        $stmt2->bindParam(':job', $job, PDO::PARAM_INT);
        $stmt2->execute();

        // commit transaction
        $conn->commit();


        //$site = "localhost/wms/SafeTruckWMS/WMS/login/login.php";
      //  $content = "<!DOCTYPE html>
      //                <html>
      //                <head>
      //                <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
      //                </head>
      //                <body>
//
      //                <div>
      //                        <h3>Welcome to SafeTruck Workshop Management System</h3>
    //  //                        <p>Username: ".$email."</p>
    //                          <p>Password: ".$password."</p>
    //                          <p>Login here:</p>
    //                          <a href =\"".$site."\"><h4>".$site."</h4></a>
    //                          <p>You may change your password by navigating to the 'Profile' tab on the navigation bar once logged in</p>
    //                          </br>
    //                  </div>
    //                  </html>";
    //      $headers  = "From: loll8441@gmail.com\r\n";
  //        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
//
  //      mail($email, 'Login Details', $content, $headers);
//      $conn = null;
      //  return " class=\"text-success\">Account has been created";
      }else{
        return " class=\"text-danger\">Email already registered";
      }
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }

    function GetAllWorkers($workshop_id, $page_no){
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
          $stmt = $conn->prepare("SELECT * FROM workers a JOIN users b ON a.worker_id = b.user_id WHERE a.workshop_id = :workshop_id LIMIT :start, :fin");
          $start = ($page_no-1)*$lim;
          $stmt->bindParam(':start', $start, PDO::PARAM_INT);
          $stmt->bindParam(':fin', $lim, PDO::PARAM_INT);
          $stmt->bindParam(':workshop_id', $workshop_id, PDO::PARAM_INT);

          $stmt->execute();
          $conn = null;
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
          return $results;
      } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
      }
    }

    function GetWorker($id){
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
          $stmt = $conn->prepare("SELECT * FROM workers a JOIN users b ON a.worker_id = b.user_id WHERE user_id = :id;");
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->execute();
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
          return $results[0];
      } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
      }
    }

    function GetWorkerSearch($workshop_id, $search, $job, $inv){
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
          $sql = "SELECT * FROM workers a JOIN users b ON a.worker_id = b.user_id WHERE a.workshop_id = :workshop_id AND";

          if(!(empty($search))){
            $sql .= " b.name LIKE :search AND";
          }

          if($inv == "1"){
            $sql .= " a.has_inventory_access = \"1\" AND";
          }

          if($job == "1"){
            $sql .= " a.has_job_access = \"1\" AND";
          }

          $sql = rtrim($sql, " AND");
          $sql .= ";";
          $stmt = $conn->prepare($sql);

          if(!(empty($search))){
            $search = $search . "%";
            $stmt->bindParam(':search', $search, PDO::PARAM_STR);
          }

          $stmt->bindParam(':workshop_id', $workshop_id, PDO::PARAM_INT);
          $stmt->execute();
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
      }
      $conn = null;

      return $results;
    }

    function UpdateAccess($type, $id){
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
          if($type == "inv"){
            $stmt = $conn->prepare("UPDATE workers
                                    SET has_inventory_access =
                                      CASE
                                        WHEN has_inventory_access = 1 THEN 0
                                        ELSE 1
                                      END
                                    WHERE worker_id = :id;");
          }else{
            $stmt = $conn->prepare("UPDATE workers
                                    SET has_job_access =
                                      CASE
                                        WHEN has_job_access = 1 THEN 0
                                        ELSE 1
                                      END
                                    WHERE worker_id = :id;");
          }

          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->execute();
      } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
      }
    }
?>
