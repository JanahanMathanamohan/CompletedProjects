<!DOCTYPE html>
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
		<h2>Mechanic Registration</h2>
	</section>
	
	<!--Mechanic information -->
	<section id="dInfo" class="wrapper style2 special">
		<div class="inner narrow">
			<header>
				<h2>Please enter your mechanic's information</h2>
			</header>
			<form method="post" id="mechForm" action = "signupMech.php" enctype="multipart/form-data">
			<!-- User name -->
				<div class="form-control narrow">
					<label>Name: </label>
					<input id="mName" name = "mName" type = "text" placeholder="Jane Doe">
				</div>
				<div class="form-control narrow">
					<label>Email: </label>
					<input id="mMail" name = "mMail" type = "email" placeholder="janedoe@email.com">
				
				</div>
				<div class="form-control narrow">
					<label>Password: </label>
					<input id="mPassword" name = "mPassword" type = "password">
				</div>
				<div class="form-control narrow">
					<label>Confirm Password: </label>
					<input id="mCPassword" name = "mCPassowrd" type = "password">
				</div>
				<div class="form-control narrow">
					<label>Phone: </label>
					<input id="mPhone" name = "mPhone" type = "tel" placeholder="123456789">
				</div>
				<div class="form-control narrow">
					<label>Address: </label>
					<input id="mLoc" name = "mLoc" type = "text" placeholder="123 First Street">
				</div>
				<div class="form-control narrow">
					<label>City: </label>
					<input id="mCity" name = "mCity" type = "text" placeholder="123 First Street">
				</div>
				<div class="form-control narrow">
					<label>Company: </label>
					<input id="mCo" name = "mCo" type = "text" placeholder="Autoshop LTD.">
				</div>


				<div>
				<header><h2>Please enter the following information regarding vehicle services</h2></header>
					<!--Service entering table -->

					<label>Service Type, Price, and Length (in hours): </label>
					<table >
					<tr>
					<td > <h6 value="sOil">Standard Oil Change</h6> </td>
					<td > <input style="width: 150px" id="soilPrice" name = "soilPrice" type = "number"  placeholder="25.99"> </td>
					<td > <input id="soilLength" name = "soilLength" type = "number" placeholder="2"> </td>
					</tr>
					<tr>
					<td> <h6 value="synOil">Synthetic Blend Oil Change </h6></td>
					<td> <input style="width: 150px" id="synoilPrice" name = "synoilPrice" type = "number"  placeholder="25.99"> </td>
					<td> <input id="synoilLength" name = "synoilLength" type = "number" placeholder="2"> </td>
					</tr>
					<tr>
					<td><h6 value="fSynOil">Full Synthetic Oil Change</h6></td>
					<td> <input style="width: 150px" id="fsynoilPrice" name = "fsynoilPrice" type = "number"  placeholder="25.99"> </td>
					<td> <input id="fsynoilLength" name = "fsynoilLength" type = "number" placeholder="2"> </td>
					</tr>
					<tr>
					<td><h6 value="alignment">Tire Alignment</h6></td>
					<td > <input style="width: 150px" id="alignPrice" name = "alignPrice" type = "number"  placeholder="25.99"> </td>
					<td > <input id="alignLength" name = "alignLength" type = "number" placeholder="2"> </td>
					</tr>
					<tr>
					<td><h6 value="Brake">Brake Service</h6></td>
					<td > <input style="width: 150px" id="brakePrice" name = "brakePrice" type = "number"  placeholder="25.99"> </td>
					<td > <input id="brakeLength" name = "brakeLength" type = "number" placeholder="2"> </td>
					</tr>
					<tr>
					<td><h6 value="filter">Fuel Filter Service</h6></td>
					<td > <input style="width: 150px" id="FFSPrice" name = "FFSPrice" type = "number"  placeholder="25.99"> </td>
					<td > <input id="FFSLength" name = "FFSLength" type = "number" placeholder="2"> </td>
					</tr>
					<tr>
					<td><h6 value="sparkplug">Spark Plug Service</h6></td>
					<td > <input style="width: 150px" id="SPSPrice" name = "SPSPrice" type = "number"  placeholder="25.99"> </td>
					<td > <input id="SPSLength" name = "SPSLength" type = "number" placeholder="2"> </td>
					</tr>
					</table>
	
				<br>
				<ul class="actions">
				<li><input value="Submit" type="submit"></li>
				</ul>
				</div>
			</form>
	</section>
	</div>
	
<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
			<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/additional-methods.min.js"></script>>
			<script>
			$(document).ready(function() {
				// Validation for the forms
				$('#mechForm').validate({
					rules:{
						mName: {
							required: true,
							minlength: 5
						},
						mMail: {
							required: true,
							email: true
						},
						mPassword: {
							required: true
						},
						mCPassword:{
							required: true,
							equalTo: "#dPassword"
						},
						mPhone:{
							required: true,
							phoneUS: true
						},
						mLoc:{
							required: true
						},
						mCity:{
							required: true
						},
						mCo:{
							required: true
						},
						soilPrice: {
							required: true,
							number: true		
						},
						soilLength: {
							required: true,
							number: true
						},
						synoilPrice: {
							required: true,
							number: true		
						},
						synoilLength: {
							required: true,
							number: true
						},
						fsynoilPrice: {
							required: true,
							number: true		
						},
						fsynoilLength: {
							required: true,
							number: true
						},
						alignPrice: {
							required: true,
							number: true		
						},
						alignLength: {
							required: true,
							number: true
						},
						brakePrice: {
							required: true,
							number: true		
						},
						brakeLength: {
							required: true,
							number: true
						},
						FFSPrice: {
							required: true,
							number: true		
						},
						FFSLength: {
							required: true,
							number: true
						},
						SPSPrice: {
							required: true,
							number: true		
						},
						SPSLength: {
							required: true,
							number: true
						}

					}

				});
			});
			
			</script>
</html>