<!--connecting to database-->
<?php
	$conn = mysql_connect('localhost','root','');
	mysql_select_db('VehicleMain',$conn);
?>