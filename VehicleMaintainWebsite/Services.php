<!-- Connect to the Database -->
<?php require_once('../config.php') ?>
<?php
  // Redirects user if the user is not able to acess this page 
	session_start();
  	if(isset($_SESSION["user"]))
  	{
  		$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
  		if($id>=1000000000)
    	{   
        
        	header('Location: MechanicSignin.php');
   	 	}
  	}else
  	{
  		header('Location: Denied.html');
  	}
    // Variables    
  	$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
  	$type = $_POST['type'];
  	$city = $_POST['city'];
  	$service = $_POST['serviceType'];
    // Checks if the value submitted into what service view they want to see
    if($type == 1)
    {
        // If below average prices was selected
        echo "<!DOCTYPE html>
                <html>
                <head>
                  <link rel=\"shortcut icon\" type=\"image/ico\" href=\"favicon.ico\" />  
                  <script type=\"text/javascript\" src=\"js/jquery-1.11.0.min.js\"></script>
                  <script type=\"text/javascript\" src=\"js/jquery.leanModal.min.js\"></script>
                  <title>Sign Up Mechanic Success</title>
                  <meta charset=\"utf-8\" />
                  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />
                  <!--[if lte IE 8]><script src=\"assets/js/ie/html5shiv.js\"></script><![endif]-->
                  <link rel=\"stylesheet\" href=\"assets/css/main.css\" /> 
                </head>
                <body>
                  <section id=\"banner\">
                      <h2><strong>Below Average Price in $service in $city</strong></h2>
                    </section>  
                  <section id=\"three\" class=\"wrapper style2 special\">
               <table  >
                 
                  <tr>
                    <td>Mechanic Name </td>
                    <td>Mechanic Id</td>
                    <td>Address</td>
                    <td>Price</td>
                    <td>Length</td>
                  </tr>
                ";
            // query to pull out the prices below average
            $id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
            $sql=" SELECT  M.Mechanic_Name AS name, M.Mechanic_Id AS ID, M.Location As Address, S.Price AS Price, S.Time_Length AS Length
                  FROM    service AS S, mechanic AS M
                  WHERE   M.Mechanic_Id = S.Mechanic_Id and M.City = '$city' and S.Service_Type='$service' and S.Price <= (   SELECT avg(D.Price)
                                                                  FROM  service AS D
                                                                  WHERE D.Service_Type = '$service');";
            $result=mysql_query($sql,$conn) or die(mysql_error());
            // fill out the table from query
            while ($row = mysql_fetch_array($result)){
              $name =$row['name'];
              $mid =$row['ID'];
              $address = $row['Address'];
              $price = $row['Price'];
              $length =$row['Length'];
                echo "
                    <tr>
                    <td >$name</td>
                  <td>$mid</td>
                  <td>$address</td>
                  <td>$price</td>
                  <td>$length</td>
                  </tr>
    
                  ";
            }
                                
        echo"    
                  </table>
                 </section>
                  <section id=\"three\" class=\"wrapper style2 special\">
                       <a href=\"DriverSignin.php\"> Click here to go to your home page</a>
                  </section>
                </body>
                </html>";
    }
    if($type == 2)
    {
        // If below average length was selected
        echo "<!DOCTYPE html>
                <html>
                <head>
                  <link rel=\"shortcut icon\" type=\"image/ico\" href=\"favicon.ico\" />  
                  <script type=\"text/javascript\" src=\"js/jquery-1.11.0.min.js\"></script>
                  <script type=\"text/javascript\" src=\"js/jquery.leanModal.min.js\"></script>
                  <title>Sign Up Mechanic Success</title>
                  <meta charset=\"utf-8\" />
                  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />
                  <!--[if lte IE 8]><script src=\"assets/js/ie/html5shiv.js\"></script><![endif]-->
                  <link rel=\"stylesheet\" href=\"assets/css/main.css\" /> 
                </head>
                <body>
                  <section id=\"banner\">
                      <h2><strong>Below Average Time in $service in $city</strong></h2>
                    </section>  
                  <section id=\"three\" class=\"wrapper style2 special\">
               <table  >
                 
                  <tr>
                    <td>Mechanic Name </td>
                    <td>Mechanic Id</td>
                    <td>Address</td>
                    <td>Price</td>
                    <td>Length</td>
                  </tr>
                ";
            // query to pull out the length below average
            $id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
            $sql=" SELECT  M.Mechanic_Name AS name, M.Mechanic_Id AS ID, M.Location As Address, S.Price AS Price, S.Time_Length AS Length
                  FROM    service AS S, mechanic AS M
                  WHERE   M.Mechanic_Id = S.Mechanic_Id and M.City = '$city' and S.Service_Type='$service' and S.Time_Length<= (   SELECT avg(D.Time_Length)
                                                                  FROM  service AS D
                                                                  WHERE D.Service_Type = '$service');";
            $result=mysql_query($sql,$conn) or die(mysql_error());
            // fill out tables with query results
            while ($row = mysql_fetch_array($result)){
              $name =$row['name'];
              $mid =$row['ID'];
              $address = $row['Address'];
              $price = $row['Price'];
              $length =$row['Length'];
                echo "
                    <tr>
                    <td >$name</td>
                  <td>$mid</td>
                  <td>$address</td>
                  <td>$price</td>
                  <td>$length</td>
                  </tr>
    
                  ";
            }
                                
        echo"    
                  </table>
                 </section>
                  <section id=\"three\" class=\"wrapper style2 special\">
                       <a href=\"DriverSignin.php\"> Click here to go to your home page</a>
                  </section>
                </body>
                </html>";
    }
    if($type == 3)
    {
        // All servies
        echo "<!DOCTYPE html>
                <html>
                <head>
                  <link rel=\"shortcut icon\" type=\"image/ico\" href=\"favicon.ico\" />  
                  <script type=\"text/javascript\" src=\"js/jquery-1.11.0.min.js\"></script>
                  <script type=\"text/javascript\" src=\"js/jquery.leanModal.min.js\"></script>
                  <title>Sign Up Mechanic Success</title>
                  <meta charset=\"utf-8\" />
                  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />
                  <!--[if lte IE 8]><script src=\"assets/js/ie/html5shiv.js\"></script><![endif]-->
                  <link rel=\"stylesheet\" href=\"assets/css/main.css\" /> 
                </head>
                <body>
                  <section id=\"banner\">
                      <h2><strong>All $service in $city</strong></h2>
                    </section>  
                  <section id=\"three\" class=\"wrapper style2 special\">
               <table  >
                 
                  <tr>
                    <td>Mechanic Name </td>
                    <td>Mechanic Id</td>
                    <td>Address</td>
                    <td>Price</td>
                    <td>Length</td>
                  </tr>
                ";
            // search query for all of them
            $id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
            $sql=" SELECT  M.Mechanic_Name AS name, M.Mechanic_Id AS ID, M.Location As Address, S.Price AS Price, S.Time_Length AS Length
                  FROM    service AS S, mechanic AS M
                  WHERE   M.Mechanic_Id = S.Mechanic_Id and M.City = '$city' and S.Service_Type='$service'";
            $result=mysql_query($sql,$conn) or die(mysql_error());
            // fills in the table
            while ($row = mysql_fetch_array($result)){
              $name =$row['name'];
              $mid =$row['ID'];
              $address = $row['Address'];
              $price = $row['Price'];
              $length =$row['Length'];
                echo "
                    <tr>
                    <td >$name</td>
                  <td>$mid</td>
                  <td>$address</td>
                  <td>$price</td>
                  <td>$length</td>
                  </tr>
    
                  ";
            }
                                
        echo"    
                  </table>
                 </section>
                  <section id=\"three\" class=\"wrapper style2 special\">
                       <a href=\"DriverSignin.php\"> Click here to go to your home page</a>
                  </section>
                </body>
                </html>";
    }
  
?> 

