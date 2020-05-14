<?php
    session_start();
    $page_title ='show books ';
    include 'init.php';
    
    if(isset($_SESSION['name']))
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            
            $id=$_REQUEST['id'];
            $statement=$conn->prepare("SELECT * from books WHERE id=$id ");
            $statement->execute();
            $book= $statement->fetch();
               
             
            ?>
          
                <div class="container mt-5">
                <div class="card">
                    <h1 class="d-flex justify-content-center"><?php echo $book['name']; ?></h1>
                    <p class="paragraph"><?php echo $book['details']; ?></p>
                    <span class="year"><?php echo $book['publication_year']; ?></span>
                    <span class="auther"><?php echo $book['auther']; ?></span>
                    <?php

                            if($book['borrower_id']==0)
                             {?>
                                <form method="POST" action="borrow.php?id=<?php echo $book['id'] ?>">
                                <button class="btn btn-primary btn_show btn-sm">borrow the book ?</button>
                               </form>
                            <?php }
                             else
                             {
                                 ?>
                                 <div class="borr">the book is borrowed</div>
 
                            <?php 
                            }
                            ?>
                    
                </div>
                </div>


            <?php

        }
        else
        {
            header('location: viewBooks.php');
            exit();
        }
    }
    else
    {
        header ('location: ../admin/login.php');
        exit();
    }