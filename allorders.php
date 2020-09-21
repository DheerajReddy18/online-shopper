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
       body{
        background-color:aquamarine;
       }
       table{
        margin-left:300px;
        
      }
     tr,td{
       
      
      width:150px;
     
     }
  </style>
  </head>
  <body>
  <input type="text" name="search" placeholder="enter product name or user name" onkeyup="myfunction()" id="myinput" style=" margin-left:300px;width:250px;height:30px; " required>
  <br />
  <br/>
  <?php
    $name=$_SESSION['username'];
    $result=mysqli_query($db,"SELECT * FROM user");
     echo "<table border='2' text-align='center' id='mytable' style='background-color:lightblue'><thead><th> Id </th><th>name</th><th>product</th><th>quantity</th><th>price</th></thead>";
    if($result)
    {
     while($row=mysqli_fetch_assoc($result))
     {
       $quantity=$row['quantity'];
       $productname=$row['product'];
       $t=$row['id'];
       echo "<tr><td>".$row['id']."</td><td>".$row['username']."</td><td>".$row['product']."</td><td>".$row['quantity']."</td><td>".$row['total']  ."</td>";
      
      }  
    
    }
 
    echo "</table>";	
    
?>

<p>click here to <a href="sellerindex.php">go back</a></p>
<script>
        function myfunction(){
          var input=document.getElementById("myinput");
          var filter=input.value.toUpperCase();
          var table =document.getElementById("mytable");
          var tr=table.getElementsByTagName("tr");
          for(var i=0;i<tr.length;i++)
          {
            var td=tr[i].getElementsByTagName("td")[1];
            var t=tr[i].getElementsByTagName("td")[2];
            if(td)
            {
            var txtvalue=td.textContent;
            if(txtvalue.toUpperCase().indexOf(filter)>-1)
                 tr[i].style.display="";
            else
                tr[i].style.display="none";
            }  
            if(t && tr[i].style.display=="none" )
            {
              var txt=t.textContent;
              if(txt.toUpperCase().indexOf(filter)>-1)
                 tr[i].style.display="";
              else
                tr[i].style.display="none";
            }

          }

        }
        
        
        </script>
  

 </body>
</html>
