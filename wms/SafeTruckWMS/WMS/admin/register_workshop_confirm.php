<?php
  include '../queries/workshop_queries.php';

  if(isset($_POST['workshop_name'])) {
    $name = $_POST['workshop_name'];
    $location = $_POST['workshop_location'];
    $opening_hours = $_POST['opening_hrs'];
    $closing_hours = $_POST['closing_hrs'];
    $specialisations = $_POST['workshop_special'];
    $phone_no = $_POST['phone_no'];
    $workshop_owner_id = $_POST['workshop-owner'];
    $workshop_lng = 0.04;
    $workshop_ltd = 0.043;

    echo $name.'</br>';
    echo $location.'</br>';
    echo date('h:i A', strtotime($opening_hours)).' to '.date('h:i A', strtotime($closing_hours)).'</br>';
    echo $specialisations.'</br>';
    echo $phone_no.'</br>';
    echo $workshop_owner_id.'</br>';
    echo $workshop_lng.'</br>';
    echo $workshop_ltd.'</br>';
  }

  //if(AddWorkshop()){
  //  header('Location:register_workshop.php?success=true');
  //}

?>
