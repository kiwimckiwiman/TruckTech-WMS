<?php
  function ViewCustomerJobs($customer_id){
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

      $stmt = $conn->prepare("SELECT * FROM jobs a JOIN workshops b ON a.workshop_id = b.workshop_id WHERE a.customer_id = :customer_id AND a.finish_time IS NULL ORDER BY a.start_time DESC");
      $stmt->bindParam(':customer_id', $customer_id);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }

  function ViewCustomerPrevJobs($customer_id){
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

      $stmt = $conn->prepare("SELECT * FROM jobs a JOIN workshops b ON a.workshop_id = b.workshop_id WHERE a.customer_id = :customer_id AND a.finish_time IS NOT NULL ORDER BY a.start_time DESC");
      $stmt->bindParam(':customer_id', $customer_id);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }

  function ViewCustomerPrevJob($customer_id, $job_id){
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

      $stmt = $conn->prepare("SELECT * FROM jobs a JOIN workshops b ON a.workshop_id = b.workshop_id WHERE a.customer_id = :customer_id AND a.finish_time IS NOT NULL AND a.job_id = :job_id");
      $stmt->bindParam(':job_id', $job_id);
      $stmt->bindParam(':customer_id', $customer_id);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results[0];
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }

  function ViewCustomerJob($customer_id, $job_id){
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

      $stmt = $conn->prepare("SELECT * FROM jobs a JOIN workshops b ON a.workshop_id = b.workshop_id WHERE a.customer_id = :customer_id AND a.job_id = :job_id");
      $stmt->bindParam(':job_id', $job_id);
      $stmt->bindParam(':customer_id', $customer_id);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results[0];
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }

  function UpdateCustomerJobFeedbackRating($job_id, $feedback, $rating){
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

          $stmt = $conn->prepare("SELECT * FROM Jobs WHERE job_id = :job_id");
          $stmt->bindParam(':job_id', $job_id);
          $stmt->execute();
          $result = $stmt->fetch();

          try{
            if (is_null($result['feedback']) == true && is_null($result['finish_time']) == false){
              $stmt = $conn->prepare("UPDATE Jobs SET feedback = :feedback, rating = :rating WHERE job_id = :job_id");
              $stmt->bindParam(':job_id', $job_id);
              $stmt->bindParam(':feedback', $feedback);
              $stmt->bindParam(':rating', $rating);
              $stmt->execute();
              echo "Thank you for your feedback.";
            }else{
              throw new Exception("You cannot give feedback now.");
            }
          }catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
          }
      } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
      }
  }
 ?>
