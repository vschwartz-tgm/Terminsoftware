<?php
	include ("functions.php");
	
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])){
		$uname = $_POST['uname'];
		$psw = $_POST['psw'];
		
		$l = new LoginUser($uname, $psw);
		$l->execute();
	}
?>

<html>
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="bootstrap/js/bootstrap.min.js">
		<link href="login_CSS.css" rel="stylesheet">
		<link rel="icon" href="kalender.jpg">
		<title>Terminreservierung</title>
	</head>
	<body>
		<form action="" method="post" style="border:1px solid #ccc">
		  <div class="container">
			<h1>Login</h1>&nbsp;&nbsp;&nbsp;
			<a href="signUp.php"><h1>Sign Up</h1></a>
			<hr>
			
			<label for="uname"><b>Username</b></label>
			<input type="text" placeholder="Enter Username" name="uname" required />

			<label for="psw"><b>Password</b></label>
			<input type="password" placeholder="Enter Password" name="psw" required />

			<button type="submit" class="loginbtn" name="submit">Login</button>
			<label>
			  <input type="checkbox" checked="checked" name="remember"> Remember me
			</label>
		  </div>

		  <div class="container" style="background-color:#f1f1f1" align="center">
			<span class="psw">Forgot <a href="#">password?</a></span>
		  </div>
		</form>
	</body>
</html>

<?php
	/*
	function login($uname, $psw){
		$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		$fehler = false; 
		
		// Gibt es diesen User?
		$slct = "SELECT COUNT(*) FROM users WHERE uname = '".$uname."';"; 
		$sql = pg_query($dbconn, $slct); 
		$row = pg_fetch_row($sql); 
		if($row[0] <= 0) {
			$fehler = true;
		}
		
		// Ist das Passwort richtig für den Benutzer?
		if ($fehler == false){
			$pwdselect = "SELECT passwd FROM users WHERE uname = '".$uname."';"; 
			$sql = pg_query($dbconn, $pwdselect); 
			$row = pg_fetch_row($sql); 
			if ($psw != $row[0]){
				$fehler = true;
			}
		}
		
		// Fehler?
		if ($fehler == true){
			echo "<script type='text/javascript'>alert('Benutzername oder Passwort ist falsch!');</script>";
		}else{
			// Zur nächsten Seite
			session_start();
			$_SESSION['uname'] = $uname; // Eigentlich die ID
			header("Location: terminreservierung.php");
		}
	}
	*/
	
	/*
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
		{
			
		$uname = $_POST['uname'];
		$psw = $_POST['psw'];
		$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");


		$getUname = "SELECT uname FROM users WHERE uname = '$uname';";
		$getPsw = "SELECT passwd FROM users WHERE passwd = '$passwd';";
			
		$s = pg_query($dbconn, $getUname);
		if($getUname == $uname){
			echo "<script type='text/javascript'>alert('success');</script>";
		}
		$i = pg_query($dbconn, $insert);
			
		
	}
	*/
?>