<?php
  //--- BOOKING ADMIN SQL FUNCTIONS ---

  function ViewAllPendingBookings($workshop_lng, $workshop_ltd)
  {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
    if ( mysqli_connect_errno() ) {
       exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
   
    try{
       $GLOBALS['conn'] = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       $GLOBALS['conn']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch(PDOException $e) {
       echo "Error: " . $e->getMessage();
     }
    $stmt = $GLOBALS['conn']->prepare("SELECT *,
    ( 6371 * acos( cos( radians($workshop_ltd) ) * cos( radians( customer_ltd ) ) * cos( radians( customer_lng ) - radians($workshop_lng) ) + sin( radians($workshop_ltd) ) * sin(radians(customer_ltd)) ) ) AS distance 
    FROM `bookings` WHERE accepted_status = 'pending' HAVING distance < 50 ORDER BY time_created DESC");
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;
    return $stmt;
  }

  function ViewAllPendingBookingsByID($workshop_id)
  {
    $servername = 'localhost';
 $username = 'root';
 $password = '';
 $dbname = 'wms';
 if ( mysqli_connect_errno() ) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
 }

 try{
    $GLOBALS['conn'] = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $GLOBALS['conn']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Bookings WHERE accepted_status = 'pending' AND workshop_id = :workshop_id");
    $stmt->bindParam(":workshop_id", $workshop_id, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;
    return $stmt;
  }

  function ViewAllAcceptedBookings($workshop_id)
  {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
    if ( mysqli_connect_errno() ) {
       exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
   
    try{
       $GLOBALS['conn'] = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       $GLOBALS['conn']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch(PDOException $e) {
       echo "Error: " . $e->getMessage();
     }
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Bookings WHERE accepted_status = 'accepted' AND workshop_id = :workshop_id");
    $stmt->bindParam(":workshop_id", $workshop_id, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;
    return $stmt;
  }

  function ToggleAcceptBooking($booking_id, $workshop_id)
  {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
    if ( mysqli_connect_errno() ) {
       exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
   
    try{
       $GLOBALS['conn'] = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       $GLOBALS['conn']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch(PDOException $e) {
       echo "Error: " . $e->getMessage();
     }
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Bookings WHERE booking_id = :booking_id");
    $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $result = $stmt->fetch();
    try{
      if (gettype($result) == 'boolean'){
        throw new Exception("This booking is no longer available");
      }else{
        //add code to add booking to job table
        $stmt = $GLOBALS['conn']->prepare("INSERT INTO jobs 
        (workshop_id , customer_id, vehicle_plate, vehicle_make, descr) 
        VALUES (:workshop_id, :customer_id, :vehicle_plate, :vehicle_make, :descr)");
        $stmt->bindParam(':workshop_id', $workshop_id);
        $stmt->bindParam(':customer_id', $result['customer_id']);
        $stmt->bindParam(':vehicle_plate', $result['vehicle_plate']);
        $stmt->bindParam(':vehicle_make', $result['vehicle_make']);
        $stmt->bindParam(':descr', $result['description']);
        $stmt->execute() or die($GLOBALS['conn']->error);

        $stmt = $GLOBALS['conn']->prepare("DELETE FROM Bookings WHERE booking_id = :booking_id");
        $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
        $stmt->execute() or die($GLOBALS['conn']->error);
      }
    }catch(Exception $e) {
      echo 'Message: ' .$e->getMessage();
    }
  }

  function ToggleAcceptBookingByID($booking_id)
  {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
    if ( mysqli_connect_errno() ) {
       exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
   
    try{
       $GLOBALS['conn'] = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       $GLOBALS['conn']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch(PDOException $e) {
       echo "Error: " . $e->getMessage();
     }
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Bookings WHERE booking_id = :booking_id");
    $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $result = $stmt->fetch();
    try{
      if (gettype($result) == 'boolean'){
        throw new Exception("This booking is no longer available");
      }else{
        //add code to add booking to job table
        $stmt = $GLOBALS['conn']->prepare("INSERT INTO jobs 
        (workshop_id , customer_id, vehicle_plate, vehicle_make, descr) 
        VALUES (:workshop_id, :customer_id, :vehicle_plate, :vehicle_make, :descr)");
        $stmt->bindParam(':workshop_id', $result['workshop_id']);
        $stmt->bindParam(':customer_id', $result['customer_id']);
        $stmt->bindParam(':vehicle_plate', $result['vehicle_plate']);
        $stmt->bindParam(':vehicle_make', $result['vehicle_make']);
        $stmt->bindParam(':descr', $result['description']);
        $stmt->execute() or die($GLOBALS['conn']->error);

        $stmt = $GLOBALS['conn']->prepare("DELETE FROM Bookings WHERE booking_id = :booking_id");
        $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
        $stmt->execute() or die($GLOBALS['conn']->error);
      }
    }catch(Exception $e) {
      echo 'Message: ' .$e->getMessage();
    }
  }

  function ToggleRejectBooking($booking_id)
  {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
    if ( mysqli_connect_errno() ) {
       exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
   
    try{
       $GLOBALS['conn'] = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       $GLOBALS['conn']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch(PDOException $e) {
       echo "Error: " . $e->getMessage();
     }
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Bookings WHERE booking_id = :booking_id");
    $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $result = $stmt->fetch();
    try{
      if (gettype($result) == 'boolean'){
        throw new Exception("This booking is no longer available");
      }else{
        $stmt = $GLOBALS['conn']->prepare("DELETE FROM Bookings WHERE booking_id = :booking_id");
        $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
        $stmt->execute() or die($GLOBALS['conn']->error);
      }
    }catch(Exception $e) {
      echo 'Message: ' .$e->getMessage();
    }
  }

  function ToggleDeleteBooking($booking_id)
  {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
    if ( mysqli_connect_errno() ) {
       exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
   
    try{
       $GLOBALS['conn'] = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       $GLOBALS['conn']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch(PDOException $e) {
       echo "Error: " . $e->getMessage();
     }
    $stmt = $GLOBALS['conn']->prepare("DELETE FROM Bookings WHERE booking_id = :booking_id AND accepted_status = 'accepted'");
    $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error); 
  }

 ?>