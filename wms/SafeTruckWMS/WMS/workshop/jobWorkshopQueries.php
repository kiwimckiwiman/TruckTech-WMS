<?php
#require('fpdf185/fpdf.php');
function AddStep(){
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'wms';

  if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
  }

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['stepDescr'])) {
      $stepDescr = $_POST['stepDescr'];
      $item_id = $_POST['inventory_item'];
      $quantity = $_POST['quantity'];
      $comment = $_POST['comment'];
      $job_id = $_SESSION['job_id'];
      $item = getItem($_SESSION['workshop_id'],$item_id);
      $totalPrice = $item['price']* $quantity;
      //$worker_id = $_SESSION['worker_id']; // Replace 'worker_id' with the actual variable containing the worker ID
      $worker_id = NULL;
      $finish=0;
      // Prepare the SQL statement for inserting user data into the table
      $stmt = $conn->prepare("INSERT INTO steps (job_id, time_created, descr, worker_id, comment, item_id, quantity, total_item_price,finish) 
      VALUES (:job_id, NOW(), :stepDescr, :worker_id, :comment, :item_id, :quantity, :totalprice, :finish)");
      $stmt->bindParam(':job_id', $job_id);
      $stmt->bindParam(':stepDescr', $stepDescr);
      $stmt->bindParam(':worker_id', $worker_id); // Replace 'worker_id' with the actual variable containing the worker ID
      $stmt->bindParam(':comment', $comment);
      $stmt->bindParam(':item_id', $item_id);
      $stmt->bindParam(':quantity', $quantity);
      $stmt->bindParam(':totalprice', $totalPrice);
      $stmt->bindParam(':finish', $finish);
      $stmt->execute();
      echo "Record inserted successfully.";

      $updateStmt = $conn->prepare("UPDATE inventory SET quantity = quantity - :quantity WHERE item_id = :item_id");
      $updateStmt->bindParam(':quantity', $quantity);
      $updateStmt->bindParam(':item_id', $item_id);
      $updateStmt->execute();
    }
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function getAllWorkshopItems($id){  
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

  $sql = "SELECT * FROM inventory WHERE workshop_id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
  } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
}
function FinishStep($stepID){
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'wms';
  
  try {
      // Create a PDO connection
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      // Prepare and execute the update statement
      $stmt = $conn->prepare("UPDATE steps SET finish = :finish WHERE step_id = :step_id");
      $stmt->bindParam(':step_id', $stepID);
      $stmt->bindValue(':finish', 1, PDO::PARAM_INT);
      $stmt->execute();
      #echo "Quantity updated successfully!";
  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
  }
function AlterInventory($itemId,$stepQty){
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'wms';

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the update statement
    $stmt = $conn->prepare("UPDATE inventory SET quantity = :quantity WHERE item_id = :item_id");
    $stmt->bindParam(':quantity', $stepQty);
    $stmt->bindParam(':item_id', $itemId);
    $stmt->execute();

    echo "Quantity updated successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
}

function deleteStep($stepID) {
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'wms';

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Prepare and execute the SQL query to delete the item
    $sql = "DELETE FROM steps WHERE step_id = :step_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':step_id', $stepID);
    $stmt->execute();
    
    // Check if any rows were affected by the delete query
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      return true; // Return true if the item was successfully deleted
    } else {
      return false; // Return false if the item was not found or could not be deleted
    }
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    return false; // Return false if there was an error with the database connection or query
  }
}

function getItem($workshop_id, $item_id) {
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
      $sql = "SELECT * FROM inventory WHERE workshop_id = :workshop_id AND item_id = :item_id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->bindParam(':item_id', $item_id);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results[0];
  } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}

function getAllCompletedSteps($job_id) {
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'wms';
  $finish = 1;
 
  if ( mysqli_connect_errno() ) {
      exit('Failed to connect to MySQL: ' . mysqli_connect_error());
  }
  try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT * FROM steps WHERE job_id = :job_id AND finish = :finish";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':job_id', $job_id);
      $stmt->bindParam(':finish', $finish);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
  } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}
function getAllSteps($job_id) {
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'wms';
  $finish = 0;
 
  if ( mysqli_connect_errno() ) {
      exit('Failed to connect to MySQL: ' . mysqli_connect_error());
  }
  try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT * FROM steps WHERE job_id = :job_id AND finish = :finish";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':job_id', $job_id);
      $stmt->bindParam(':finish', $finish);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
  } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}
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
function DeleteJob($jobId) {
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'wms';

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("DELETE FROM jobs WHERE job_id = :jobId");
    $stmt->bindParam(':jobId', $jobId);
    $stmt->execute();
    // No need to fetch results after DELETE statement
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

    //echo "A job finished successfully.";
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