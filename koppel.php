﻿<?php

include 'database.php';
include 'helper.php';

//make field falidation as extra security for sql injections.
if(isset($_POST['submit'])){
	echo 1;
	$fieldnames = array(
		'activiteitcode','jongerecode'
	); 
	$helper = new helper();
	$fields_validated = $helper->field_validation($fieldnames);

	if($fields_validated){	
	
		$db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');
		echo "connected";
		$activiteitcode = $_POST["activiteitcode"];
		$jongerecode = $_POST["jongerecode"];		

		echo 'New jonger is added'."<br>";

		$db->koppel($activiteitcode, $jongerecode);
	}
}
?>
<html>	
	<head>	
	</head>
		<div>
			<form action="koppel.php" method="post">
				<label for="Jongere"><b>Jongere</b><br></label>
				<input type="text" placeholder="Fill in your Jongere" name="jongerecode" required><br><br>
				<label for="activiteit"><b>Activiteit</b><br></label>
				<input type="text" placeholder="Fill in your Activiteit" name="activiteitcode" required><br><br>
				<input type="submit" name="submit">
		</div>
		<a href="welcome.php"> Back home</a><br>
</html>
