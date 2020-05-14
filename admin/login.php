<?php
   session_start();
   $page_title ='login page';
   $no_nav ="";
   include 'init.php';

   if(isset($_SESSION['name']))
   {
       header('location: dashbord.php');
       exit();
   }
   else
   { 
      if($_SERVER['REQUEST_METHOD']=='POST')
      {
          $email=$_POST['email'];
          $password=$_POST['password'];
          $hashedPass=sha1($password);
         
          $statement=$conn->prepare("SELECT email,name,id,password,role  FROM users WHERE email= ? AND password=? ");
          $statement->execute(array($email,$hashedPass));
          $row=$statement->fetch();
          $count=$statement->rowCount();
           
              if($count>0)
              {
                  $_SESSION['email']=$email;
                  $_SESSION['name']=$row['name'];
                  $_SESSION['id']=$row['id'];
                  $_SESSION['role']=$row['role'];
                  if($row['role']==1)
                  {
                      header('location: dashbord.php');
                      exit();
                  }
                  else
                  {
                      header('location: ../student/dashbord.php');
                      exit();
                  }
                  
                  
              }
      }
                
            
      

    ?>

<div class="container">
     
     <div class="card card_login d-flex justify-content-center" >
         <div class="card-header-login">
              <div class="h1 d-flex justify-content-center">login now</div>
         </div>
         <div class="card-body">
 
             <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" name="form" class="form" onsubmit = "return(validation_login());">
                 <div class="form-group">
                     <label for="email">email : </label>
                     <input type="email" class="form-control" name="email" >
                 </div>
                 <div  class="alert alert-danger" id="error_email"></div>
                  
 
 
                 <div class="form-group">
                     <label for="password">password : </label>
                     <input type="password" class="form-control" name="password" >
                 </div>
                 <div  class="alert alert-danger" id="error_password"></div>
                  
 
 
                 <div class="form-group">
                     <input type="submit" class="btn btn-send" name="submit" id="">   
                 </div>
             </form>
             <a href="register.php">register ? </a>
 
         </div>
     </div>
 </div>
  
  </div>
 <?php
 
 include $footer;
 ?>

<?php
   }
   ?>