<?php




// Creating connection
$db = mysqli_connect('localhost','root','', 'user');
$username=$_SESSION['username'];
// Checking connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
$trans="";
$amount="";
$category="";
$dat="";

$des="";

$ms="";


    
        $sql = "CREATE TABLE $username(
                      id  INT(6) UNSIGNED AUTO_INCREMENT , 
                      TRANS VARCHAR(255) ,
                      Amount VARCHAR(255) ,
                      category VARCHAR(255),
                        dat VARCHAR(255),
                   descript VARCHAR(255),
                      msg VARCHAR(255),
                      stat VARCHAR(255),
                      PRIMARY KEY(id)
                   
           )";
           mysqli_query($db, $sql) ;
       
        
    
    if(isset($_POST["income"])==TRUE)
    {
        $username=$_SESSION['username'];
        $trans="income";
        $amount=mysqli_real_escape_string($db, ($_POST['amounti']));
        $category=mysqli_real_escape_string($db, ($_POST['category']));
        $dat=mysqli_real_escape_string($db, ($_POST['date']));
     
        $des=mysqli_real_escape_string($db,($_POST['description']));
        $ms="1";

        $query= "INSERT INTO $username ( TRANS, Amount, category, dat, descript, msg, stat) VALUES ('$trans', '$amount', '$category', '$dat', '$des', '$ms', '$ms') ";
        mysqli_query($db, $query) ;

        header('location: index.php');


    }
    elseif(isset($_POST["expenses"])==TRUE)
    {
        $username=$_SESSION['username'];
        $trans="expenses";
        $amount=mysqli_real_escape_string($db, ($_POST['amounte']));
        $category=mysqli_real_escape_string($db, ($_POST['category']));
        $dat=mysqli_real_escape_string($db, ($_POST['date']));
        $ms="1";
        $des=mysqli_real_escape_string($db,($_POST['description']));

        $query= "INSERT INTO $username ( TRANS, Amount, category, dat,  descript, msg, stat) VALUES ('$trans', '$amount', '$category', '$dat','$des', '$ms', '$ms') ";
        mysqli_query($db, $query) ;

        header('location: index.php');


    }



?>