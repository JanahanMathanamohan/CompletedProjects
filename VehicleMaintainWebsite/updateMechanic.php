<!--Access the database-->
<?php require_once('../config.php') ?>
<?php
  // session starts and redirects from users
  session_start();

  	if(isset($_SESSION["user"]))
  	{
  		$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
  		if($id>=1000000000)
    	{   
        	header('Location: MechanicSignin.php');
   	 	}else 
   	 	{
        // updates preferred user 
   	 		$mech = $_POST['MechanicId'];
   	 		
   	 		$sql3 = "UPDATE driver SET Mechanic_Id = $mech WHERE Driver_Id =$id";
		    $result = mysql_query($sql3,$conn) or die (mysql_error());
        header('Location: DriverSignin.php');
   	 	}
  	}else
  	{
  		header('Location: Denied.html');
  	}
?>