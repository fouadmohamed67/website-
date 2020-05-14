<?php

  $dns='mysql:host=localhost;dbname=web_1';
  $user='root';
  $password='';

  try{
      $conn=new PDO($dns,$user,$password);
      $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      
    }
  catch(PDOException $e)
  {
      echo "faild";
  }