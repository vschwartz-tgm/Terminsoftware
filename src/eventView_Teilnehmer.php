<?php
	// Ist ein Benuter angemeldet?
	session_start();
	if(!isset($_SESSION['uname'])) {
		die('Bitte zuerst <a href="index.php">einloggen</a>');
	}
	$username = $_SESSION['uname'];
	
	// Wurde ein Event angeklickt?
	session_start();
	if(!isset($_SESSION['teilnehmerEvent'])) {
		die('Bitte zuerst <a href="terminreservierung.php">Event auswählen</a>');
	}
	$eventName = $_SESSION['teilnehmerEvent'];
	
	// <!--ToDo: ort, date, beschriebung und teilnehmer des events rauslesen und in table <p> reinschreiben-->
	
	// Logout
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout'])){
		session_start();
		session_destroy();
		header("Location: index.php");
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
		<br>
		<div class="container">
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
						<td><p id="location"></p></td>
						<td> <p id="desc"></p></td>
						<td><p id="people"></p></td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>
</html>