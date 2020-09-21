<?php
  session_start();

  $errors=array();
  
 

  $db=mysqli_connect('127.0.0.1','root','');
  mysqli_query($db ,"CREATE DATABASE shopping");
  mysqli_select_db($db,'shopping');
  $table1="CREATE TABLE info(serialnumber INT(11) AUTO_INCREMENT PRIMARY KEY,username VARCHAR(255),emailid VARCHAR(255),password VARCHAR(255),accounttype VARCHAR(255))";
  mysqli_query($db,$table1);
  $table2="CREATE TABLE user(id INT(11) AUTO_INCREMENT PRIMARY KEY,username VARCHAR(255),product VARCHAR(255),quantity INT(11),total INT(11))";
  mysqli_query($db,$table2);
  $table3="CREATE TABLE item(number INT(11) AUTO_INCREMENT PRIMARY KEY,sellername VARCHAR(255),name VARCHAR(255),description VARCHAR(255),image LONGBLOB NOT NULL,price VARCHAR(255), quantity INT(10))";
  mysqli_query($db,$table3);

 


  if(isset($_POST['register']))
 {
  $accounttype=mysqli_real_escape_string($db,$_POST['accounttype']);	
  $username=mysqli_real_escape_string($db,$_POST['username']);	  
  $emailid=mysqli_real_escape_string($db,$_POST['emailid']);	
  $password_1=mysqli_real_escape_string($db,$_POST['password_1']);	
  $password_2=mysqli_real_escape_string($db,$_POST['password_2']);	
  $count=0; 
 
  if(empty($username))
    array_push($errors,"username is required");	 
  if(empty($emailid))
    array_push($errors,"email is required");	 
  if(empty($password_1))
    array_push($errors,"password is required");	 
  if($password_1!=$password_2)
    array_push($errors,"passwords do not match");
  if(strlen($password_1)<=8)
    array_push($errors,"password must be 8 characters atleast");
  for ($i=0;$i<=strlen($password_1)-1;$i++)
  {
     if(is_numeric($password_1[$i]))
     {
       $count+=1;
     }
  
 }
  if($count==0)
  array_push($errors,"password must have 1 number atleast");
  $info_check_query="SELECT * FROM info WHERE username = '$username' or emailid='$emailid' LIMIT 1";
  $result=mysqli_query($db,$info_check_query);
  $name=mysqli_fetch_assoc($result);
  if($name)
  {
    if($name['username']==$username)
	  array_push($errors,"username already exists");
	if($name['emailid']==$emailid)
	  array_push($errors,"emailid  has already registered ");  
  }  
   if(count($errors)==0)
  {
   $password=md5($password_1);
   $query="INSERT INTO info(username,emailid,password,accounttype) VALUES ('$username','$emailid','$password','$accounttype')";  
   if(!mysqli_query($db,$query))
     echo '<br />not inserted';
   else
     echo '<br />inserted';
  $_SESSION['username']=$username;
  $_SESSION['accounttype']=$accounttype;
  $_SESSION['success']="you are now logged in";
  if($accounttype=="customer")
    header("location:customerindex.php");
  else
    header("location:sellerindex.php");
 }
} 
 
 

 if(isset($_POST['login']))
 {
  
    $username=mysqli_real_escape_string($db,$_POST['username']);	  
    $password=mysqli_real_escape_string($db,$_POST['password_1']);	
    if(empty($username))
      array_push($errors,"username is required");	 
    if(empty($password))
      array_push($errors,"password is required");	 
    if(count($errors)==0)
	{
	   $password=md5($password);
       $query="SELECT * FROM info WHERE username='$username' AND password='$password' ";  
       $results= mysqli_query($db,$query);
       $row=mysqli_fetch_assoc($results);
       
	   if(mysqli_num_rows($results))
	   {
         $_SESSION['username']=$username;
         $_SESSION['success']="logged in successfully";
		 if($row['accounttype']=="customer")
             header("location:customerindex.php");
        else
             header("location:sellerindex.php");
	   }
	   else
	   
	     array_push($errors,"wrong username or password  try again");
	}  
	 else
	 {
	    echo 'hi';
	    array_push($errors,"wrong username or password  try again");
          
	  } 
 }
	
	 if(count($errors)!=0)
	 {
     
      foreach($errors as $error)
	  {
	    echo $error ;
		echo "<br>";
		
	    
	  }
  }
  
  if(isset($_POST['add']))
  {
     $username=$_SESSION['username'];
     $name=$_POST['add'];
     $quantity=mysqli_real_escape_string($db,$_POST['quantity']);
     $query="SELECT * FROM item WHERE name='$name' ";
     $result= mysqli_query($db,$query);
    while( $row=mysqli_fetch_assoc($result))
    {
     if(number_format($quantity)>$row['quantity'])
     {
       echo '<script>alert("stock not available")</script>';
       echo " <a href='customerindex.php'>go back</a>";
       break;
     }
     else{
      $rem=$row['quantity']-$quantity;
      $query2="UPDATE item SET quantity='$rem' WHERE name='$name'";
      mysqli_query($db,$query2);
      $total=$row['price']*$quantity;
      $query1="INSERT INTO user(username,product,quantity,total) VALUES ('$username','$name','$quantity','$total') ";
      mysqli_query($db,$query1);
     }
     
      header("Refresh:3 , url=customerindex.php");
      
    } 
}
 if(isset($_POST['send']))
 {
   $del=$_POST['send'];
   $productname=$_POST['productname'];
   $quantity=$_POST['quantity'];
   $que="DELETE FROM user WHERE id='$del'";
   mysqli_query($db,$que);
   $query="SELECT * FROM item WHERE name='$productname'";
   $result=mysqli_query($db,$query);
   while( $row=mysqli_fetch_assoc($result))
    {
      $total=$row['quantity']+$quantity;
      $query2="UPDATE item SET quantity='$total' WHERE name='$productname'";
      mysqli_query($db,$query2);
    }
   header("location:customerindex.php");
 }
  if(isset($_POST['update']))
  {
    $sellername=$_SESSION['username'];
    $productname=mysqli_real_escape_string($db,$_POST['productname']);	
    $price=mysqli_real_escape_string($db,$_POST['cost']);
    $description=mysqli_real_escape_string($db,$_POST['description']);
    $quantity=mysqli_real_escape_string($db,$_POST['quantity']);
    $image=$_POST['img'];
    $query="INSERT INTO item(sellername,name,price,description,quantity,image) VALUES ('$sellername','$productname','$price','$description','$quantity','$image')";  
    mysqli_query($db,$query);
    header("location:sellerindex.php");
  } 
  if(isset($_POST['reupdate']))
  {
    $id=mysqli_real_escape_string($db,$_POST['myinput']);	
    $sellername=$_SESSION['username'];
    $productname=mysqli_real_escape_string($db,$_POST['productname']);	
    $price=mysqli_real_escape_string($db,$_POST['cost']);
    $description=mysqli_real_escape_string($db,$_POST['description']);
    $quantity=mysqli_real_escape_string($db,$_POST['quantity']);	
    $query="UPDATE item SET sellername='$sellername',name='$productname',price='$price',description='$description',quantity='$quantity' WHERE number='$id' ";
    if(mysqli_query($db,$query))
    {
     
      header("location:sellerindex.php");
    }

    else
      echo "error";
     
  }


   ?>