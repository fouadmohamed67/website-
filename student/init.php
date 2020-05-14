<?php

    //function and vonnect file
  include 'function.php';
  include 'connect.php';

    //temp
  $header='include/temp/header.php';
  $footer='include/temp/footer.php';
  $navbar='include/temp/navbar.php';

    //css
    $css='layout/css/';
    $js='layout/js/';

    include $header;
    if(!isset($no_nav))
    {
      include $navbar;
    
    }
    