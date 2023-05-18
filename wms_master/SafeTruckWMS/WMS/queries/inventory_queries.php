<?php
function GetItemPurchases($workshop_id, $item_id) {
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
      $sql = "SELECT * FROM purchase_details WHERE workshop_id = :workshop_id AND item_id = :item_id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->bindParam(':item_id', $item_id);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
  } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}

function AddPurchaseDetails($workshop_id, $item_id, $supplier, $brandName, $price, $dPurchased, $quantity){
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

    // Begin transaction
      $conn->beginTransaction();
        // Prepare the SQL statement for inserting purchase details
      $stmt = $conn->prepare("INSERT INTO purchase_details (workshop_id, brand, item_id, quantity, price, date_purchased, supplier)
          VALUES (:workshop_id, :brandName, :item_id, :quantity, :price, :dPurchased, :supplier)");
        // Bind the purchase details to the prepared statement parameters
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->bindParam(':brandName', $brandName);
      $stmt->bindParam(':item_id', $item_id);
      $stmt->bindParam(':quantity', $quantity);
      $stmt->bindParam(':price', $price);
      $stmt->bindParam(':dPurchased', $dPurchased);
      $stmt->bindParam(':supplier', $supplier);
        // Execute the prepared statement to insert the purchase details
      $stmt->execute();

          // Prepare the SQL statement for updating inventory
      $stmt = $conn->prepare("UPDATE inventory
          SET quantity = quantity + :quantity
          WHERE item_id = :item_id
          AND workshop_id = :workshop_id");

          // Bind the inventory data to the prepared statement parameters
      $stmt->bindParam(':quantity', $quantity);
      $stmt->bindParam(':item_id', $item_id);
      $stmt->bindParam(':workshop_id', $workshop_id);
          // Execute the prepared statement to update the inventory
      $stmt->execute();

          // Commit the transaction
      $conn->commit();

      return "Record saved";
  } catch(PDOException $e) {
      // Roll back the transaction if there's an error
      $conn->rollback();
      echo "Error: " . $e->getMessage();
  }
}

function AddStockPerItem($workshop,$item,$quantity) {
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

function AddItem($workshop_id, $itemName, $description, $price, $quantity, $minStockVal, $image, $itemType){
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

      // Prepare the SQL statement for inserting user data into the table
      $stmt = $conn->prepare("INSERT INTO inventory (workshop_id, name,  description, price, quantity,min_stock, img_name, item_type)
                              VALUES (:workshop_id,:itemName, :description, :price, :quantity , :minStockVal, :image, :itemType )");

      // Bind the user data values to the prepared statement parameters
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->bindParam(':itemName', $itemName);
      $stmt->bindParam(':description', $description);
      $stmt->bindParam(':price', $price);
      $stmt->bindParam(':quantity', $quantity);
      $stmt->bindParam(':minStockVal', $minStockVal);
      $stmt->bindParam(':image', $image);
      $stmt->bindParam(':itemType', $itemType);
      // Execute the prepared statement to insert the user data into the table
      $stmt->execute();
    }
     catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }

  function GetAllWorkshopItems($workshop_id, $page_no){
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

            $stmt = $conn->prepare("SELECT * FROM inventory WHERE workshop_id = :workshop_id LIMIT :start, :fin");
            $start = ($page_no-1)*$lim;
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':fin', $lim, PDO::PARAM_INT);
            $stmt->bindParam(':workshop_id', $workshop_id, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
  }

  function GetAllWorkshopItemsSearch($workshop_id, $search, $field){
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'wms';
    $search = $search . "%";
    if ( mysqli_connect_errno() ) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if($field == "name"){
          $stmt = $conn->prepare("SELECT * FROM inventory WHERE workshop_id = :workshop_id AND name LIKE :search");
        }else{
          $stmt = $conn->prepare("SELECT * FROM inventory WHERE workshop_id = :workshop_id AND item_type LIKE :search");
        }
        $stmt->bindParam(':search', $search, PDO::PARAM_STR);
        $stmt->bindParam(':workshop_id', $workshop_id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

    return $results;
    }

  function DeleteItem($itemId, $workshopId) {
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
  function GetItem($workshop_id, $item_id) {
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

function UpdateItem($workshop_id, $item_id, $item_name, $description, $price, $min_stock, $image, $item_type) {

  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'wms';

  try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbnamex", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Check if item_id and workshop_id are set in POST
        // Update query to include input field values
        $stmt = $conn->prepare("UPDATE inventory SET name = :item_name, description = :description, price = :price, min_stock = :min_stock, img_name = :image, item_type = :item_type WHERE item_id = :item_id AND workshop_id = :workshop_id");

        // Bind parameters
        $stmt->bindParam(':item_name', $item_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':min_stock', $min_stock);
        $stmt->bindParam(':item_type', $item_type);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':item_id', $item_id);
        $stmt->bindParam(':workshop_id', $workshop_id);

        // Execute query
        $stmt->execute();

  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}
    ?>
