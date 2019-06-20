
<?php
session_start();
if(!isset($_SESSION['username']))
{

    $_SESSION['msg']="You must log in first to view this page";
    header("location : login.php");
}

if(isset($_GET['logout']))
{
      
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<link rel="stylesheet" href="style1.css">
<title>Home Page</title>
</head>
  <body>
  <?php if(isset($_SESSION['success'])) : ?>
  <div>
  <h3>
  <?php
  echo $_SESSION['success'];
  unset($_SESSION['success']);
  ?>
  </h3>
  </div>
  <?php endif ?>
  <?php if(isset($_SESSION['username'])) : ?>
  <?php include('server2.php') ?>
      <h1>Welcome <strong><?php echo $_SESSION['username']; ?></strong></h1>
    
      <div class="row">
     
    <div class="col-sm-3">
   
        <ul>
        <h1>Dashboard </h1><br><br><br>
        <?php 
          $username= $_SESSION['username'];
         $sql="SELECT COUNT(id) FROM $username WHERE stat='unread' " ;
         
         $co=mysqli_fetch_array(mysqli_query($db,$sql))or die( mysqli_error($db));
         $i= $co['COUNT(id)'];
         ?>
   
      
        <li class="nav-item dropdown"  action="share.php" method="post" name="notification" >
        <a class="nav-link " name="notf"  href="#" id="dropdown01" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?php
     if(isset($_GET['notf']))
     {
          
      $username=$_SESSION['username'];
      $sql="UPDATE $username SET stat= 'read' WHERE NOT msg= '1'";
      mysqli_query($db, $sql) ;
     }

         ?>


       
         NOTIFICATIONS
       
     

         <?php if($i>0):?>
         <span class="badge bage-light" style="color:blue;" ><?php echo $i ;?></span></a>
         <?php endif; ?>
         <?php 
             $username= $_SESSION['username'];
             $user_check_query="SELECT * FROM $username   WHERE stat='unread' OR stat='read'  ORDER BY dat DESC ";
             $results=mysqli_query($db, $user_check_query );
         ?>
      
   
           <div class="dropdown-menu" aria-labelledby="dropdown01">
           <?php while($user1=mysqli_fetch_array($results)) :?>
        
        <?php if($user1['stat']=='unread'):?>
            <a class="dropdown-item " href="#"><?php echo $user1['dat'];?></a>
          <a class=" alert-warning" href="?notf"><b><?php echo $user1['msg'];?></b>
          </a>
    <?php endif; ?>
    <?php if($user1['stat']=='read'):?>
            <a class="dropdown-item" href="#"><?php echo $user1['dat'];?></a>
          <a class="dropdown-item" href="?notf"><b><?php echo $user1['msg'];?></b>
          </a>
    <?php endif;?>
        <div class="dropdown-divider"></div>
        
        
<?php endwhile;

      ?>
      
    </div>
      </li>
  
        <br>
        
        
        
            <li ><a href="index.php"> EXPENSE MANAGER</a></li>
            <br>
            <li class="active" >SETTLE</li><br>
            <li><a href="contact.php">CONTACT</a></li><br>
            <li><a href="index.php?logout='1'">LOGOUT</a></li><br>
         
            <?php 
        $db = mysqli_connect('localhost','root','', 'user');
           $username= $_SESSION['username'];
           $sql="SELECT SUM(Amount)  FROM $username WHERE TRANS = 'income' " ;
         
          $income=mysqli_fetch_array(mysqli_query($db,$sql))or die( mysqli_error($db));
         
          $sql="SELECT SUM(Amount)  FROM $username WHERE TRANS = 'expenses' " ;
         
          $expenses=mysqli_fetch_array(mysqli_query($db,$sql))or die( mysqli_error($db));
         $balance=  $income['SUM(Amount)']-  $expenses['SUM(Amount)'];
           ?>
          
           <p id="balance">Balance:  <?php echo $balance; ?> </p>
      
        </ul>
</div>
<div class="col-sm-4">
        <form  class="row"   action="share.php" method="post">
      
             <h2>SETTLE </h2>
        
             <br>
                
               <br>
               <input placeholder="FROM password:" type="text" name="password" required>
               <h2>Details for sharing money</h2>
               <input placeholder="To(username:)" type="text" name="susername" required>
               <input placeholder="To(email id)" type="email" name="semail" required>              
               <br>
               
               <div>
               <br>

               Amount: <input placeholder="Amount:"  type="integer" name="amounts" required>
</div>
              
        
             
          <div>
          <?php 
                date_default_timezone_set("Asia/Kolkata");
                ?>
                    <br>
                Date:<input type="text" value="<?php echo date("d/m/Y G:i:s "); ?>"  name="date" required>
             </div>
            
             
              
          <input type="text" placeholder="DESCRIPTION:" name="description" required>
             
            
             <br>
             <button class="btn btn-primary" type="submit"  name="settle" >Submit</button>
             
 </form>

</div>



   
      
     </div>

          <?php endif ?>
        
       </body>
     
      </html>
  