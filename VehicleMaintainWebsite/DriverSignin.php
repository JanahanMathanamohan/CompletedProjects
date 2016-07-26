<!--Connect to database-->
<?php require_once('../config.php') ?>
<html>
<link rel="shortcut icon" type="image/ico" href="favicon.ico" />
	<?php
		// Redirect if user is not suppose to come
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
	?>
	<head>
	<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/jquery.leanModal.min.js"></script>
		<title>Welcome!</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
	
		<link rel="stylesheet" href="assets/css/main.css" /> 
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	</head>
	<body>
	<!--Header-->
	<section id="banner">
		<?php
			// query and outputs the name
			$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
			$sql = "SELECT Driver_Name FROM driver WHERE Driver_Id = $id";
			$result = mysql_query($sql,$conn) or die(mysql_error());
			$row = mysql_fetch_array($result);
			$name = $row['Driver_Name'];
			echo "<h2>Welcome, $name!</h2>";
		?>
		
	</section>
	
	<!--Odometer-->
	<section id="dInfo" class="wrapper style2 special">
		<div class="inner narrow">
			<header>
				<h2>Update your odometer readings, if needed, below: </h2>
			</header>
			
			<form method="post" action = "updateOdometer.php">
				<div class="form-control narrow">
					<label>New Odometer Reading: </label>
					<select id="VehicleId" name = "VehicleId">
						<?php
							// retrieve and output list of cars owned by user
							session_start();
							$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
							$sql="	SELECT Vehicle_Id,Vehicle_No,Odometer_Reading
									FROM Vehicle
									WHERE Driver_Id = $id;
							";
							$result=mysql_query($sql,$conn) or die(mysql_error());
							while ($row = mysql_fetch_array($result)){
								$VID =$row['Vehicle_Id'];
								$VNO =$row['Vehicle_No'];
								$Vodo = $row['Odometer_Reading'];
    							echo "<option value=\"$VID\">$VNO </option>";
							}
						?>	
						</select>
					<input id="newKM" name = "newKM" type = "number" placeholder=800000>
					<ul class="actions">
					<li><input value="Submit" type="submit"></li>
					</ul>					
				</div>
			</form>
			<br>

		</div>
		<!--Change mechanic default-->
		<div class="inner narrow">
			<header>
				<h2>Favourite Mechanic</h2>
			</header>
			<form method="post" action = "updateMechanic.php">
			<!-- User name -->
				<div class="form-control narrow">
					<label>Change Mechanic:Current is 
					<?php
						// Get current default mechanic
						$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
						$sql = "SELECT Mechanic_Id FROM driver WHERE Driver_Id = $id";
						$result=mysql_query($sql,$conn) or die(mysql_error());
						while ($row = mysql_fetch_array($result)){
							$mechanic = $row['Mechanic_Id'];
							echo "$mechanic </label>";
						}

					?>
					<select id="MechanicId" name = "MechanicId">
						<?php
							// get all avaliable mechanics 
							$sql="	SELECT Mechanic_Id,Mechanic_Name
									FROM mechanic
							";
							$result=mysql_query($sql,$conn) or die(mysql_error());
							// make the tables
							while ($row = mysql_fetch_array($result)){
								$MID =$row['Mechanic_Id'];
								$Mname =$row['Mechanic_Name'];
    							echo "<option value=\"$MID\">$Mname($MID) </option>";
							}
						?>	
						</select>
					<ul class="actions">

						<li><input value="Submit" type="submit">;
				
					</ul>					
				</div>
			</form>
			<br>

		</div>
		<!-- Vehilcle addition form -->
		<div class="inner narrow">
			<header><h2>Add a new Vehicle, if necessary</h2></header>
				<form id="vehicleForm" method="post" action = "addVehicleValidation.php" enctype="multipart/form-data">
					<div class="form-control narrow">
					<label>VIN: </label>
					<input id="VID" name = "VID" type = "text" placeholder="ABCDEFGH123456789">
				</div>
				<div class="form-control narrow">
					<label>License plate: </label>
					<input id="VLicense" name = "VLicense" type = "text" placeholder="13H4 3V5">
				</div>
				<div class="form-control narrow">
					<label>Last Service: </label>
					<input id="VDate" name = "VDate" type = "date" placeholder="">
				</div>
				<div class="form-control narrow">
					<label>Last Service Type: </label>
					<select name="serviceType" id="serviceType" >
					<?php
						// load in services from xml as options
						$xml = simplexml_load_file('Services.xml');
						foreach ($xml->Service as $item)
						{
								echo "<option value='".$item ."'>" . $item."</option>";
						}
					?>
					</select>				
				</div>
				<br>
				<br>
				<div class="form-control narrow">
					<label>Vehicle Brand, Model, and Year</label>
					<select name="brand" id="brand">
						<?php
							// load in brands from an xml as options
							$xml = simplexml_load_file('brand.xml');
							foreach ($xml->option as $item)
							{
   								echo "<option value='".$item ."'>" . $item."</option>";
							}
						?>
					</select>
					<select name="model" id="model">
						<option value="Supra">Supra</option>
						<option value = "Camary">Camary</option>");
						<option value = "Corolla">Corolla</option>");
					</select>
					<select name="year" id="year">
						<?php
							// load in years from an xml as options
							$xml = simplexml_load_file('year.xml');
							foreach ($xml->option as $item)
							{
   								echo "<option value='".$item ."'>" . $item."</option>";
							}
						?>
					</select>
				</div>
				<div class="form-control narrow">
					<label>Odometer Reading, and Average Daily KM Driven</label>
					<input id="VOdo" name = "VOdo" type = "number" placeholder="Odometer">
					<input id="VAverage" name = "VAverage" type = "number" placeholder="Average">
				</div>
				<br>
				<br>
				<ul class="actions">
					<li><input value="Submit" type="submit"></li>
				</ul>
				</form>
		</div>

		<!--Vehicle service rable-->	
		<div class="inner narrow">
			<header><h2>Vehicle Service Table</h2></header>
			<div class="table-wrapper">
				<table  >
					<thead>
						<tr>
							<th>Vehicle</th>
							<th>Odometer Reading</th>
							<th>Service Type</th>
							<th>Date of Last Service</th>
							<th>Date of Next Service</th>
							<th>View Full Service History of</th>
						</tr>
					</thead>
					<tbody>
						<?php
							// query to make the tables and forms for each vehicle
							$id = (is_numeric($_SESSION["user"]) ? (int)$_SESSION["user"] : 0);
							$sql="	SELECT Vehicle_Id,Vehicle_No,Odometer_Reading,service_Type,Last_Service,Next_Service
									FROM Vehicle
									WHERE Driver_Id = $id;
							";
							$result=mysql_query($sql,$conn) or die(mysql_error());
							while ($row = mysql_fetch_array($result)){
								$VID =$row['Vehicle_Id'];
								$VNO =$row['Vehicle_No'];
								$Vodo = $row['Odometer_Reading'];
								$service = $row['service_Type'];
								$Lservice =$row['Last_Service'];
								$Nservice= $row['Next_Service'];
    							echo "	<form method=\"post\" action = \"viewSerivce.php\" enctype=\"multipart/form-data\">
    									<tr>
    									<td >$VNO</td>
										<td>$Vodo</td>
										<td>$service</td>
										<td>$Lservice</td>
										<td>$Nservice</td>
										<td><ul class=\"actions\">
												<li><input id='submit' type='submit' name = 'submit' value = $VID></li>
											</ul>
										</td>
										</tr>
										</form>
									";
    									
							}		
						?>
					</tbody>
				</table>
				<br>
				<!--Link to see all vehicle services-->
				<ul class="actions">
					<h2><a href="viewAllVehicleServices.php">Detailed Vehicle Service</a></h2>
					<h2><a href="MechCar.php">View All Cars and Mechanics Used</a></h2>
				</ul>
			</div>
		</div>
	
	<!-- View Services -->
		<div class="inner narrow">
			<header><h2>Service Info</h2><header>
			<form id="typeService" method="post" action = "Services.php" enctype="multipart/form-data">
			<div class="form-control narrow">
				<input id="city" name = "city" type = "text" placeholder="Enter the City you are in">
				<select name = "type" id = "type">
					<option value = 2> Below Average Time </option>
					<option value = 1> Below Average Price </option>
					<option value = 3> All </option>
				</select>
				<select name="serviceType" id="serviceType">
					<?php
						// get all service options
						$xml = simplexml_load_file('Services.xml');
						foreach ($xml->Service as $item)
						{
								echo "<option value='".$item ."'>" . $item."</option>";
						}
					?>
				</select>
				<br>
				<ul class="actions">
					<li><input value="View Info" type="submit"></li>
				</ul>
				</div>
			</form>
		</div>
		<!--Mechanic Info sections -->
		<div class="inner narrow">
			<header><h2>Mechanic Info</h2></header>
			<form id="cityMech" method="post" action = "cityMech.php" enctype="multipart/form-data">
				<div class="form-control narrow">
				<header><h3>Mechanics in Your City and Car Experience</h3></header>
				<input id="city" name = "city" type = "text" placeholder="Enter the City you are in">
				<ul class="actions">
					<li><input value="View Info" type="submit"></li>
				</ul>
			</div>
			</form>			
			<form id="experience" method="post" action = "experienceMech.php" enctype="multipart/form-data">
				<div class="form-control narrow">
				<header><h3>Mechanics Brand Experience</h3></header>
				<input id="city" name = "city" type = "text" placeholder="Enter the City you are in">
				<select name="brand" id="brand">
						<?php
							// query to get all the brands and populate the options
							$xml = simplexml_load_file('brand.xml');
							foreach ($xml->option as $item)
							{
   								echo "<option value='".$item ."'>" . $item."</option>";
							}
						?>
				</select>
				<ul class="actions">
					<li><input value="View Info" type="submit"></li>
				</ul>
			</div>
			</form>
		</div>
		<header><h2><a href="Logout.php">Logout</a></h2></header>
		<br>
		<br>
	</section>
	<!-- Footer -->
			<footer id="footer">
				<div class="copyright">
					&copy; Untitled. Design: <a href="http://templated.co/">TEMPLATED</a>.
				</div>
			</footer>
	<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
			<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/additional-methods.min.js"></script>>
			<script>
			$(document).ready(function() {
				// validation script for all the forms
				$('#vehicleForm').validate({
					rules:{
						VID: {
							required: true,
							minlength: 17,
							maxlength: 17
						},
						VDate: {
							required: true
						},
						VLicense: {
							required: true,
							minlength: 8,
							maxlength: 8
						},
						VOdo: {
							required: true
						},
						VAverage: {
							required: true
						},
						serviceType: {
							required: true
						}
					}

				});
				$('#typeService').validate({
					rules:{
						city: {
							required: true
						},
						serviceType: {
							required: true
						},
						type: {
							required: true
						}
					}

				});
				$('#experience').validate({
					rules:{
						city: {
							required: true
						},
						brand: {
							required: true
						}
					}

				});
				$('#cityMech').validate({
					rules:{
						city: {
							required: true
						}
					}

				});	
				// script to change the value of models depending on brands
				$("#brand").change(function() {
					var op = $(this);
					$("#model option:last-child").remove();
					$("#model option:last-child").remove();
					$("#model option:last-child").remove();
					$("#model option:last-child").remove();
					if(op.val() === "Toyota" ) {
						$("#model").append("<option value = \"Supra\" >Supra</option>");
						$("#model").append("<option value = \"Camary\">Camary</option>");
						$("#model").append("<option value = \"Corolla\">Eclipse</option>");
					}
					else if(op.val() === "Subaru" ) {
						$("#model").append("<option value = \"WRX-STI\">WRX STI</option>");
						$("#model").append("<option value = \"BRZ\">BRZ</option>");	
					}
					else if(op.val() === "Dodge" ) {
						$("#model").append("<option value = \"RAM\">RAM</option>");
						$("#model").append("<option value = \"Viper\">Viper</option>");
					}
					else if(op.val() === "Saturn" ) {
						$("#model").append("<option value = \"Vue\">Vue</option>");
					}
					else if(op.val() === "Ford" ) {
						$("#model").append("<option value = \"Focus\">Focus</option>");
						$("#model").append("<option value = \"Fiesta\">Fiesta</option>");
					}
					else if(op.val() === "Chevrolet" ) {
						$("#model").append("<option value = \"Camaro\">Camaro</option>");
					}
					else if(op.val() === "GMC" ) {
						$("#model").append("<option value = \"Sierra\">Sierra</option>");
					}
					else if(op.val() === "Honda" ) {
						$("#model").append("<option value = \"Civic\">Civic</option>");
					}
					else if(op.val() === "Hyundai" ) {
						$("#model").append("<option value = \"Sonata\">Sonata</option>");
					}
					else if(op.val() === "Lincoln" ) {
						$("#model").append("<option value = \"MKC\">MKC</option>");
					}
					else if(op.val() === "Mitsubishi" ) {
						$("#model").append("<option value = \"Eclipse\">Eclipse</option>");
						$("#model").append("<option value = \"Lancer\">Lancer</option>");
					}
					else if(op.val() === "Lexus" ) {
						$("#model").append("<option value = \"RC-350\">RC 350</option>");
					}
					else if(op.val() === "Jaguar" ) {
						$("#model").append("<option value = \"XKR\">XKR</option>");
					}
					else if(op.val() === "BMW" ) {
						$("#model").append("<option value = \"M3-GTR\">M3 GTR</option>");
					}
					else if(op.val() === "Volkswagon" ) {
						$("#model").append("<option value = \"Beetle\">Beetle</option>");
					}
				});
			
			});
			
			</script>
</html>