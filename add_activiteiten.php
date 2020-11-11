﻿<?php

include 'database.php';
include 'helper.php';

//make field falidation as extra security for sql injections.
if(isset($_POST['submit'])){
	
	$fieldnames = array(
		'activiteitcode','activiteit'
	); 
	$helper = new helper();
	$fields_validated = $helper->field_validation($fieldnames);

	if($fields_validated){	
	
		$db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');
		echo "connected";
		$activiteitcode = $_POST["activiteitcode"];
		$activiteit = $_POST["activiteit"];		

		echo 'New jonger is added'."<br>";

		$db->addActiviteit($activiteitcode, $activiteit);
	}
}
?>
<html>	
	<head>	
	</head>
		<div>
			<form action="add_activiteiten.php" method="post">
				<label for="activiteitcode"><b>Code</b><br></label>
				<input type="text" placeholder="Fill in your code" name="activiteitcode" required><br><br>
				<label for="activiteit"><b>Activiteit</b><br></label>
				<input type="text" placeholder="Fill in your activiteit" name="activiteit" required><br><br>
				<input type="submit" name="submit">
		</div>
		<a href="welcome.php"> Back home</a><br>
</html>
