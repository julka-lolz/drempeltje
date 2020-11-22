﻿<?php

include 'database.php';
include 'helper.php';

//make field falidation as extra security for sql injections.
if(isset($_POST['submit'])){
	
	$fieldnames = array(
		'jongerecode','roepnaam', 'tussenvoegsel', 'achternaam', 'inschrijfdatum'
	); 
	$helper = new helper();
	$fields_validated = $helper->field_validation($fieldnames);

	if($fields_validated){		
		
		$db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');
		echo 'connected';
		$jongerecode = $_POST["jongerecode"];
		$roepnaam = $_POST["roepnaam"];
		$tussenvoegsel = $_POST["tussenvoegsel"];
		$achternaam = $_POST["achternaam"];
		$inschrijfdatum = $_POST["inschrijfdatum"];

		echo 'New jonger is added'."<br>";

		$db->addJonger($jongerecode, $roepnaam, $tussenvoegsel, $achternaam, $inschrijfdatum);
	}
}
?>
<html>	
	<head>	
	</head>
		<div>
			<form action="add_jongeren.php" method="post">
				<label for="jongerecode"><b>Code</b><br></label>
				<!-- TODO: ALTER DATABA -->
				<input type="text" placeholder="Fill in your code" name="jongerecode" required><br><br> 
				<label for="Name"><b>Name</b><br></label>
				<input type="text" placeholder="Fill in your name" name="roepnaam" required><br><br>
				<label for="Middlename"><b>Middlename</b><br></label>
				<input type="text" placeholder="Fill in your middlename" name="tussenvoegsel"><br><br>
				<label for="Lastname"><b>Lastname</b><br></label>
				<input type="text" placeholder="Fill in your Lastname" name="achternaam" required><br><br>
				<label for="signup date "><b>Signup date</b><br></label>
				<input type="date" placeholder="Fill in the signup date" name="inschrijfdatum" required><br><br>   
				<input type="submit" name="submit">
		</div>
		<a href="welcome.php"> Back home</a><br>
</html>
