<?php
function ViewWorkshopJobs($workshop_id){
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

        $stmt = $conn->prepare("SELECT * FROM jobs WHERE workshop_id = :workshop_id");
        $stmt->bindParam(':workshop_id', $workshop_id);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function DeleteWorkshopJob($job_id){
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
        if (gettype($result) == 'boolean'){
          throw new Exception("This job is no longer available");
        }else{
          $stmt = $conn->prepare("DELETE FROM jobs WHERE job_id = :job_id");
          $stmt->bindParam(':job_id', $job_id);
          $stmt->execute();
          echo "Job deleted successfully.";
        }
      }catch(Exception $e) {
        echo 'Message: ' .$e->getMessage();
      }
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
}

function ViewWorkshopJob($job_id){
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

function EditWorkshopJobWorkerComment($job_id){
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

        $stmt = $conn->prepare("UPDATE Jobs SET worker_id = :worker_id, comment = :comment WHERE job_id = :job_id");
        $stmt->bindParam(':job_id', $job_id);
        $stmt->bindParam(':worker_id', $worker_id);
        $stmt->bindParam(':comment', $comment);
        $stmt->execute();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function FinishWorkshopJob($job_id){
    //update finish_time + generate invoice (PDF? FPDF library)
    //only available if finish_time is NULL
}
?>