<?php
require('fpdf185/fpdf.php');

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
        return $results[0];
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function EditWorkshopJobComment($job_id,$comment){
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

    $stmt = $conn->prepare("UPDATE Jobs SET comment = :comment WHERE job_id = :job_id");
    $stmt->bindParam(':job_id', $job_id);
    $stmt->bindParam(':comment', $comment);
    $stmt->execute();
    echo "New comment added successfully.";
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function FinishWorkshopJob($job_id,$service_fee){
  //update finish_time + generate invoice (PDF? FPDF library)
  //only available if finish_time is NULL
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

    $stmt = $conn->prepare("UPDATE Jobs SET service_fee = :service_fee, finish_time = CURRENT_TIMESTAMP() WHERE job_id = :job_id");
    $stmt->bindParam(':job_id', $job_id);
    $stmt->bindParam(':service_fee', $service_fee);
    $stmt->execute();

    //calculate 'steps' here for 'total_price'
    //genereate PDF script
    //store in folder
    //store the link in job table

    echo "A job finished successfully.";
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function getWorkshopDetails($id){
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
      $sql = "SELECT * FROM workshops WHERE workshop_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$id]);
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
  } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}
?>