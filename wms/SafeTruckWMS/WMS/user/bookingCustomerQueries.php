<?php
    // $servername = 'localhost';
    // $username = 'root';
    // $password = '';
    // $dbname = 'wms';

    // if ( mysqli_connect_errno() ) {
    // 	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    // }

    // try{
    //   $GLOBALS['conn'] = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    //   $GLOBALS['conn']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // } catch(PDOException $e) {
    //   echo "Error: " . $e->getMessage();
    // }

    function CreateBooking($customer_id, $workshop_id, $vehicle_plate, $vehicle_make, $customer_lng, $customer_ltd, $description, $accepted_status){
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

      // if(isset($_POST['vehicle_plate'])){
      //   $customer_id = 1;
      //   $workshop_id = $_POST['workshop_id'];
      //   $vehicle_plate = $_POST['vehicle_plate'];
      //   $vehicle_make = $_POST['vehicle_make'];
      //   $customer_lng = $_POST['customer_lng'];
      //   $customer_ltd = $_POST['customer_ltd'];
      //   $description = $_POST['description'];
      //   $accepted_status = 'pending';
      // }
        $stmt = $conn->prepare("INSERT INTO bookings 
        (customer_id, workshop_id, vehicle_plate, vehicle_make, customer_lng, customer_ltd, description, accepted_status) 
        VALUES (:customer_id, :workshop_id, :vehicle_plate, :vehicle_make, :customer_lng, :customer_ltd, :description, :accepted_status)");        
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->bindParam(':workshop_id', $workshop_id);
        $stmt->bindParam(':vehicle_plate', $vehicle_plate);
        $stmt->bindParam(':vehicle_make', $vehicle_make);
        $stmt->bindParam(':customer_lng', $customer_lng);
        $stmt->bindParam(':customer_ltd', $customer_ltd);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':accepted_status', $accepted_status);
        $stmt->execute();
        echo "New booking added successfully.";
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    }

    function ViewCustomerBookings($customer_id){
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

        $stmt = $conn->prepare("SELECT * FROM bookings WHERE customer_id = :customer_id AND accepted_status = 'pending'");
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    }

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

        $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = :booking_id AND accepted_status = 'pending'");
        $stmt->bindParam(':booking_id', $booking_id);
        $stmt->execute();
        echo "New booking deleted successfully.";
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