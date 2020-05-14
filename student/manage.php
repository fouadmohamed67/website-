<?php 
session_start();
$page_title='manage Users';
include 'init.php';
 if(isset($_SESSION['name'])  && $_SESSION['role']==0 )
{
    $do=isset($_GET['do'])?$_GET['do']:'manage';
    if($do=="manage")
    {
        echo "in manage";
    }
    else if($do=="editInDataBase")
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $id=$_REQUEST['id'];
            $name=$_REQUEST['name'];
            $email=$_REQUEST['email'];
            if(empty($_REQUEST['password']))
            {
                $hashed_pass=$_REQUEST['oldpass'];
            }
            else
            {
                $pass=$_REQUEST['password'];
                $hashed_pass=sha1($pass);
            }
             
                $_SESSION['name']=$name;
                $_SESSION['email']=$email;
                $statement=$conn->prepare("UPDATE users SET name=?,email=?,password=? WHERE id=?");
                $statement->execute(array($name,$email,$hashed_pass,$id));
                 if($statement->rowCount()>0)
                 {
                     
                     header('location: dashbord.php?');
                     exit();
                     
                 }
              
        }
        else
        {
            header('location: dashbord.php');
            exit();
        }
    }
    else if($do=="edit")
    {
        $statement=$conn->prepare("SELECT  *  FROM users WHERE name=?");
        $statement->execute(array($_SESSION['name']));
        $row=$statement->fetch();
        $user_id=$_SESSION['id'];
         ?>

           <div class="container">
                <div class="card card_tp d-flex justify-content-center" >
                        <div class="card-header manage">
                            <div class="h1 d-flex justify-content-center">edit your profile</div>
                        </div>
                        <div class="card-body">
                            <form action="?do=editInDataBase" name="form" method="POST" onsubmit = "return(validate_edit());">
                             <input type="hidden" name="id" value=<?php echo $row['id'] ?>>
                             <input type="hidden" name="oldpass" value=<?php echo $row['password'] ?>>
                             
                                        <div class="form-group">
                                            <label for="name">your name : </label>
                                            <input type="text" class="form-control" value="<?php echo $row['name']?>" name="name"  >
                                        </div>
                                        <div class="alert alert-danger " id="error_name_edit">
                                           
                                        </div>
                                        <div class="form-group">
                                            <label for="email">email : </label>
                                            <input type="email" class="form-control" value="<?php echo $row['email']?>" name="email"  >
                                        </div>
                                        <div class="alert alert-danger " id="error_email_edit"></div>
                                        <div class="form-group">
                                            <label for="password">password : </label>
                                            <input type="password" class="form-control"   name="password" >
                                        </div>
                                         

                                        <div class="form-group">
                                            <input type="submit" class="btn btn-send " name="submit" id="">   
                                        </div>
                            </form>
                        </div>
                </div>
         </div>


        <?php
    }

}
 else if($_SESSION['role']==1)
{
    header('location: ../admin/dashbord.php');
    exit();
}
else
{
    header('location: login.php');
    exit();
}
 