<?php
//to print title page
function getTitle()
{
    global $page_title;
    if(isset($page_title))
    {
      echo($page_title);
    }
    else
    {
     echo("default");
    
    }
}

//to check if email in use
 function email_in_use($email,$conn)
 {
  $state=$conn->prepare("SELECT email FROM users WHERE email ");
  $state->execute(array($email));
  $row=$state->fetch();
  $count_of_the_same_email=$state->rowCount();
  if($count_of_the_same_email>0)
  {
     return true;
  }
  else
  {
    return false;
  }
 }


