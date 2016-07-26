<!-- Connect to the DB -->
<?php require_once('../config.php') ?>
<?php
    // check if user is allowed in this location
    session_start();
  	if(isset($_SESSION["user"]))
  	{
  		$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
  		if($id>=1000000000)
    	{   
        	header('Location: MechanicSignin.php');
   	 	}else 
   	 	{ 
        // if thery are make a query to update the vehicle odometer
   	 		$Vodo = $_POST['newKM'];
   	 		$VIN = $_POST['VehicleId'];
   	 		$sql3 = "UPDATE vehicle SET Odometer_Reading = $Vodo WHERE Vehicle_Id ='$VIN'";
			   $result = mysql_query($sql3,$conn) or die (mysql_error());
        
   	 	}
  	}else
  	{
  		header('Location: Denied.html');
  	}
    header('Location: DriverSignin.php');
?>