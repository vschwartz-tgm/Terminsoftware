<?php
	include ("functions.php");	
	
	// Registrierung durchführen
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])){
		$uname = $_POST['uname'];
		$email = $_POST['email'];
		$psw = $_POST['psw'];
		$pswrepeat = $_POST['psw-repeat'];
		
		$l = new RegisterUser($uname, $email, $psw, $pswrepeat);
		$l->execute();
	}
?>

<html>
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="bootstrap/js/bootstrap.min.js">
		<link href="signUp_CSS.css" rel="stylesheet">
		<link rel="icon" href="kalender.jpg">
		<script src="/node_modules/angular/angular.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<title>Terminreservierung</title>
	</head>
	<body>
		<form action="" method="post" style="border:1px solid #ccc">
		  <div class="container">
			<h1>Sign Up</h1>
			<hr />
			
			<label for="uname"><b>Username</b></label>
			<input type="text" placeholder="Enter Username" name="uname" id="uname" required />

			<label for="email"><b>Email</b></label>
			<input type="text" placeholder="Enter Email" name="email" id="email" required />

			<label for="psw"><b>Password</b></label>
			<input type="password" placeholder="Enter Password" name="psw" id="psw" required />

			<label for="psw-repeat"><b>Repeat Password</b></label>
			<input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>

			<p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>
			  
			<div class="clearfix">
				<button type="button" class="cancelbtn" onclick ="window.location = 'login.php'">Cancel</button>
				<button type="submit" class="signupbtn" name="submit">Sign Up</button>
			</div>
		  </div>
		</form>
	</body>
</html>


<?php
	/*
	$host ="ec2-23-23-247-245.compute-1.amazonaws.com";
	$user = "xokkwplhovrges";
	$password ="56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d";
	$dbname = "de8h555uj0b1mq";
	$port = "5432";

	$db = parse_url(getenv("DATABASE_URL"));
	$db["path"] = ltrim($db["path"], "/");
	$conn = pg_connect(getenv("DATABASE_URL"));
	
	if($_POST){
	$sql = 'SELECT * FROM users';

	echo "<script type='text/javascript'>alert('$sql');</script>";
	}
	*/

	/*if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])){
		$uname = $_POST['uname'];
		$email = $_POST['email'];
		$psw = $_POST['psw'];
		$pswrepeat = $_POST['psw-repeat'];
		register($uname, $email, $psw, $pswrepeat);
	}*/
	
	/*
	function register($uname, $email, $psw, $pswrepeat){
		$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		$fehler = false; 
		
		// Uname schon vorhanden?
		$slct = "SELECT COUNT(*) FROM users WHERE name = '".$uname."';"; 
		$sql = pg_query($dbconn, $slct); 
		$row = pg_fetch_row($sql); 
		if($row[0] > 0) { 
			$fehler = true;
			echo "<script type='text/javascript'>alert('Dieser User existiert bereits!');</script>";
		}
		
		// Email schon vorhanden?
		if ($fehler == false){
			$sql = "SELECT COUNT(*) FROM users WHERE email = '".$email."';"; 
			$sql = pg_query($dbconn, $sql);
			$row = pg_fetch_row($sql);
			if($row[0] > 0) { 
				$fehler = true;
				echo "<script type='text/javascript'>alert('Diese Email hat bereits einen Account!');</script>";
			}
		}
		
		// Email möglich?
		if ($fehler == false){
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				// Kein Fehler
			} else {
				$fehler = true;
				echo "<script type='text/javascript'>alert('Ungültige Emailadresse!');</script>";
			}
		}
		
		// Passwörter gleich?
		if ($fehler == false){
			if ($psw != $pswrepeat){
				echo "<script type='text/javascript'>alert('Passwörter stimmen nicht überein!');</script>";
				$fehler = true; 
			}
		}
		
		// Bei keinem Fehler, Account erstellen und auf login Seite ändern
		if ($fehler == false){
			$insert = "INSERT INTO users(name,email,pw) VALUES('$uname','$email','$psw');";
			$i = pg_query($dbconn, $insert);
			header("Location: index.php");
		}
	}*/
/*
	Erstellen der Tabellen (FUNKTIONIERT)

	$sql = "create table passwd (pwd varchar(255));";
	$r = pg_query($dbconn, $sql);

	$tbls = "select * from information_schema.tables";
	$qr = pg_query($dbconn, $tbls);
	while($r = pg_fetch_array($qr)) {
		echo "<script type='text/javascript'>alert('$r');</script>";
	}
*/
/*
	Funktioniert lokal aber nicht mit Heroku da schreibrechte Fehlen.
	 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
		{
			saveData();
		}

	function saveData(){
		$file = '/home/christoph/Documents/text.txt';
		// Öffnet die Datei, um den vorhandenen Inhalt zu laden
		$current = file_get_contents($file);
		$myfile = 'login.txt';
		$txt = 	$_POST['uname'];
		file_put_contents($file, $txt);
		echo "<script type='text/javascript'>alert('$current');</script>";
	}
*/
?>