<?php
session_start();

include '../../../queries/inventory_queries.php';

if(isset($_FILES["image"])) {
  $allowedTypes = array("image/jpeg", "image/png", "image/gif");
  $allowedExtensions = array("jpeg", "jpg", "png", "gif");
  $fileType = $_FILES["image"]["type"];
  $fileSize = $_FILES["image"]["size"];
  $fileName = basename($_FILES["image"]["name"]);
  $fileTmp = $_FILES["image"]["tmp_name"];
  $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));


  $image = uniqid() . "." . $fileExt;
          // Set the destination folder for the uploaded file
  $uploadPath = "../../../../images/inventory/" . $image;
  move_uploaded_file($fileTmp, $uploadPath);


  $itemName = $_POST['itemName'];
  $description = $_POST['desc'];
  $price = $_POST['price'];
  $minStockVal = $_POST['minStockVal'];
  $quantity = 0;
  $itemType = $_POST['itemType'];

  AddItem($_SESSION["workshop_id"], $itemName, $description, $price, $quantity, $minStockVal, $image, $itemType);
  header("Location:view_items.php?pages=1");
}else{
  header("Location:view_items.php?pages=1");
}
?>
