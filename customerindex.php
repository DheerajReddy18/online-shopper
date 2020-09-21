<?php
 
  include ("server.php");

  if(!isset($_SESSION['username']))
  {
    
	header("location:index.html");
  }
  
  if(isset($_GET['logout']))
  {
    session_destroy();
	unset($_SESSION['username']);
	header("location:index.html");
  }	
  
  
?>  
<html>
<head>
   <title>Customer</title>
   <style>
      .grid-container{
       display:grid; 
       grid-template-columns: auto auto auto auto;
       grid-gap:10px;
       padding:10px;
       background-color: aquamarine;
	  
     }
     
    .grid-container > div{
        text-align:center;
        padding:20px 0;
        font-size:30px;
        background-color:lightblue;
    }

	    body{
            background-color:orange;
            
        }
        table,h2{
        margin-left:300px;
        
      }
     tr,td{
       
      
      width:150px;
     
     }
    #button{
      background-color: blueviolet;
      cursor: pointer;
      width:100px;
      height:30px;
      border-radius: 20px;
    }
    #button1{
      background-color: blueviolet;
      cursor: pointer;
      width:100px;
      height:30px;
      border-radius: 20px;
      margin-left:700px

    }
    .quantity{
      width:150px;
      height:30px;
    }
   </style>
</head>
<body>
   
    <div class="grid-container">
    <?php
    $name=$_SESSION['username'];
    $result=mysqli_query($db,"SELECT * FROM item ");
   
    
    while($row=mysqli_fetch_assoc($result))
     {
       echo "<div>";
       echo  $row['name'];
       echo "<br />";
       echo "<br />";
       echo '<img src="images/'.$row['image'].'" alt="phone" height="200" width="200" > ';
       echo "<br />";
       echo "<br />";
       echo  "Price :".$row['price'];
       echo "<br />";
       echo "<br />";
       echo  "Description :". $row['description'];
       echo "<br />";
       echo "<br />";
       echo  "Items left :".$row['quantity'];
       echo "<br />";
       echo "<br />";
       $var=$row['name'];
       echo "<form  action='server.php' method='post'>";
       echo "<input type='number' name='quantity' placeholder='quantity' required>";
       echo  "<br/><br/>";
       echo "<button type='submit' class='button' value='$var' name='add' >add to cart </button>";
       echo  '</form>'; 
       echo   '</div>';
     }
      ?>
   
      </div> 
      
      <?php
    $name=$_SESSION['username'];
    $result=mysqli_query($db,"SELECT * FROM user WHERE username='$name' ");
    echo "<h2 >CART</h2>";
    echo "<table border='2' text-align='center' style='background-color:lightblue'><tr><td> Id </td><td>name</td><td>product</td><td>quantity</td><td>price</td><td>remove</td></tr>";
    if($result)
    {
     while($row=mysqli_fetch_assoc($result))
     {
       $quantity=$row['quantity'];
       $productname=$row['product'];
       $t=$row['id'];
       echo "<tr><td>".$row['id']."</td><td>".$row['username']."</td><td>".$row['product']."</td><td>".$row['quantity']."</td><td>".$row['total']  ."</td>";
       echo "<td><form action='server.php' method='post'><input type='hidden' name='productname' value='$productname' ><input type='hidden' name='quantity' value='$quantity' ><button type='submit' name='send'  value='$t'>remove</button></form></td></tr>";
      }  
    
    }
 
    echo "</table>";	
    
  
  ?>
    
   <button id="button1" onclick="order();" >place order</button>

   <a href="sellerindex.php?logout='1'"  style='float:right;font-size:30px;margin-top:200px;' >logout</a>
   <script>
        function order(){
         alert("order placed");

        }
  </script> 
  
  
  </body>
</html>
