<?php
session_start();
session_unset();
session_destroy();
$no_nav="";
$page_title="Register";
include "init.php";


    //check if info is right
  if($_SERVER['REQUEST_METHOD']=="POST")
    {
           
         
        $name=$_REQUEST['name'];
        $email=$_REQUEST['email'];
        $pass=$_REQUEST['password'];
        $role=0;
        $hashed_pass=sha1($pass);

        $errors_of_register=array();
        if(email_in_use($email,$conn))
        {
            $errors_of_register[0]="the email in use";
        }
         

        if(empty($errors_of_register))
        {
            $statement=$conn->prepare("INSERT INTO users ( name, email, password,role,registered_at) VALUES ( :_name,:_email,:_hashpass,:_role,now() )");
            $statement->execute(array(

                '_name'=>$name,
                '_email'=>$email,
                '_role'=>$role,
                '_hashpass'=>$hashed_pass
                

            ));
            $statement=$conn->prepare("SELECT id FROM users WHERE email= ?   ");
            $statement->execute(array($email));
            $row=$statement->fetch();
            session_start();
            $_SESSION['email']=$email;
            $_SESSION['name']=$name;
            $_SESSION['role']=$role;
            $_SESSION['id']=$row['id'];

            header('location: dashbord.php');
            exit();
        }

    }
    else
    {
        header ('location register.php');
    }
    

  ?>
  
   
  <div class="container">
                <div class="card register d-flex justify-content-center" >
                        <div class="card-header">
                            <div class="h1 d-flex justify-content-center">register</div>
                        </div>
                        <div class="card-body">
                            <form action="" name="form" method="POST" onsubmit = "return(validate_re());">
                              
                                        <div class="form-group">
                                            <label for="name">your name : </label>
                                            <input type="text" class="form-control"   name="name"  >
                                        </div>
                                        <div  class="alert alert-danger" id="error_name"></div>
                                         
                                         
                                        <div class="form-group">
                                            <label for="email">email : </label>
                                            <input type="email" class="form-control"   name="email"  >
                                        </div>
                                        <div  class="alert alert-danger" id="error_email">
                                        <?php
                                        if(isset($errors_of_register[0]))
                                        {
                                             
                                               echo $errors_of_register[0];
                                        }  
                                       ?>
                                        </div>
                                          
                                        <div class="form-group">
                                            <label for="password">password : </label>
                                            <input type="password" class="form-control"   name="password" >
                                        </div>
                                        <div  class="alert alert-danger" id="error_password"></div>
                                        
                                        <div class="form-group">
                                            <label for="password">password confirm : </label>
                                            <input type="password" class="form-control"   name="confirm" >
                                        </div>
                                        <div  class="alert alert-danger" id="error_confirm"></div>


                                        <div class="form-group">
                                            <input name="role" class="form-control" type="hidden" value="0">
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="register" name="submit" id="">   
                                        </div>
                            </form>
                            <a href="login.php">you have account ?</a>
                        </div>
                </div>
         </div>


<?php
include $footer;
?>