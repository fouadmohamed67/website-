<?php
    session_start();
    $page_title ='show books ';
    include 'init.php';
    
    if(isset($_SESSION['name']))
    {
        $user_id=$_SESSION['id']; 
        $statement=$conn->prepare("SELECT * FROM books WHERE borrower_id=$user_id");
        $statement->execute();
        $all_books=$statement->fetchAll();
        $count=$statement->rowCount();
         

         if($count>0)
         {
            ?>

 
        <div class="container my_books">
          <div class="table-responsive">
           <table class="table ">
            <thead>
                <tr>
                    <th>name</th>
                    <th>auther</th>
                    <th>publication year</th> 
                    <th>back in </th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                
                    <?php foreach($all_books as $book)
                    {?>
                    <tr>
                        <td><?php echo $book['name'] ?></td>
                        <td><?php echo $book['auther'] ?></td>
                        <td><?php echo $book['publication_year'] ?></td>
                        <?php
                         

                        $now = strtotime(date("Y-m-d"));
                        $status_date = strtotime($book['date_back']);
                        $x = date($status_date-$now);
                        $x= $x/(60 * 60 * 24);
                        
                         

                        ?>
                        <td><?php echo $x." days" ?></td>
                        <td><form method="POST" action="backbook.php?id=<?php echo $book['id']; ?>"><button class="btn btn-danger">back it</button></form></td>
                    </tr> 
                    <?php }?>
                    
                
            </tbody>
           </table>
          </div>
        </div>



        <?php
         }
         else
         {
            ?>
                <div class="container mt-4">
                    <div class="alert alert-danger">
                     you do not  have  books
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

