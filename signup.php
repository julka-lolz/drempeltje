﻿<?php

include 'database.php';
include 'helper.php';

//make field falidation as extra security for sql injections.
if(isset($_POST['submit'])){
	
	$fieldnames = array(
		'email', 'username', 'password', 'repassword'
	); 
	$helper = new helper();
	$fields_validated = $helper->field_validation($fieldnames);

	if($fields_validated){		

		$db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');				
		$email = $_POST["email"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$repassword = $_POST["repassword"];

		echo 'You have been succesfully signed up'."<br>";

		$db->addAccount($username,$email,$password);
	}
}
?>
<html>	
	<head>	
	</head>
		<div>
			<form action="signup.php" method="post">				
				<label for="E-mail"><b>E-mail</b><br></label>
				<input type="email" placeholder="Fill in your email" name="email" required><br><br>
				<label for="Username"><b>Username</b><br></label>
				<input type="text" placeholder="Fill in your username" name="username" required><br><br>
				<label for="Password"><b>Password</b><br></label>
				<input type="password" placeholder="Fill in your password" name="password" required><br><br>
				<label for="Repeat password"><b>Repeat password</b><br></label>
				<input type="password" placeholder="Repeat your password" name="repassword" required><br><br>   
				<input type="submit" name="submit">
		</div>
		<a href="index.php"> Terug naar inloggen</a><br>
</html>