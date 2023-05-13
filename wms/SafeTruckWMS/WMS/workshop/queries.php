<?php
  function AddWorkshopOwner(){
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
        if(isset($_POST['name'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = password_hash($password,PASSWORD_DEFAULT);
        $gender = $_POST['gender'];
        $DOB = $_POST['DOB'];
        $phone_no = $_POST['phoneNumber'];
        $company = $_POST['company'];
        $type = "a";
        }

        // Prepare the SQL statement for inserting user data into the table
        $stmt = $conn->prepare("INSERT INTO users (name, email, username, password, DOB, phone_no, company, type, gender) 
                                VALUES (:name, :email, :username, :password,  :DOB, :phone_no, :company,:type, :gender)");
      
        // Bind the user data values to the prepared statement parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':DOB', $DOB);
        $stmt->bindParam(':phone_no', $phone_no);
        $stmt->bindParam(':company', $company);
        $stmt->bindParam(':gender', $gender);
        // Execute the prepared statement to insert the user data into the table
        $stmt->execute();
        
        echo "New user added successfully.";
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    }
    function AddWorkshopWorker(){
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
          if(isset($_POST['name'])) {
          $name = $_POST['name'];
          $email = $_POST['email'];
          $username = $_POST['username'];
          $password = $_POST['password'];
          $password = password_hash($password,PASSWORD_DEFAULT);
          $gender = $_POST['gender'];
          $DOB = $_POST['DOB'];
          $phone_no = $_POST['phoneNumber'];
          $company = $_POST['company'];
          $workshop_id = $_SESSION['workshop_id'];
          $type = "w";
          }
  
          // Prepare the SQL statement for inserting user data into the table
          $stmt = $conn->prepare("INSERT INTO users (name, email, username, password, DOB, phone_no, company, type, gender) 
                                  VALUES (:name, :email, :username, :password,  :DOB, :phone_no, :company,:type, :gender)");
        
          // Bind the user data values to the prepared statement parameters
          $stmt->bindParam(':name', $name);
          $stmt->bindParam(':email', $email);
          $stmt->bindParam(':username', $username);
          $stmt->bindParam(':password', $password);
          $stmt->bindParam(':type', $type);
          $stmt->bindParam(':DOB', $DOB);
          $stmt->bindParam(':phone_no', $phone_no);
          $stmt->bindParam(':company', $company);
          $stmt->bindParam(':gender', $gender);
          // Execute the prepared statement to insert the user data into the table
          $stmt->execute();
          
          echo "New user added successfully.";
          $workerid= getWorker($email);
          giveAccess($workerid,$workshop_id,1,1); // default value is 1 for both of the modules 
        } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
      }
      function getWorker($email){
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
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $id = $result[0]['id'];
            return $id;
            } catch(PDOException $e) {
              echo "Error: " . $e->getMessage();
              }
        }
        function giveAccess($workerid,$workshop_id,$has_inventory_access,$has_job_access){
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
              $stmt = $conn->prepare("INSERT INTO workers (worker_id,workshop_id,has_inventory_access,has_job_access) VALUES (:worker_id,:workshop_id,:has_inventory_access,:has_job_access)");
              $stmt->bindParam(':worker_id', $workerid);
              $stmt->bindParam(':workshop_id', $workshop_id);
              $stmt->bindParam(':has_inventory_access', $has_inventory_access);
              $stmt->bindParam(':has_job_access', $has_job_access);
              $stmt->execute();
              } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                }
        }
    function getWorkshops($id){
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
        return $results;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
    }
    function getWorkshopOwners(){
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
          $sql = "SELECT * FROM users WHERE type = 'a'";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
          return $results;
      } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
      }
}
function getWorkshopWorkers($workshop_id){
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
      $sql = "SELECT * FROM workers WHERE workshop_id = $workshop_id";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
  } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}

function AddWorkshop(){
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


  if(isset($_POST['workshopname'])) {
    $name = $_POST['workshopname'];
    $location = $_POST['workshoplocation'];
    $opening_hours = "dededed";
    $specialisations = $_POST['workshop_special'];
    $phone_no = $_POST['phone_no'];
    $workshop_owner_id = $_POST['workshop-owner'];
    $workshop_lng = 0.04;
    $workshop_ltd = 0.043;
  }

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

  echo "New workshop added successfully.";
  // Prepare the SQL statement for inserting workshop data into the table
  
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function getAllWorkers($id){  
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

  $sql = "SELECT * FROM workers WHERE workshop_id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
  } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
}
function GetWorkerDetails($id){
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
    return $results[0];
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
}
function ChangeInventoryAccess($id,$bool){
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
    $bool = !$bool;
    $sql = "UPDATE workers SET has_inventory_access = :bool WHERE worker_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':bool', $bool, PDO::PARAM_BOOL);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
      }
  }
function ChangeJobAccess($id,$bool){
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
    $bool = !$bool;
    $sql = "UPDATE workers SET has_job_access = :bool WHERE worker_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':bool', $bool, PDO::PARAM_BOOL);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
      }
}

    ?>