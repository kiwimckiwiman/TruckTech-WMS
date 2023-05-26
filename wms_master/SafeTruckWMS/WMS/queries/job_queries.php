<?php
function AddStep($job_id, $stepDescr, $comment, $item_id, $quantity, $totalPrice, $finish){
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

      // Prepare the SQL statement for inserting user data into the table
      $stmt = $conn->prepare("INSERT INTO steps (job_id, time_created, description, comment, item_id, quantity, total_item_price,finish)
      VALUES (:job_id, NOW(), :stepDescr, :comment, :item_id, :quantity, :totalprice, :finish)");
      $stmt->bindParam(':job_id', $job_id);
      $stmt->bindParam(':stepDescr', $stepDescr);
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


function GetAllSteps($job_id) {
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
      $sql = "SELECT * FROM steps WHERE job_id = :job_id ORDER BY time_created ASC";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':job_id', $job_id);
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

function DeleteJob($job_id) {
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'wms';

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn -> beginTransaction();
    $stmt = $conn->prepare("UPDATE inventory
                            JOIN steps ON inventory.item_id = steps.item_id
                            SET inventory.quantity = inventory.quantity + steps.quantity
                            WHERE steps.job_id = :job_id
                              AND steps.item_id IS NOT NULL;");
    $stmt->bindParam(':job_id', $job_id);
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM steps WHERE job_id = :job_id;");
    $stmt->bindParam(':job_id', $job_id);
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM jobs WHERE job_id = :job_id;");
    $stmt->bindParam(':job_id', $job_id);
    $stmt->execute();
    $conn -> commit();
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function DeleteStep($step_id){
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'wms';

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn -> beginTransaction();
    $stmt = $conn->prepare("UPDATE inventory
                            JOIN steps ON inventory.item_id = steps.item_id
                            SET inventory.quantity = inventory.quantity + steps.quantity
                            WHERE steps.step_id = :step_id;");
    $stmt->bindParam(':step_id', $step_id);
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM steps WHERE step_id = :step_id;");
    $stmt->bindParam(':step_id', $step_id);
    $stmt->execute();
    $conn -> commit();
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function ViewWorkshopJob($workshop_id, $job_id){
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

        $stmt = $conn->prepare("SELECT b.name, a.* FROM jobs a JOIN users b ON a.customer_id = b.user_id WHERE a.job_id = :job_id AND a.workshop_id = :workshop_id");
        $stmt->bindParam(':job_id', $job_id);
        $stmt->bindParam(':workshop_id', $workshop_id);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results[0];
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function FinishWorkshopJob($job_id, $service_fee, $comment){
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

    $conn->beginTransaction();

    $stmt = $conn->prepare("UPDATE Jobs SET service_fee = :service_fee, comment = :comment, finish_time = CURRENT_TIMESTAMP() WHERE job_id = :job_id");
    $stmt->bindParam(':job_id', $job_id);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':service_fee', $service_fee);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT SUM(total_item_price) FROM steps WHERE job_id = :job_id");
    $stmt->bindParam(':job_id', $job_id);
    $stmt->execute();
    $total_item_price = $stmt->fetch();

    $total_price = $total_item_price[0] + $service_fee;

    $stmt = $conn->prepare("UPDATE Jobs SET total_price = :total_price WHERE job_id = :job_id");
    $stmt->bindParam(':total_price', $total_price);
    $stmt->bindParam(':job_id', $job_id);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT * FROM Jobs WHERE job_id = :job_id");
    $stmt->bindParam(':job_id', $job_id);
    $stmt->execute();
    $job_details = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT * FROM workshops WHERE workshop_id = :workshop_id");
    $stmt->bindParam(':workshop_id', $job_details['workshop_id']);
    $stmt->execute();
    $workshop_details = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :customer_id");
    $stmt->bindParam(':customer_id', $job_details['customer_id']);
    $stmt->execute();
    $customer_details = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT inventory.name, steps.quantity, steps.total_item_price, steps.description
    FROM steps
    LEFT JOIN inventory
    ON steps.item_id=inventory.item_id WHERE steps.job_id = :job_id");
    $stmt->bindParam(':job_id', $job_id);
    $stmt->execute();
    $steps_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $invoice_id_string = uniqid().strval($job_id);
    $file_type = ".html";
    $invoicehtml = $invoice_id_string . $file_type;

    $invoice = fopen("../../../invoice/" . $invoicehtml, "w") or die("Unable to open file!");
    $txt =
    "<!DOCTYPE html>
    <html>
    <head>
      <title>Invoice</title>
      <link rel='stylesheet' type='text/css' href='invoiceStyles.css'>
      <link rel='shortcut icon' href='../../images/favicon.png' />
      <style>
        :root {
        --bg-clr: #dfdfdf;
        --white: #fff;
        --invoice-bg: #69cce9;
        --primary-clr: #2f2929;
        --secondary-clr: #20315b;
      }
      </style>
    </head>

    <body>

    <section>
      <div class='invoice'>
        <div class='invoice_info'>
          <div class='i_row'>
            <div class='i_logo'>
              <img src='Safe-Truck-logo_2017.png' height='100' width='100'>
            </div>
            <div class='title'>
              <h1>INVOICE</h1>
            </div>
          </div>
          <div class='i_row'>

            <div class='i_from'>
              <div class='main_title'>
                <p>From</p>
              </div>
              <div class='p_title'>
                <p>" . $workshop_details['name'] . "</p>
                <p>" . $workshop_details['location'] . "</p>
              </div>
              </div>
              <div class='i_to text_right'>
                <div class='main_title'>
                  <p>To</p>
                </div>
                <div class='p_title'>
                  <p>" . $customer_details['username'] . "</p>
                  <p>" . $customer_details['phone_no'] . "</p>
                  <p>" . $customer_details['email'] . "</p>
                </div>
              </div>
            </div>
            <div class='i_row'>
              <div class='i_servicedetails'>
                <div class='main_title'>
                  <p>Service Details</p>
                </div>
                <div class='p_title'>
                  <p>Vehicle Plate:</p>
                  <span>" . $job_details['vehicle_plate'] . "</span>
                </div>
                <div class='p_title'>
                  <p>Vehicle Make:</p>
                  <span>" . $job_details['vehicle_make'] . "</span>
                </div>

                <div class='p_title'>
                  <p>Started On:</p>
                  <span>" . date('D | d-M | h:i A', strtotime($job_details['start_time'])) . "</span>
                </div>
                <div class='p_title'>
                  <p>Finish On:</p>
                  <span>" . date('D | d-M | h:i A', strtotime($job_details['finish_time'])) . "</span>
                </div>
              </div>
              <div class='i_details text_right'>
                <div class='main_title'>
                  <p>Invoice Details</p>
                </div>
                <div class='p_title'>
                  <p>Job ID:</p>
                  <span>" . $job_id . "</span>
                </div>
                <div class='p_title'>
                  <p>Date of Issue:</p>
                  <span>" . date("Y-m-d",time()) . "</span>
                </div>
              </div>
            </div>
          </div>
          <div class='invoice_table'>
            <div class='i_table'>
              <div class='i_table_head'>
                <div class='i_row'>
                  <div class='i_col w_55'>
                    <p class='p_title'>Service Charge</p>
                  </div>
                  <div class='i_col w_55'>
                    <p class='p_title'>Item(s) Charge</p>
                  </div>
                  <div class='i_col w_15 text_center'>
                    <p class='p_title'>Qty</p>
                  </div>
                  <div class='i_col w_15 text_center'>
                    <p class='p_title'>PRICE (RM)</p>
                  </div>
                  <div class='i_col w_15 text_right'>
                    <p class='p_title'>AMOUNT (RM)</p>
                  </div>
                </div>
              </div>";

foreach ($steps_details as $step_details) {
  if($step_details['quantity'] == 0){
    $txt .=
                "<div class='i_table_body'>
                  <div class='i_row'>
                    <div class='i_col w_55'>
                      <p>" . $step_details['description'] . "</p>
                    </div>
                    <div class='i_col w_55'>
                      <p> n/a </p>
                    </div>
                    <div class='i_col w_15 text_center'>
                      <p> n/a </p>
                    </div>
                    <div class='i_col w_15 text_center'>
                      <p> n/a </p>
                    </div>
                    <div class='i_col w_15 text_right'>
                      <p> n/ a</p>
                    </div>
                  </div>";
  }else{
    $txt .=
                "<div class='i_table_body'>
                  <div class='i_row'>
                    <div class='i_col w_55'>
                      <p>" . $step_details['description'] . "</p>
                    </div>
                    <div class='i_col w_55'>
                      <p>" . $step_details['name'] . "</p>
                    </div>
                    <div class='i_col w_15 text_center'>
                      <p>" . $step_details['quantity'] . "</p>
                    </div>
                    <div class='i_col w_15 text_center'>
                      <p>" . $step_details['total_item_price']/$step_details['quantity'] . "</p>
                    </div>
                    <div class='i_col w_15 text_right'>
                      <p>" . $step_details['total_item_price'] . "</p>
                    </div>
                  </div>";
  }
  }

  $txt .=
              "<div class='i_row'>
                <div class='i_col w_55'>
                  <p>Service Fee</p>
                </div>
                <div class='i_col w_15 text_center'>
                  <p></p>
                </div>
                <div class='i_col w_15 text_center'>
                  <p></p>
                </div>
                <div class='i_col w_15 text_right'>
                  <p>" . $job_details['service_fee'] . "</p>
                </div>
              </div>
            </div>
            <div class='i_table_foot'>
              <div class='i_row'>
              </div>
              <div class='i_row grand_total_wrap'>
                <div class='i_col w_50'>
                  <p>GRAND TOTAL (RM):</p>
                </div>
                <div class='i_col w_50 text_right'>
                  <p>" . $job_details['total_price'] . "</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class='invoice_notes'>
          <div class='main_title'>
            </br>
            <p>Notes</p>
          </div>
          <p>" . $job_details['comment'] . "</p>
        </div>
      </div>
    </section>

    </body>
    </html>";

    fwrite($invoice, $txt);
    fclose($invoice);

    $stmt = $conn->prepare("UPDATE Jobs SET invoice_link = :invoice_link WHERE job_id = :job_id");
    $stmt->bindParam(':job_id', $job_id);
    $invoicelink = '../../../invoice/' . $invoicehtml;
    $stmt->bindParam(':invoice_link', $invoicelink);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM Steps WHERE job_id = :job_id");
    $stmt->bindParam(':job_id', $job_id);
    $stmt->execute();

    $conn->commit();

  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function ViewAllOngoingJobs($workshop_id)
{
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

      $stmt = $conn->prepare("SELECT * FROM jobs WHERE finish_time IS NULL AND workshop_id = :workshop_id");
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
  } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}

function ViewAllFinishedJobs($workshop_id, $page_no){
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

      $stmt = $conn->prepare("SELECT * FROM jobs WHERE finish_time IS NOT NULL AND workshop_id = :workshop_id LIMIT :start, :fin");
      $start = ($page_no-1)*$lim;
      $stmt->bindParam(':start', $start, PDO::PARAM_INT);
      $stmt->bindParam(':fin', $lim, PDO::PARAM_INT);
      $stmt->bindParam(':workshop_id', $workshop_id);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
  } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}


?>
