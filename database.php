<?php

class database{

	private $host;
	private $username;
	private $password;
	private $database;
	private $charset;
	private $db;

	//create function construct
	public function __construct($host,$username,$password,$database,$charset){

		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
		$this->charset = $charset;	

		try{
			// connectie with database			
			$dsn = "mysql:host=$this->host;dbname=$this->database;charset=$this->charset";
			$this->db = new PDO($dsn, $this->username, $this->password);
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			echo 'Succesfully connected to the database'."<br>";
		}	// catch error
		catch (PDOexception $a){			
			$this->db->rollback();
			echo "Signup has failed: ".$a->getMessage();
			throw $a;
			
		}
	}

	//make a function to add a Account
	public function addAccount($username,$email,$password){
	
		try{
			//begin the transaction
			$this->db->beginTransaction();
			echo "Beginning the transaction"."<br>";
			//add account
			$sql = "INSERT INTO account(id, username, email, password, created_at, updated_at ) 
				VALUES(:id, :username, :email, :password, :created_at, :updated_at)";
			echo "sql statement: ".$sql."<br>";
			//prepare
			$stmt = $this->db->prepare($sql);
			//hash the password
			$hashPassword = password_hash($password, PASSWORD_DEFAULT);
			//execute 
			$stmt->execute([
			'id' => NULL,
			'email'=>$email,			
			'username'=>$username,
			'password'=>$hashPassword,
			'created_at'=>date("Y-m-d H:i:s"),
			'updated_at'=>date("Y-m-d H:i:s")
			]);
			$this->db->commit();
			echo "Account is added";
		}
		catch (PDOexception $a){			
			$this->db->rollback();
			echo "Signup failed: ".$a->getMessage();
			throw $a;
			
		}
	}

	//make a function to check if the account already exists as security.
	private function new_account($username){
				
		$stmt = $this->db->prepare('SELECT * FROM account WHERE username=:username');
		$stmt->execute(['username'=>$username]);
		$result = $stmt->fetch();
		//the if loop checks if the account exists
		if(is_array($result) && count($result) > 0){
			return false;//does exists
		}
		return true;//does not exist
	}

	//make a login function.
	public function login($username, $password){
		
		$sql = "
			SELECT 
				account.id as account_id,				 
				account.password 
			FROM account			
			WHERE username = :username
		";
		echo $sql;
		//prepare
		$stmt = $this->db->prepare($sql);
		//execute
		$stmt->execute(['username'=>$username]);
		//feth the executed code this should only return an associative array because we are using :FETCH_ASSOC.
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		//CHECK IF $result is an array
		if(is_array($result)){
			
			if(count($result) > 0){
				
				$hashed_password = $result['password'];
				var_dump( password_verify($password, $hashed_password));

				// verify if user exists and that given password is the same as the hashed password.
				if($username && password_verify($password, $hashed_password)){
					
					//start the session
					session_start();

					//store the userdata in session variable
					$_SESSION['account_id'] = $result['account_id'];
					$_SESSION['username'] = $username;
					$_SESSION['loggedin'] = true;

					//after the user will be logged in this page will show 
					header("location: welcome.php");						
					exit;

				}else{
					
					return "Incorrect username and/or password. Please change your input and try again.";
				}
			}
		}else{
			// no matching user found in db. Make sure not to tell the user directly.
			return "Failed to login. Please try again";
		}
	}

		//make a function to add a Account
	public function addJonger($jongerecode,$roepnaam,$tussenvoegsel,$achternaam,$inschrijfdatum){
	
		try{
			//begin the transaction
			$this->db->beginTransaction();
			echo "Beginning the transaction"."<br>";
			//add account
			$sql = "INSERT INTO jongere(jongerecode, roepnaam, tussenvoegsel, achternaam, inschrijfdatum) 
				VALUES(:jongerecode, :roepnaam, :tussenvoegsel, :achternaam, :inschrijfdatum)";
			echo "sql statement: ".$sql."<br>";
			//prepare
			$stmt = $this->db->prepare($sql);			
			//execute 			
			$stmt->execute([
			'jongerecode' => $jongerecode,
			'roepnaam'=>$roepnaam,			
			'tussenvoegsel'=>$tussenvoegsel,
			'achternaam'=>$achternaam,
			'inschrijfdatum'=>date("Y-m-d H:i:s")
			]);
			
			$this->db->commit();
			echo "Jonger is added";
			header("location: welcome.php");
		}
		catch (PDOexception $a){			
			$this->db->rollback();
			echo "Signup failed: ".$a->getMessage();
			throw $a;
			
		}
	}

	public function updateJonger($jongerecode, $roepnaam, $tussenvoegsel, $achternaam, $inschrijfdatum){
	
		try{
			//begin the transaction
			$this->db->beginTransaction();
			echo "Beginning the transaction"."<br>";			
			$sql = "UPDATE jongere SET jongerecode=:jongerecode, roepnaam=:roepnaam, tussenvoegsel=:tussenvoegsel, achternaam=:achternaam, inschrijfdatum=:inschrijfdatum";
			echo "sql statement: ".$sql."<br>";
			//prepare
			$stmt = $this->db->prepare($sql);			
			//execute 			
			$stmt->execute([
			'jongerecode'=>$jongerecode,
			'roepnaam'=>$roepnaam,			
			'tussenvoegsel'=>$tussenvoegsel,
			'achternaam'=>$achternaam,
			'inschrijfdatum'=>date("Y-m-d H:i:s")
			]);
			
			$this->db->commit();
			echo "Jonger is updated";
			header("location: welcome.php");
		}
		catch (PDOexception $a){			
			$this->db->rollback();
			echo "Signup failed: ".$a->getMessage();
			throw $a;
			
		}
	}

	public function updateActiviteit($activiteitcode, $activiteitnaam){
	
		try{
			//begin the transaction
			$this->db->beginTransaction();
			echo "Beginning the transaction"."<br>";			
			$sql = "UPDATE activiteit SET activiteitcode=:activiteitcode, activiteitnaam=:activiteitnaam";
			echo "sql statement: ".$sql."<br>";
			//prepare
			$stmt = $this->db->prepare($sql);			
			//execute 			
			$stmt->execute([
			'activiteitcode'=>$activiteitcode,
			'activiteitnaam'=>$activiteitnaam			
			]);
			
			$this->db->commit();
			echo "Activiteit is updated";
			header("location: welcome.php");
		}
		catch (PDOexception $a){			
			$this->db->rollback();
			echo "Signup failed: ".$a->getMessage();
			throw $a;
			
		}
	}



	public function addActiviteit($activiteitcode, $activiteitnaam){
	
		try{
			//begin the transaction
			$this->db->beginTransaction();
			echo "Beginning the transaction"."<br>";
			//add account
			$sql = "INSERT INTO activiteit(activiteitcode, activiteitnaam) 
				VALUES(:activiteitcode, :activiteitnaam)";
			echo "sql statement: ".$sql."<br>";
			//prepare
			$stmt = $this->db->prepare($sql);			
			//execute 
			//watch out the inschrijfdatum is by default the time you will add the new jonger.
			$stmt->execute([
			'activiteitcode' => $activiteitcode,
			'activiteitnaam'=>$activiteitnaam
			]);

			$this->db->commit();
			echo "Activiteit is added";
			//header("location: welcome.php");
		}
		catch (PDOexception $a){			
			$this->db->rollback();
			echo "Signup failed: ".$a->getMessage();
			throw $a;
			
		}
	}
	
	public function koppel($activiteitcode, $jongerecode){
	
		try{
			//begin the transaction
			$this->db->beginTransaction();
			echo "Beginning the transaction"."<br>";
			//add account
			$sql = "INSERT INTO koppel(koppelcode, activiteitcode, jongerecode) 
				VALUES(:koppelcode, :activiteitcode, :jongerecode)";
			echo "sql statement: ".$sql."<br>";
			//prepare
			$stmt = $this->db->prepare($sql);	
			$koppelcode = $this->db->lastInsertId();
			//execute 
			//watch out the inschrijfdatum is by default the time you will add the new jonger.
			$stmt->execute([
			'koppelcode' => $koppelcode,
			'activiteitcode' => $activiteitcode,
			'jongerecode'=>$jongerecode
			]);

			$this->db->commit();
			echo "Assigned Activiteit";
			//header("location: welcome.php");
		}
		catch (PDOexception $a){			
			$this->db->rollback();
			echo "Signup failed: ".$a->getMessage();
			throw $a;
			
		}
	}
	public function get_jongere_information($jongerecode){
		$sql = "SELECT jongerecode FROM jongere	";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(['jongerecode'=>$jongerecode]);		
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}

	public function get_activiteit_information($activiteitcode){
		$sql = "SELECT activiteitcode FROM activiteit";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(['activiteitcode'=>$activiteitcode]);		
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}

	public function get_overzicht_information($activiteitcode){
		$sql = "SELECT 
					a.activiteitnaam,j.* 
				FROM 
					koppel as k 
				INNER join activiteit as a 
				on a.activiteitcode=k.activiteitcode 
				inner join jongere as j 
				on j.jongerecode=k.jongerecode";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(['activiteitcode'=>$activiteitcode]);		
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}

	public function get_koppel_information($activiteitcode, $jongerecode){
		$sql = "SELECT * FROM koppel";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([
		'activiteitcode'=>$activiteitcode,
		'jongerecode'=>$jongerecode
		]);
		
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}

	public function deleteJongere($jongerecode){
	
		try{
			$this->db->beginTransaction();

			$stmt = $this->db->prepare("DELETE FROM jongere WHERE jongerecode=:jongerecode");
			$stmt->execute([
			'jongerecode'=>$jongerecode
			]);			

			$this->db->commit();

		}catch(PDOexception $e){
			$this->db->rollback();
			echo 'Error: '.$e->getMessage();
		}
	}

	public function deleteActiviteit($activiteitcode){
	
		try{
			$this->db->beginTransaction();		

			$stmt1 = $this->db->prepare("DELETE FROM activiteit WHERE activiteitcode=:activiteitcode");
			$stmt1->execute([
			'activiteitcode'=>$activiteitcode
			]);

			$this->db->commit();

		}catch(PDOexception $e){
			$this->db->rollback();
			echo 'Error: '.$e->getMessage();
		}
	}
	
}
?>