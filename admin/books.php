<?php 
session_start();
$page_title='books page';
include 'init.php';
if(isset($_SESSION['name']) && $_SESSION['role']==1)
{
    $do=isset($_GET['do'])?$_GET['do']:'manage';
    if($do=='manage')
    {

        $statement=$conn->prepare("SELECT * from books ");
        $statement->execute();
        $all_books=$statement->fetchAll();

    ?>
         <div class="container">
          
            <a href="?do=addBook" class="btn btn-primary mb-3 mt-3">add new book</a>
            <div class="card d-flex justify-content-center" >
                            <div class="card-header">
                                <div class="h1 d-flex justify-content-center">All Books</div>
                            </div>
                            <div class="card-body">
                            <?php
                            foreach($all_books as $book)
                            {
                               ?>
                                
                              <div class="book" id="item<?php echo $book['id']; ?>">
                               
                                <h3><?php echo $book['name'] ?></h3>
                                <p class="details"><?php echo $book['details'] ?></p>
                                <span class="year"> <?php echo $book['publication_year']?></span>
                                <span class="auther"> <?php echo $book['auther']?></span>
                                
                                <p class="borrow"><?php if($book['borrower_id'] !=0){echo "The book is borrowed";}else{echo "The book is allowed";} ?></p>
                                
                                 <form method="POST" action="?do=edit&id=<?php echo $book['id'] ?>">
                                  <button class="btn btn-primary btn-sm">edit</button>
                                 </form>
                                 <form method="POST" action="?do=delete&id=<?php echo $book['id'] ?>">
                                  <button class="btn btn-danger btn-sm">delete</button>
                                 </form>
                                  
                                 
                              </div>

                                <?php
                            }
                            
                            ?>
                            </div>
            </div>
         </div>

         
    <?php
    }
    else if($do=="addBook_to_database")
    {
        if($_SERVER['REQUEST_METHOD']=="POST")
        {
            $name=$_REQUEST['name'];
            $details=$_REQUEST['details'];
            
            $auther=$_REQUEST['auther'];
            $publication_year=$_REQUEST['publication_year'];
             




           
            
                $statement=$conn->prepare("INSERT INTO books ( name, details , auther, publication_year) VALUES ( :_name,:_details,:_auther,:_publication_year)");
                $statement->execute(array(
    
                    '_name'=>$name,
                    '_details'=>$details,
                    '_publication_year'=>$publication_year,
                     
                    '_auther'=>$auther
                    
    
                ));
                header('location: books.php');
                 exit();
            

        }
        else
        {
            header('location: books.php');
                 exit();
        }
    }
    else if($do=="addBook")
    {
    ?>
      <div class="container">
                <div class="card card_ d-flex justify-content-center" >
                        <div class="card-header card_book">
                            <div class="h1 d-flex justify-content-center">add category</div>
                        </div>
                        <div class="card-body">
                            <form action="?do=addBook_to_database" name="form" method="POST" onsubmit = "return(validation_add_book());"> 

                                        <div class="form-group">
                                            <label for="name">book name : </label>
                                            <input type="text" placeholder="name" class="form-control"   name="name"  >
                                        </div>
                                        <div class="alert alert-danger" id="error-name-book"></div>

                                        <div class="form-group">
                                            <label for="details">book details : </label>
                                            <br>
                                            <textarea name="details"  class="textarea" cols="30" rows="10"></textarea>
                                        </div>
                                        <div class="alert alert-danger" id="error-details-book"></div>

                                       <div class="form-group">
                                            <label for="auther">auther name : </label>
                                             <input type="text" class="form-control"  name="auther">
                                        </div>
                                        <div class="alert alert-danger" id="error-auther-book"></div>

                                        <div class="form-group">
                                            <label for="visible"> publication_year: </label>
                                             <input type="date" name="publication_year">
                                        </div>
                                        <div class="alert alert-danger" id="error-date-book"></div>

                                         
                                       
                                      
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-send " value="add book" name="submit" id="">   
                                        </div>
                            </form>
                             
                        </div>
                </div>
         </div>
    <?php 
    }
   
    else if($do=="delete")
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
           $id_will_del=$_REQUEST['id'];
           $statement=("DELETE FROM books WHERE id=$id_will_del");
           $conn->query($statement);
           header ('location: books.php?do=manage');
           exit();
        }
        else
        {
            header('location: books.php');
            exit();
        }
    }
    else if($do=="update")
    {
         
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
             
            $id= isset($_GET['id']) && is_numeric($_GET['id'])?intval($_GET['id']):0;
          
            $name=$_REQUEST['name'];
            $details=$_REQUEST['details'];
            $publication_year=$_REQUEST['publication_year'];
            $auther=$_REQUEST['auther'];

                $statement=$conn->prepare("UPDATE books SET name=?,details=?,publication_year=?,auther=? WHERE id=?");
                $statement->execute(array($name,$details,$publication_year,$auther,$id));
                 if($statement->rowCount()>0)
                 {
                     
                     header('location: books.php?do=manage');
                     exit();
                     
                 }



        }
        else
        {
            header('location: books.php');
            exit();
        }
    }

    else if($do=="edit")
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $id=$_REQUEST['id'];  
            $book=$conn->prepare("SELECT * FROM books WHERE id=? ");
            $book->execute(array($id));
            $row_of_book=$book->fetch();

            

            ?>
            <div class="container">
            <div class="card d-flex justify-content-center" >
                    <div class="card-header">
                        <div class="h1 d-flex justify-content-center">edit Book</div>
                    </div>
                    <div class="card-body">
                        <form action="?do=update&id=<?php echo $id?>" method="POST" name="form" onsubmit = "return(validation_add_book());"> 

                                       <div class="form-group">
                                            <label for="name">book name : </label>
                                            <input type="text" placeholder="name" class="form-control"   name="name" value="<?php echo $row_of_book['name']; ?>" >
                                        </div>
                                        <div class="alert alert-danger" id="error-name-book"></div>

                                        <div class="form-group">
                                            <label for="details">book details : </label>
                                            <br>
                                            <textarea name="details"  class="textarea" cols="30" rows="10"><?php echo $row_of_book['details']; ?></textarea>
                                        </div>
                                        <div class="alert alert-danger" id="error-details-book"></div>

                                       <div class="form-group">
                                            <label for="auther">auther name : </label>
                                             <input type="text" class="form-control"  name="auther" value="<?php echo $row_of_book['auther']; ?>">
                                        </div>
                                        <div class="alert alert-danger" id="error-auther-book"></div>

                                        <div class="form-group">
                                            <label for="visible"> publication_year: </label>
                                             <input type="date" name="publication_year" value="<?php echo $row_of_book['publication_year']; ?>">
                                        </div>
                                        <div class="alert alert-danger" id="error-date-book"></div>

                                    

                                    
                                    
                                
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" value="update" name="submit" id="">   
                                    </div>
                        </form>
                        
                    </div>
                </div>
            </div>
    
        
    <?php
            
 
            
        }
        else
        {
            header('location: books.php');
                 exit();
        }
       
    }
     







}
else if($_SESSION['role']==0)
{
    header('location: ../student/dashbord.php');
    exit();
}
else
{
    header('location: login.php');
    exit();
}
 
 