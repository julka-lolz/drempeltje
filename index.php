<?php
include 'database.php';
include 'helper.php';

//make field falidation as extra security for sql injections.
if(isset($_POST['submit'])){

	$fieldnames = array('username', 'password');
	$helper = new helper();
	$fields_validated = $helper->field_validation($fieldnames);
	
	if($fields_validated){
				
		$db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');

		$username = $_POST['username'];
		$password = $_POST['password'];

		echo 'hallo'.'<br>';		
		$loginError = $db->login($username, $password);
	}
}

?>
<html>
	<head>
	<style>
		div{
			float: center;
			text-align: center;			
			margin-left: 40%;
			margin-right:40%;
			border-style: inset;
			background-color: white;
		}
		body{
			background-color: gray;
		}
	</style>
	</head>
	<body>    
		<div>
			<h2>log in</h2>
			<form action="index.php" method="post">
			<label for="Username"><b>Username</b><br></label>
			<input type="text" placeholder="Fill in your username" name="username" required><br><br>
			<label for="Password"><b>Password</b><br></label>
			<input type="password" placeholder="Fill in your password" name="password" required><br><br>
			<input type="submit" name="submit"><br><br>	
			<a href="signup.php"> Geen accound? Click hier en maak een nieuwe aan.</a><br>			
		</div>
	</body>
</html>