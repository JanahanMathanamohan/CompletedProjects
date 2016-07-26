<!--Access to DB-->
<?php require_once('../config.php') ?>
<?php
	// starts session and redirects if user is not suppose to be their
	session_start();
	if(isset($_SESSION["user"]))
  	{
  		$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
  		if($id>1000000000 )
    	{   
        
        	header('Location: MechanicSignin.php');
   	 	}else
   	 	{
   	 		header('Location: DriverSignin.php');
   	 	}
  	}
  	// variable decleration
	$name = $_POST['mName'];
	$email = $_POST['mMail'];
	$password = $_POST['mPassword'];
	$phone = $_POST['mPhone'];
	$loc = $_POST['mLoc'];
	$city = $_POST['mCity'];
	$comp = $_POST['mCo'];

	$soilPrice = floatval($_POST['soilPrice']);
	$synoilPrice = floatval($_POST['synoilPrice']);
	$fsynoilPrice = floatval($_POST['fsynoilPrice']);
	$alignPrice = floatval($_POST['alignPrice']);
	$brakePrice = floatval($_POST['brakePrice']);
	$FFSPrice = floatval($_POST['FFSPrice']);

	$soilLength=(is_numeric($_POST['soilLength']) ? (int)$_POST['soilLength'] : 0);
	$synoilLength=(is_numeric($_POST['synoilLength']) ? (int)$_POST['synoilLength'] : 0);
	$fsynoilLength=(is_numeric($_POST['fsynoilLength']) ? (int)$_POST['fsynoilLength'] : 0);
	$alignLength=(is_numeric($_POST['alignLength']) ? (int)$_POST['alignLength'] : 0);
	$brakeLength=(is_numeric($_POST['brakeLength']) ? (int)$_POST['brakeLength'] : 0);
	$FFSLength=(is_numeric($_POST['FFSLength']) ? (int)$_POST['FFSLength'] : 0);

	// insert into database the user que//ry
	$sql = "INSERT INTO mechanic(Mechanic_Name, Email, Phone, Company, Location, City, Mechanic_PW) VALUES ('$name','$email','$phone','$comp','$loc','$city','password')";
	$result=mysql_query($sql,$conn) or die(mysql_error());
	// get the mechanic id
	$sql2 = "SELECT Max(Mechanic_Id) AS MAx FROM mechanic";
	$Id = mysql_query($sql2,$conn) or die(mysql_error());
	while ($row = mysql_fetch_array($Id)) {
 		$max=$row['MAx'];
	}
	// insert all the services into the service table
	$sql = "INSERT INTO service(Mechanic_Id, Service_Type, Price, Time_Length) VALUES ($max,'Standard Oil Change', $soilPrice,$soilLength);";
	$sql1 = "INSERT INTO service(Mechanic_Id, Service_Type, Price, Time_Length) VALUES ($max,'Synthetic Blend Oil Change', $synoilPrice,$synoilLength);";
	$sql2 = "INSERT INTO service(Mechanic_Id, Service_Type, Price, Time_Length) VALUES ($max,'Full Synthetic Oil Change', $fsynoilPrice,$fsynoilLength);";
	$sql3 = "INSERT INTO service(Mechanic_Id, Service_Type, Price, Time_Length) VALUES ($max,'Tire Alignment', $alignPrice,$alignLength);";
	$sql4 = "INSERT INTO service(Mechanic_Id, Service_Type, Price, Time_Length) VALUES ($max,'Brake Service', $brakePrice,$brakeLength);";
	$sql5 = "INSERT INTO service(Mechanic_Id, Service_Type, Price, Time_Length) VALUES ($max,'Fuel Filter Service', $FFSPrice,$FFSLength);";
	$result=mysql_query($sql,$conn) or die(mysql_error());
	$result=mysql_query($sql1,$conn) or die(mysql_error());
	$result=mysql_query($sql2,$conn) or die(mysql_error());
	$result=mysql_query($sql3,$conn) or die(mysql_error());
	$result=mysql_query($sql4,$conn) or die(mysql_error());
	$result=mysql_query($sql5,$conn) or die(mysql_error());
	// get the mechanic name
	$sql2 = "SELECT Mechanic_Name  FROM mechanic WHERE Mechanic_Name=$max";
	$Id = mysql_query($sql2,$conn) or die(mysql_error());
	while ($row = mysql_fetch_array($Id)) {
 		$name=$row['Mechanic_Name'];
	}
	//set the session

	$_SESSION["user"]=$max;
	// output sing up success
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
				<h2><strong>SignUp Success</strong> remeber you Id is <br></br> <strong>$max</strong></h2>
				<p>Welcome $name</p>
			</section>	
		<section id=\"three\" class=\"wrapper style2 special\">
				 <a href=\"MechanicSignin.php\"> Click here to go to your home page</a>
		</section>
	</body>
	</html>";
?>