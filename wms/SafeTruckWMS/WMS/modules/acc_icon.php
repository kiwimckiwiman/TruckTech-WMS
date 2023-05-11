<?php
  function icon($name){
    $letter = substr($name, 0, 1);

    return '<div style="
            background: rgb(31,59,179);
            border-radius:60px;
            height:50px;
            width:50px;
            text-align:center;
            ">
            <h3 style="
              color: white;
              padding:12px;
              " class="font-weight-semibold">'.ucfirst($letter).'</h3>
          </div>';
  }
?>
