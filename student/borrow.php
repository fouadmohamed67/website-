<?php
    session_start();
    $page_title ='borrow books ';
    include 'init.php';
    
    if(isset($_SESSION['name']))
    {   
        if($_SERVER['REQUEST_METHOD']=='POST')
        {

            $id=$_REQUEST['id'];
            $dayes=$_REQUEST['period'];
            $dayes= $dayes*7;
            $date=date("Y/m/d");
            $date=date("Y/m/d",strtotime($date.' + '.$dayes.' days'));
            $user_id=$_SESSION['id']; 
            $statement=$conn->prepare("UPDATE books SET borrower_id=? ,date_back=?  WHERE id=?");
            $statement->execute(array($_SESSION['id'],$date,$id));
            header('location: viewBooks.php');
            exit();
        

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