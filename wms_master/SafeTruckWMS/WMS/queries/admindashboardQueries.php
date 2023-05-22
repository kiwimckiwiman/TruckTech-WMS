<?php
#require('fpdf185/fpdf.php');
function SalesChart(){
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
              WHERE finish_time >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)
              GROUP BY DATE(DATE_FORMAT(finish_time, '%Y-%m-%d'))";

    // Prepare the statement
    $statement = $conn->prepare($query);

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
function calculateRejectionPercentage() {
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
  
      $sql = "SELECT COUNT(*) AS rejected_bookings FROM bookings WHERE accepted_status = 'rejected'";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $rejectedBookings = $result['rejected_bookings'];
  
      // Calculate the rejection percentage
      $percentage = ($rejectedBookings / $totalBookings) * 100;
      $percentage = number_format($percentage, 2);
      return $percentage;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  
function calculateAcceptancePercentage() {
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
  
      $sql = "SELECT COUNT(*) AS accepted_bookings FROM bookings WHERE accepted_status = 'accepted'";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $acceptedBookings = $result['accepted_bookings'];
  
      // Calculate the acceptance percentage
      $percentage = ($acceptedBookings / $totalBookings) * 100;
      $percentage = number_format($percentage, 2);
      return $percentage;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  
function countPendingBookingsForBestWorkshop() {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
  
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      $sql = "SELECT workshop_id, COUNT(*) AS completed_jobs FROM bookings WHERE accepted_status = 'accepted' GROUP BY workshop_id ORDER BY completed_jobs DESC LIMIT 1";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $workshopId = $result['workshop_id'];
  
      $sql = "SELECT COUNT(*) AS total_accepted_bookings FROM bookings WHERE accepted_status = 'pending' AND workshop_id = :workshop_id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':workshop_id', $workshopId);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $totalAcceptedBookings = $result['total_accepted_bookings'];
  
      return $totalAcceptedBookings;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
function countrejectedBookingsForBestWorkshop() {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
  
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      $sql = "SELECT workshop_id, COUNT(*) AS completed_jobs FROM bookings WHERE accepted_status = 'accepted' GROUP BY workshop_id ORDER BY completed_jobs DESC LIMIT 1";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $workshopId = $result['workshop_id'];
  
      $sql = "SELECT COUNT(*) AS total_accepted_bookings FROM bookings WHERE accepted_status = 'rejected' AND workshop_id = :workshop_id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':workshop_id', $workshopId);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $totalAcceptedBookings = $result['total_accepted_bookings'];
  
      return $totalAcceptedBookings;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
function countAcceptedBookingsForBestWorkshop() {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
  
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      $sql = "SELECT workshop_id, COUNT(*) AS completed_jobs FROM bookings WHERE accepted_status = 'accepted' GROUP BY workshop_id ORDER BY completed_jobs DESC LIMIT 1";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $workshopId = $result['workshop_id'];
  
      $sql = "SELECT COUNT(*) AS total_accepted_bookings FROM bookings WHERE accepted_status = 'accepted' AND workshop_id = :workshop_id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':workshop_id', $workshopId);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $totalAcceptedBookings = $result['total_accepted_bookings'];
  
      return $totalAcceptedBookings;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  
function getWorkshopWithMostCompletedJobs() {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
  
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      $sql = "SELECT workshop_id, COUNT(*) AS completed_jobs FROM bookings WHERE accepted_status = 'accepted' GROUP BY workshop_id ORDER BY completed_jobs DESC LIMIT 1";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $workshopId = $result['workshop_id'];
  
      // Get the workshop name associated with the workshop_id
      $sql = "SELECT name FROM workshops WHERE workshop_id = :workshop_id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':workshop_id', $workshopId);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $workshopName = $result['name'];
  
      return $workshopName;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  
  
function getTotalWorkshopOwnersCount() {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
  
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      $sql = "SELECT COUNT(*) AS total_owners FROM users WHERE type = 'a'";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $totalOwners = $result['total_owners'];
  
      return $totalOwners;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  
function getTotalWorkshopsCount() {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
  
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      $sql = "SELECT COUNT(*) AS total_workshops FROM workshops";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $totalWorkshops = $result['total_workshops'];
  
      return $totalWorkshops;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  

?>