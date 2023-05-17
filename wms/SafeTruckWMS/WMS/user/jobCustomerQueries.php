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

        $stmt = $conn->prepare("SELECT * FROM jobs WHERE customer_id = :customer_id");
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function ViewCustomerOngoingJobs($customer_id){
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

        $stmt = $conn->prepare("SELECT * FROM jobs WHERE finish_time IS NULL AND customer_id = :customer_id");
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function ViewCustomerFinishedJobs($customer_id){
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

        $stmt = $conn->prepare("SELECT * FROM jobs WHERE finish_time IS NOT NULL AND customer_id = :customer_id");
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function ViewCustomerJob($job_id){
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

        $stmt = $conn->prepare("SELECT * FROM jobs WHERE job_id = :job_id");
        $stmt->bindParam(':job_id', $job_id);
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

function getCustomerDetails($id){
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
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }
?>