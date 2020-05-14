<?php
    session_start();
    $page_title ='dashbord student';
    include 'init.php';
    
    if(isset($_SESSION['name']))
    {
        
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
     
    else
    {
        header ('location: ../admin/login.php');
        exit();
    }

