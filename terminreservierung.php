<?php
	session_start();
	if(!isset($_SESSION['uname'])) {
		die('Bitte zuerst <a href="index.php">einloggen</a>');
	}
	$username = $_SESSION['uname'];
	
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])){
		session_start();
		session_destroy();
		header("Location: index.php");
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['search'])){
		$searchtext = $_POST['searchtext'];
		if ($_POST['optradio']) { 
			$type = $_POST['optradio'];
			search($searchtext, $type);
		}
	}
	
	function search($text, $type){
		echo "<script type='text/javascript'>alert('".$text."' '".$type."');</script>";
	}
?>

<html>
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<link href="terminreservierung_CSS.css" rel="stylesheet">
		<link rel="icon" href="kalender.jpg">
		<script src="/node_modules/angular/angular.js"></script>
		<title>Terminreservierung</title>
	</head>
	<body>
		<nav class="navbar navbar-right navbar-dark bg-dark rounded">
			<div class="navbar-text">
				<h2>Terminreservierung</h2>
			</div>
			<form class="nav navbar-right" method="post">
				<div class="navbar-text px-sm-2 pt-sm-3">
					<p id="usr"><?php echo "Hallo, $username"; ?></p>
				</div>
				<button type="submit" name="submit" class="btn btn-outline-light" method="">Logout</button>
			</form>
		</nav>
		<br>
		<form method="post">
			<div class="container" align="center">
				<div class="input-group col-md-6">
					<div class="input-group-prepend">
						<div class="input-group-text">&#x1F50D;</div>
					</div>
					<input type="text" class="form-control" name="searchtext" placeholder="search">
				</div>
				<br>
				<div>
					<label class="radio-inline"><input type="radio" name="optradio" value="event">Event</label>
					&nbsp;&nbsp;
					<label class="radio"><input type="radio" name="optradio" value="user">User</label>
					&nbsp;&nbsp;
					<button type="submit" class="btn btn-outline-dark" name="search">Search</button>
				</div>
			</div>
		</form>
	</body>
</html>