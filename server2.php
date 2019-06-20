<?php
$db = mysqli_connect('localhost','root','', 'user');
$username=$_SESSION['username'];
// Checking connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
if(isset($_POST["settle"])==TRUE)
{
    
         $password = mysqli_real_escape_string($db, ($_POST['password']));
         $susername = mysqli_real_escape_string($db, ($_POST['susername']));
         $semail = mysqli_real_escape_string($db, ($_POST['semail']));
        $dat=mysqli_real_escape_string($db, ($_POST['date']));
       
        $des=mysqli_real_escape_string($db,($_POST['description']));
        $amounts=mysqli_real_escape_string($db, ($_POST['amounts']));
        $password= md5($password);
        $query= "SELECT * FROM user1 WHERE  password= '$password'";
        $results=mysqli_query($db, $query);
        if(mysqli_fetch_assoc($results))
        {

        $user_check_query="SELECT * FROM user1 WHERE username= '$susername' AND email='$semail' LIMIT 1  ";
        $results=mysqli_query($db, $user_check_query );
        $user1 = mysqli_fetch_assoc($results);
       if($user1)
       {
     
        
        $trans1="expenses";
        $trans2="income";
      
        $category1="shared";
        $category2="share";
      
        $ms1="amount shared to $susername";
        $ms2="amount shared by $username";
        $rd="unread";
       
      

        $query= "INSERT INTO $susername ( TRANS, Amount, category, dat,  descript, msg, stat) VALUES ('$trans2', '$amounts', '$category2', '$dat','$des', '$ms2', '$rd') ";
        mysqli_query($db, $query) ;
        $query= "INSERT INTO $username ( TRANS, Amount, category, dat, descript, msg, stat) VALUES ('$trans1', '$amounts', '$category1', '$dat','$des', '$ms1', '$rd') ";
        mysqli_query($db, $query) ;
        
    


        header('location: share.php');


       }
       else{
           echo "error";
       }
    }


}



?>