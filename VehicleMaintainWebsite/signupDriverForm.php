<html>
<link rel="shortcut icon" type="image/ico" href="favicon.ico" />
	<head>
	<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/jquery.leanModal.min.js"></script>
		<title>Sign up</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
	
		<link rel="stylesheet" href="assets/css/main.css" /> 
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	</head>
	<body>
	<!--Header-->
	<section id="banner">
		<h2>Driver Registration</h2>
	</section>
	
	<!--Driver information -->
	<section id="dInfo" class="wrapper style2 special">
		<div class="inner narrow">
			<header>
				<h2>Please enter your personal information</h2>
			</header>
			<form  id="driverForm" method="post" action = "signupDriver.php" enctype="multipart/form-data">
			<!-- User name -->
				<div class="form-control narrow">
					<label>Name: </label>
					<input id="dName" name = "dName" type = "text" placeholder="Jane Doe">
				</div>
				<div class="form-control narrow">
					<label>Email: </label>
					<input id="dMail" name = "dMail" type = "email" placeholder="janedoe@email.com">
				
				</div>
				<div class="form-control narrow">
					<label>Password: </label>
					<input id="dPassword" name = "dPassword" type = "password">
				</div>
				<div class="form-control narrow">
					<label>Confirm Password: </label>
					<input id="dCPassword" name = "dCPassword" type = "password">
				</div>
				<div class="form-control narrow">
					<label>Phone: </label>
					<input id="dPhone" name = "dPhone" type = "tel" placeholder="123456789">
				</div>
			
		


			<header><h2>Please enter your vehicle's information</h2></header>
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
					<select name = 'serviceType' id = 'serviceType'>
					<?php
						// make all services on options
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
							// makes all options for vehicle brand
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
							// makes all options for vehicle year
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
		
	</section>
	
	<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
			<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/additional-methods.min.js"></script>
			<script>
			$(document).ready(function() {
				// form validations
				$('#driverForm').validate({
					rules:{
						dName: {
							required: true,
							minlength: 5
						},
						dMail: {
							required: true,
							email: true,
						},
						dPassword: {
							required: true
						},
						dCPassword:{
							required: true,
							equalTo: "#dPassword"
						},
						dPhone:{
							required: true,
							phoneUS: true
						},
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
				// brand auto fill script
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