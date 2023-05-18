<?php
#require('fpdf185/fpdf.php');

function SalesChart($workshop_id){
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'wms';

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve the sum of total_price and service_fee from the jobs table for the last one week
    $query = "SELECT DATE(DATE_FORMAT(finish_time, '%Y-%m-%d')) AS date, SUM(service_fee) AS total_service_fee, SUM(total_price) AS total_price
              FROM jobs
              WHERE workshop_id = :workshop_id AND finish_time >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)
              GROUP BY DATE(DATE_FORMAT(finish_time, '%Y-%m-%d'))";

    // Prepare the statement
    $statement = $conn->prepare($query);

    // Bind the workshop_id parameter
    $statement->bindParam(':workshop_id', $workshop_id);

    // Execute the query
    $statement->execute();

    // Fetch the results as an associative array
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    $chartData = [['Date', 'Total Sales']];
    foreach ($results as $row) {
      $chartData[] = [
        $row['date'],
        (int) $row['total_price'] + $row['total_service_fee']
      ];
    }
  
    return $chartData;
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
function calculateSales($workshopId) {
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'wms';

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve the sum of total_price and service_fee from the jobs table
    $sql = "SELECT SUM(total_price + service_fee) AS total_sales FROM jobs WHERE workshop_id = :workshopId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':workshopId', $workshopId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalSales = $result['total_sales'];

    return $totalSales;
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
function getRejectedBookingsPercentage($workshop_id) {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
  
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      $sql = "SELECT COUNT(*) AS total_bookings FROM bookings";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $totalBookings = $result['total_bookings'];
  
      $sql = "SELECT COUNT(*) AS rejected_bookings FROM bookings WHERE workshop_id = :workshop_id AND accepted_status = 'rejected'";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $rejectedBookings = $result['rejected_bookings'];
  
      // Calculate the percentage
      $percentage = ($rejectedBookings / $totalBookings) * 100;
      $percentage = number_format($percentage, 2);
  
      return $percentage;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  
function getAcceptedBookingsPercentage($workshop_id) {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
  
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      $sql = "SELECT COUNT(*) AS total_bookings FROM bookings";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $totalBookings = $result['total_bookings'];
  
      $sql = "SELECT COUNT(*) AS accepted_bookings FROM bookings WHERE workshop_id = :workshop_id AND accepted_status = 'accepted'";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $acceptedBookings = $result['accepted_bookings'];
      
      // Calculate the percentage
      $percentage = ($acceptedBookings / $totalBookings) * 100;
      $percentage = number_format($percentage, 2);
      return $percentage;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  
function getPendingBookingsCount($workshop_id) {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
  
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      $acceptedStatus = 'pending';
      $sql = "SELECT COUNT(*) AS count_number FROM bookings WHERE workshop_id = :workshop_id AND accepted_status = :accepted_status";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->bindParam(':accepted_status', $acceptedStatus);
      $stmt->execute();
  
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $count = $result['count_number'];
  
      return $count;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
function getRejectedBookingsCount($workshop_id) {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
  
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      $acceptedStatus = 'rejected';
      $sql = "SELECT COUNT(*) AS count_number FROM bookings WHERE workshop_id = :workshop_id AND accepted_status = :accepted_status";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->bindParam(':accepted_status', $acceptedStatus);
      $stmt->execute();
  
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $count = $result['count_number'];
  
      return $count;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
function getAcceptedBookingsCount($workshop_id) {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
  
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      $acceptedStatus = 'accepted';
      $sql = "SELECT COUNT(*) AS count_number FROM bookings WHERE workshop_id = :workshop_id AND accepted_status = :accepted_status";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->bindParam(':accepted_status', $acceptedStatus);
      $stmt->execute();
  
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $count = $result['count_number'];
  
      return $count;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  


function getEmployeeCount($workshop_id) {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
  
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      $sql = "SELECT COUNT(*) AS count_number FROM workers WHERE workshop_id = :workshop_id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->execute();
  
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $count = $result['count_number'];
  
      return $count;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  


function getInventoryItemCount($workshop_id) {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
  
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      $sql = "SELECT COUNT(*) AS count_number FROM inventory WHERE workshop_id = :workshop_id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->execute();
  
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $count = $result['count_number'];
  
      return $count;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  
function getAllBookings($workshop_id) {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
   
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      $sql = "SELECT COUNT(*) AS count_number FROM bookings WHERE workshop_id = :workshop_id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->execute();
      
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $count = $result['count_number'];
      
      return $count;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  

?>