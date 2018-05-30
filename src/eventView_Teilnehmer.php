<?php
	include ("functions.php");
	
	// Ist ein Benuter angemeldet?
	session_start();
	if(!isset($_SESSION['uname'])) {
		die('Bitte zuerst <a href="login.php">einloggen</a>');
	}
	$username = $_SESSION['uname'];
	
	// Wurde ein Event angeklickt?
	session_start();
	if(!isset($_SESSION['teilnehmerEvent'])) {
		die('Bitte zuerst <a href="terminreservierung.php">Event auswählen</a>');
	}
	$eventname = $_SESSION['teilnehmerEvent'];
	
	// Logout
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout'])){
		session_start();
		session_destroy();
		header("Location: index.php");
	}
	
	// Zurückbutton-Funktionalität
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['back'])){
		header("Location: terminreservierung.php");
	}
	
	
?>

<html>
	<head>
		<meta charset="utf-8">
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<link href="terminreservierung_CSS.css" rel="stylesheet">
		<link rel="icon" href="kalender.jpg">
		<link href="eventView_CSS.css" rel="stylesheet">
		<script src="/node_modules/angular/angular.js"></script>
		<title>Terminreservierung</title>
	</head>
	<body>
		<nav class="navbar navbar-right navbar-dark bg-dark rounded">
			<div class="navbar-text">
				<h2>Terminreservierung / <?php echo "$eventname"; ?></h2>
			</div>
			<form class="nav navbar-right" method="post">
				<div class="navbar-text px-sm-2 pt-sm-3">
					<p id="usr"><?php echo "Hallo, $username"; ?></p>
				</div>
				<button type="submit" class="btn btn-outline-light" name="logout">Logout</button>
			</form>
		</nav>	
		<br />
		<h1 align="center">Event <?php echo "$eventname"; ?></h1>
		<div class="container">
			<div align="right">
				<form action="" method="post">
					<input type="submit" name="delete" class="btn btn-outline-dark" value="Event löschen" />
				</form>
			</div>
    		<table class="table table-bordered">
				<thead>
					<tr>
						<th scope="col">Datum & Uhrzeit</th>
						<th scope="col">Ort</th>
						<th scope="col">Beschreibung</th>
						<th scope="col">Teilnehmerliste</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<p id="date"></p>
							<button type="button" class="btn btn-outline-success" onclick="">Abstimmen</button>
						</td>
						<td>
							<?php
								$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
								$userid = "SELECT ort FROM event WHERE name = '$eventname';";
								$sql = pg_query($dbconn, $userid); 
								$row = pg_fetch_row($sql);
								echo "$row[0]";
							?>
						</td>
						<td>
							<?php
								$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
								$userid = "SELECT descr FROM event WHERE name = '$eventname';";
								$sql = pg_query($dbconn, $userid); 
								$row = pg_fetch_row($sql);
								echo "$row[0]";
							?>
						</td>
						<td>
							<p id="people"></p>
						</td>
					</tr>
				</tbody>
			</table>
			<br />
			<div class="row">
				<form action="" method="post">
					<input type="submit" name="back" class="btn btn-outline-dark" value="Zurück" />
				</form>
			</div>
		</div>
	</body>
</html>