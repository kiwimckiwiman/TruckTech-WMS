<?php
function addStockPerItem($workshop,$item,$quantity) {
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'wms';

  try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Check if itemChoose is set in POST            
          // Update query to include input field values
          $stmt = $conn->prepare("UPDATE inventory SET quantity = :quantity WHERE item_id = :item_id AND workshop_id = :workshop_id");
            
          // Bind parameters
          $stmt->bindParam(':quantity', $quantity);
          $stmt->bindParam(':item_id', $item);
          $stmt->bindParam(':workshop_id', $workshop);
            
          // Execute query
          $stmt->execute();
          echo "Item updated successfully.";
      
  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}


function getWorkshopOwners(){
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'wms';

  try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $workshop_id = $_SESSION['workshop_id'];
      $sql = "SELECT * FROM inventory WHERE workshop_id = :workshop_id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
  } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}

// CREATING AN ITEM
// function addStockPerItem() {
//   $servername = 'localhost';
//   $username = 'root';
//   $password = '';
//   $dbname = 'wms';

//   try {
//       $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//       // Check if itemChoose is set in POST
//       if(isset($_POST['itemChoose'])) {
//           $item_id = $_POST['itemChoose'];
//           error_log($item_id);
//           $workshop_id= $_POST['workshop_id'];
//           $quantity = $_POST['quantity'];
            
//           // Update query to include input field values
//           $stmt = $conn->prepare("UPDATE inventory SET quantity = :quantity WHERE item_id= $item_id AND workshop_id= $workshop_id");
            
//           // Bind parameters
//           $stmt->bindParam(':quantity', $quantity);
//           $stmt->bindParam(':item_id', $item_id);
//           $stmt->bindParam(':workshop_id', $workshop_id);
            
//           // Execute query
//           $stmt->execute();
//           echo "Item updated successfully.";
//       } else {
//           echo "Error: itemChoose is not set in POST.";
//       }
//   } catch (PDOException $e) {
//       echo "Error: " . $e->getMessage();
//   }
// }


// function getWorkshopOwners(){
//   $servername = 'localhost';
//   $username = 'root';
//   $password = '';
//   $dbname = 'wms';

//   if ( mysqli_connect_errno() ) {
//       exit('Failed to connect to MySQL: ' . mysqli_connect_error());
//   }
//   try {
//       $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//       $workshop_id = $_SESSION['workshop_id'];
//       $sql = "SELECT * FROM inventory WHERE workshop_id = $workshop_id ";
//       $stmt = $conn->prepare($sql);
//       $stmt->execute();
//       $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//       return $results;
//   } catch(PDOException $e) {
//       echo "Error: " . $e->getMessage();
//   }
// }

function addItem(){
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
      
      if(isset($_POST['itemName'])){
      $itemName = $_POST['itemName'];
      $descr = $_POST['desc'];
      $price = $_POST['price'];
      $minStockVal = $_POST['minStockVal'];
      $myFile =  $_POST['myFile'];
      $workshop_id = $_SESSION['workshop_id'];
      $quantity = 0;
    
      

      // Prepare the SQL statement for inserting user data into the table
      $stmt = $conn->prepare("INSERT INTO inventory (workshop_id,`name`, `desc`, price, quantity,min_stock, img_name) 
                              VALUES (:workshop_id,:itemName, :descr, :price, :quantity , :minStockVal, :myFile )");
    
      // Bind the user data values to the prepared statement parameters
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->bindParam(':itemName', $itemName);
      $stmt->bindParam(':descr', $descr);
      $stmt->bindParam(':price', $price);
      $stmt->bindParam(':quantity', $quantity);
      $stmt->bindParam(':minStockVal', $minStockVal);
      $stmt->bindParam(':myFile', $myFile);
      // Execute the prepared statement to insert the user data into the table
      $stmt->execute();

      echo "New user added successfully.";}
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

  function deleteItem($itemId, $workshopId) {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
  
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      // Prepare and execute the SQL query to delete the item
      $sql = "DELETE FROM inventory WHERE item_id = :itemId AND workshop_id = :workshopId";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':itemId', $itemId);
      $stmt->bindParam(':workshopId', $workshopId);
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

function UpdateItem() {
  
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'wms';
 
  try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      // Check if item_id and workshop_id are set in POST
      if(isset($_POST['item_id']) && isset($_POST['workshop_id'])) {
        $item_name = $_POST['itemname'];
        $item_id = $_POST['item_id'];
        $workshop_id= $_POST['workshop_id'];
        $desc= $_POST['itemdescription'];
        $price = $_POST['price'];
        $min_stock = $_POST['min_stock'];
        $quantity = $_POST['quantity'];
        $img = "sswswsw";
          
        // Update query to include input field values
        $stmt = $conn->prepare("UPDATE inventory SET name = :item_name, `desc` = :desc, price = :price, min_stock = :min_stock, quantity = :quantity, img_name = :img WHERE item_id = :item_id AND workshop_id = :workshop_id");
          
        // Bind parameters
        $stmt->bindParam(':item_name', $item_name);
        $stmt->bindParam(':desc', $desc);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':min_stock', $min_stock);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':img', $img);
        $stmt->bindParam(':item_id', $item_id);
        $stmt->bindParam(':workshop_id', $workshop_id);
          
        // Execute query
        $stmt->execute();
        echo "Item updated successfully.";
      } else {
          echo "Error: item_id and workshop_id are not set in POST.";
      }
  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}
    ?>