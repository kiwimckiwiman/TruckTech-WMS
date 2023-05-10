<?php
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

  //--- BOOKING ADMIN SQL FUNCTIONS ---

  function ViewAllPendingBookings($workshop_id)
  {
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Bookings WHERE accepted_status = 'pending' AND workshop_id = :workshop_id");
    $stmt->bindParam(":workshop_id", $workshop_id, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;
    return $stmt;
  }

  function ViewAllAcceptedBookings($workshop_id)
  {
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Bookings WHERE accepted_status = 'accepted' AND workshop_id = :workshop_id");
    $stmt->bindParam(":workshop_id", $workshop_id, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;
    return $stmt;
  }

  function ToggleAcceptBooking($booking_id)
  {
    $stmt = $GLOBALS['conn']->prepare("SELECT accepted_status FROM Bookings WHERE booking_id = :booking_id");
    $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $result = $stmt->fetch();
    $accepted_status = $result[0];

    if(($accepted_status == 'pending')){
      $stmt = $GLOBALS['conn']->prepare("UPDATE Bookings SET accepted_status = 'accepted' WHERE booking_id = :booking_id");
      $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
      $stmt->execute() or die($GLOBALS['conn']->error);

      $stmt = $GLOBALS['conn']->prepare("SELECT booking_id FROM Bookings WHERE booking_id = :booking_id");
      $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
      $stmt->execute() or die($GLOBALS['conn']->error);
      $result = $stmt->fetch();
      $booking_id = $result[0];
    }
  }

  function ToggleRejectBooking($booking_id)
  {
    $stmt = $GLOBALS['conn']->prepare("SELECT accepted_status FROM Bookings WHERE booking_id = :booking_id");
    $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $result = $stmt->fetch();
    $accepted_status = $result[0];

    if(($accepted_status == 'pending')){
      $stmt = $GLOBALS['conn']->prepare("UPDATE Bookings SET accepted_status = 'rejected' WHERE booking_id = :booking_id");
      $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
      $stmt->execute() or die($GLOBALS['conn']->error);

      $stmt = $GLOBALS['conn']->prepare("SELECT booking_id FROM Bookings WHERE booking_id = :booking_id");
      $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
      $stmt->execute() or die($GLOBALS['conn']->error);
      $result = $stmt->fetch();
      $booking_id = $result[0];
    }
  }

  function ToggleDeleteBooking($booking_id)
  {
    $stmt = $GLOBALS['conn']->prepare("DELETE FROM Bookings WHERE booking_id = :booking_id AND accepted_status = 'accepted'");
    $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error); 
  }

 ?>