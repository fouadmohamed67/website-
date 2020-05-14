<?php
    session_start();
    $page_title ='dashbord admin';
    include 'init.php';
    
    if(isset($_SESSION['name'])&& $_SESSION['role']==1)
    
    {
            $no_all_stu=count_of_Users('users',0,$conn);
            $no_all_admins=count_of_Users('users',1,$conn);
            $no_all_books=count_of_things('books',$conn);
            $late=latebooks($conn);
            
         
        ?>
        
        <div class="row justify-content-center row-counter">
               <div class="col-md-2  admins text-center counter">
                  
                   <h3>admins</h3>
                   <span><?php echo $no_all_admins; ?></span>
                 </div>
   
               <div class="col-md-2   students text-center counter">
                
                   <h3>students</h3>
                   <span><?php echo $no_all_stu; ?></span>
                 </div>
                
               <div class="col-md-2   books_c text-center counter">
                 
                   <h3>all books</h3>
                   <span><?php echo  $no_all_books?></span>
                 </div> 
               <div class="col-md-2   late text-center counter">
                   <h3>late</h3>
                   <span> <?php echo $late; ?></span>
               </div>
                
            </div>


            

    <?php
     $user_id=$_SESSION['id']; 
     $statement=$conn->prepare("SELECT * FROM books WHERE borrower_id=$user_id");
     $statement->execute();
     $all_books=$statement->fetchAll();
     $count=$statement->rowCount();
      

     foreach ($all_books as $book)
     {
         $now = strtotime(date("Y-m-d"));
                     $status_date = strtotime($book['date_back']);
                     $x = date($status_date-$now);
                     $x= $x/(60 * 60 * 24);
         if($x<=0)
         {?>
             <div class="container mt-3">
                 <div class="h1 text-center">late books</div>
                 <div class="alert alert-danger">
                     <?php echo "book name : ". $book['name'];?>
                 </div>
             </div>

             <?php
         }
         else
         {
             ?>
               <div class="container mt-3">
                 
                 <div class="alert alert-success">
                     you do not have late borrowing 
                 </div>
             </div>
             <?php
         }
     }
     if( $count ==0)
     {
         ?>
               <div class="container mt-3">
                 
                 <div class="alert alert-success">
                     you do not have late borrowing 
                 </div>
             </div>
             <?php
     }
     
    }
    else if($_SESSION['role']==0)
    {
        header ('location: ../student/dashbord.php');
        exit();
    }
    else
    {
        header ('location: login.php');
        exit();
    }

