<?php
    function CreateBooking($customer_id, $workshop_id, $vehicle_plate, $vehicle_make, $customer_lng, $customer_ltd, $description, $pickup, $accepted_status){
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

        $stmt = $conn->prepare("INSERT INTO bookings
        (customer_id, workshop_id, vehicle_plate, vehicle_make, customer_lng, customer_ltd, description, require_pickup, accepted_status)
        VALUES (:customer_id, :workshop_id, :vehicle_plate, :vehicle_make, :customer_lng, :customer_ltd, :description, :pickup, :accepted_status)");
        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->bindParam(':workshop_id', $workshop_id, PDO::PARAM_INT);
        $stmt->bindParam(':vehicle_plate', $vehicle_plate, PDO::PARAM_STR);
        $stmt->bindParam(':vehicle_make', $vehicle_make, PDO::PARAM_STR);
        $stmt->bindParam(':customer_lng', $customer_lng);
        $stmt->bindParam(':customer_ltd', $customer_ltd);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':pickup', $pickup, PDO::PARAM_INT);
        $stmt->bindParam(':accepted_status', $accepted_status, PDO::PARAM_STR);
        $stmt->execute();
        echo "New booking added successfully.";
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    }

    function ViewCustomerBookings($customer_id, $page_no){
      $lim = 10;
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

        $stmt = $conn->prepare("SELECT * FROM bookings a JOIN workshops b ON a.workshop_id = b.workshop_id WHERE customer_id = :customer_id AND accepted_status = 'pending' ORDER BY a.time_created DESC LIMIT :start, :fin");
        $start = ($page_no-1)*$lim;
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':fin', $lim, PDO::PARAM_INT);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    }

    // function DeleteCustomerBooking($booking_id){
    //   $servername = 'localhost';
    //   $username = 'root';
    //   $password = '';
    //   $dbname = 'wms';

    //   if ( mysqli_connect_errno() ) {
    //     exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    //   }
    //   try {
    //     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //     $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = :booking_id AND accepted_status = 'pending'");
    //     $stmt->bindParam(':booking_id', $booking_id);
    //     $stmt->execute();
    //     echo "New booking deleted successfully.";
    //   } catch(PDOException $e) {
    //     echo "Error: " . $e->getMessage();
    //   }
    // }

    function DeleteCustomerBooking($booking_id){
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

        $stmt = $conn->prepare("SELECT * FROM Bookings WHERE booking_id = :booking_id");
        $stmt->bindParam(':booking_id', $booking_id);
        $stmt->execute();
        $result = $stmt->fetch();

        try{
          if (gettype($result) == 'boolean'){
            throw new Exception("This booking is no longer available");
          }else{
            $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = :booking_id AND accepted_status = 'pending'");
            $stmt->bindParam(':booking_id', $booking_id);
            $stmt->execute();
            echo "New booking deleted successfully.";
          }
        }catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    }

    function ViewWorkshops(){
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

        $stmt = $conn->prepare("SELECT * FROM workshops");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    }
?>
