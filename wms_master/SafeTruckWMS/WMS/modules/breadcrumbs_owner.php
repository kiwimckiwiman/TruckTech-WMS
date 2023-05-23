<?php
$url = $_SERVER['REQUEST_URI'];
$url_parts = explode('/', $url);
$parts = array_slice($url_parts, -2);

$curr = basename(parse_url($parts[1], PHP_URL_PATH));
$curr = str_replace('_', ' ', $curr);
$curr = ucwords(str_replace('.php', '', $curr));

  if($parts[0] == "home"){
    if($parts[1] == "dashboard.php"){
      echo '<div class="breadcrumbs">
              <a href = " ../home/dashboard.php" class="crumb">All Workshops</a>
            </div>';

    }else{
      echo '<div class="breadcrumbs">
              <a href = " ../home/dashboard.php" class="crumb">All Workshops</a>
              <a href = " ../home/'.$parts[1].'" class="crumb">'.$workshop["name"].'</a>
            </div>';
    }
  }else if($parts[0] == "profile"){
    if (($parts[1] == "profile.php") || ($parts[1] == "profile_save.php")){
      echo '<div class="breadcrumbs">
              <a href = " ../home/dashboard.php" class="crumb">All Workshops</a>
              <a href = "profile.php" class="crumb">Profile</a>
            </div>';
    }else{
      echo '<div class="breadcrumbs">
              <a href = " ../home/dashboard.php" class="crumb">All Workshops</a>
              <a href = "profile.php" class="crumb">Profile</a>
              <a href = "'.$parts[1].'" class="crumb">'.$curr.'</a>
            </div>';
    }
  }else{
    if(strpos($parts[1], "pages")){
      $curr = implode(' ', array_slice(explode(' ', $curr), 1));
      echo '<div class="breadcrumbs">
              <a href = " ../home/dashboard.php" class="crumb">All Workshops</a>
              <a href = " ../home/workshop_dashboard.php?workshop='.$workshop["workshop_id"].'" class="crumb">'.trim($workshop["name"]).'</a>
              <a href = " ../'.$parts[0].'/view_'.$parts[0].'.php?pages=1" class="crumb">All '.$curr.'</a>
            </div>';
    }else{
      if(isset($id)){
        echo '<div class="breadcrumbs">
                <a href = " ../home/dashboard.php" class="crumb">All Workshops</a>
                <a href = " ../home/workshop_dashboard.php?workshop='.$workshop["workshop_id"].'" class="crumb">'.trim($workshop["name"]).'</a>
                <a href = " ../'.$parts[0].'/view_'.$parts[0].'.php?pages=1" class="crumb">All '.ucwords($parts[0]).'</a>
                <a href = "../'.$parts[0].'/view_'.substr($parts[0], 0, -1).'.php?id='.$id.'" class="crumb">'.$page.'</a>
                <a href = "" class="crumb">'.$curr.'</a>
              </div>';
      }else{
        if($parts[0] == "details"){
          echo '<div class="breadcrumbs">
                  <a href = " ../home/dashboard.php" class="crumb">All Workshops</a>
                  <a href = " ../home/workshop_dashboard.php?workshop='.$workshop["workshop_id"].'" class="crumb">'.trim($workshop["name"]).'</a>
                  <a href = "" class="crumb">'.$curr.'</a>
                </div>';
        }else{
          echo '<div class="breadcrumbs">
                  <a href = " ../home/dashboard.php" class="crumb">All Workshops</a>
                  <a href = " ../home/workshop_dashboard.php?workshop='.$workshop["workshop_id"].'" class="crumb">'.trim($workshop["name"]).'</a>
                  <a href = " ../'.$parts[0].'/view_'.$parts[0].'.php?pages=1" class="crumb">All '.ucwords($parts[0]).'</a>
                  <a href = "" class="crumb">'.$curr.'</a>
                </div>';
        }
      }
    }
  }





?>
