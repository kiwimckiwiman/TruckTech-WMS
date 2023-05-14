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
        return $results;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function UpdateCustomerJobFeedback($job_id, $feedback){
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
          if (is_null($result['feedback']) == true &&  is_null($result['finish_time']) == false){
            $stmt = $conn->prepare("UPDATE Jobs SET feedback = :feedback WHERE job_id = :job_id");
            $stmt->bindParam(':job_id', $job_id);
            $stmt->bindParam(':feedback', $feedback);
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