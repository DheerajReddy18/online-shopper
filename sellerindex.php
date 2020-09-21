<?php
  include ("server.php");

  if(!isset($_SESSION['username']))
  {
    
	header("location:login.html");
  }
  
  if(isset($_GET['logout']))
  {
    session_destroy();
	unset($_SESSION['username']);
	header("location:login.html");
  }	
  
  
?>  
<html>
<head>
   <title>Customer</title>
   <style>
     .container1{
	     font-size:20px;
		   border-collapse:seperate;
		   border-spacing:10px;
	     position:absolute;
	     outline:5px solid black;
	     padding:20px;
       background-color: lime;
	  
	   }
      table,h2{
        margin-left:300px;
        
      }
     tr,td{
       
      
      width:150px;
     
     }
     #myinput{
       
      width:250px;
     }
	    body{
            background-color:aquamarine;
            
        }
        #button{
      background-color: blueviolet;
      cursor: pointer;
      height:30px;
      border-radius: 20px;
    }
   
   </style>
</head>
<body>
<h2 style="margin-left:500px;">click here to see all <a href="allorders.php">orders</a></h2>
 

     <h4>Enter the new product details </h4> 
     <div class="container1">
      <form action="server.php" method="post">
     
      <input type="text" name="productname" placeholder="Enter Product name" required >
      <span style="padding-left:70px"></span>
      
      <input type="numbers" name="cost" placeholder="cost of product" required>
      <span style="padding-left:70px"></span>
      
      <input type="numbers" name="quantity" placeholder="Quantity of product" required>
      <span style="padding-left:70px"></span>
      
      <input type="text" name="description" placeholder="Description" required>
      <span style="padding-left:70px"></span>
      <label for="img">Select image : </label>
      <input type="file" id="img" name="img" accept="image/*" required >
      <input type="submit" id="button" value="update" name="update"  >

      </form>
     </div>
  
  <br /> <br /> <br /> <br /> <br /> <br />
 
  <?php
    $name=$_SESSION['username'];
    $result=mysqli_query($db,"SELECT * FROM item WHERE sellername='$name' ");
    echo "<h2 >Items</h2>";
    echo "<table border='2' text-align='center' style='background-color:lightblue'><tr><td> Id </td><td>sellername</td><td>name</td><td>price</td><td>description</td><td>quantity</td></tr>";
    while($row=mysqli_fetch_assoc($result))
     {
       
       $t=$row['number'];
       echo "<tr><td>".$row['number']."</td><td>".$row['sellername']."</td><td>".$row['name']."</td><td>".$row['price']."</td><td>".$row['description']."</td><td>".$row['quantity']."</td></tr>";
      
      }  
    
   
 
    echo "</table>";	
     
  
  ?>

  


  
  <br /> <br /> <br /> 
  <div class="container1">
   <h3>Enter the updated details </h3> 
  <form action="server.php" method="post">
  <input type="numbers" name="myinput" id="myinput" placeholder="Enter the ID  of product to update " required>
  <br />
  <br />
  <input type="text" name="productname" placeholder="Enter Product name" required >
  <br />
  <br />  
  <input type="numbers" name="cost" placeholder="cost of product" required>
  <br />
  <br />   
  <input type="numbers" name="quantity" placeholder="Quantity of product" required>
  <br />
  <br />  
  <input type="text" name="description" placeholder="Description" required>
  <br />
  <br />
  <input type="submit" value="reupdate" name="reupdate">
  </form>
    </div>
   <a href="sellerindex.php?logout='1'"  style='float:right;font-size:30px;margin-top:300px;' >logout</a>

  </body>
</html>