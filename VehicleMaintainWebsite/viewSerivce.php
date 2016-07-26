<?php require_once('../config.php') ?>
<!-- Access the DB-->
<?php
  // create the session and redirects if the user is not suppose to be here
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
  	$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
  	$VID = $_POST['submit'];

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
                      <h2><strong>Services on $VID</strong></h2>
                    </section>  
                  <section id=\"three\" class=\"wrapper style2 special\">
               <table  >
                 
                  <tr>
                    <td>Mechanic_ID</td>
                    <td>Date</td>
                    <td>Service Type</td>
                  </tr>
                ";
            // query to retruve all the services for a specific vehicle
            $id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
            $sql=" SELECT  *
                  FROM    service_history
                  WHERE vehicle_Id='$VID'";
                  $result=mysql_query($sql,$conn) or die(mysql_error());
                // fill the table
              while ($row = mysql_fetch_array($result)){
              $mid =$row['Mechanic_Id'];
              $date = $row['Date_of_Service'];
              $type = $row['Service_Type'];
                echo "
                    <tr>
                    <td >$mid</td>
                  <td>$date</td>
                  <td>$type</td>
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
?> 

