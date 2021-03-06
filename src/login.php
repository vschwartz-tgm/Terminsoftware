<?php
	include ("functions.php");
	
	// Login durchführen
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
			<hr />
			
			<label for="uname"><b>Username</b></label>
			<input type="text" placeholder="Enter Username" name="uname" required />

			<label for="psw"><b>Password</b></label>
			<input type="password" placeholder="Enter Password" name="psw" required />

			<button type="submit" class="loginbtn" name="submit">Login</button>
			<label>
			  <input type="checkbox" checked="checked" name="remember" /> Remember me
			</label>
		  </div>

		  <div class="container" style="background-color:#f1f1f1" align="center">
			<span class="psw">Forgot <a href="#">password?</a></span>
		  </div>
		</form>
	</body>
</html>