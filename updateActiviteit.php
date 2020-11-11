﻿<?php

include 'database.php';
include 'helper.php';

//make field falidation as extra security for sql injections.
if(isset($_POST['submit'])){
	
	$fieldnames = array(
		'activiteitcode','activiteitnaam'
	); 
	$helper = new helper();
	$fields_validated = $helper->field_validation($fieldnames);

	if($fields_validated){	
		
		$db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');
		echo 'connected';
		$activiteitcode = $_POST["activiteitcode"];
		$activiteitnaam = $_POST["activiteitnaam"];
		

		echo 'Current activiteit is updated'."<br>";

		$db->updateActiviteit($activiteitcode, $activiteitnaam);
	}
}
?>
<html>	
	<head>	
	</head>
		<div>
			<form action="updateActiviteit.php" method="post">				
				<label for="activiteitcode"><b>Code</b><br></label>
				<input type="text" placeholder="Fill in your code" name="activiteitcode" value="<?php echo isset($_GET['activiteitcode']) ? $_GET['activiteitcode'] : '' ; ?> "><br><br>
				<label for="activiteitnaam"><b>Activiteitnaam</b><br></label>
				<input type="text" placeholder="Fill in your activiteitnaam" name="activiteitnaam"><br><br>				
				<input type="submit" name="submit">
		</div>
		<a href="welcome.php"> Back home</a><br>
</html>
