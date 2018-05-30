<?php
	include ("functions.php");
	
	// Ist ein Benuter angemeldet?
	session_start();
	if(!isset($_SESSION['uname'])) {
		die('Bitte zuerst <a href="index.php">einloggen</a>');
	}
	$username = $_SESSION['uname'];
	
	// Wurde ein Event angeklickt?
	session_start();
	if(!isset($_SESSION['erstellerEvent'])) {
		die('Bitte zuerst <a href="terminreservierung.php">Event auswählen</a>');
	}
	$eventname = $_SESSION['erstellerEvent'];
	
	// Logout
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout'])){
		session_start();
		session_destroy();
		header("Location: index.php");
	}
	
	// Löschbutton-Funktionalität
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['delete'])){
		$l = new DeleteEvent($eventname);
		$l->execute();
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
    		<table class="table table-bordered">
				<thead>
					<tr>
						<th scope="col">Eventname</th>
						<th scope="col">Datum & Uhrzeit</th>
						<th scope="col">Ort</th>
						<th scope="col">Beschreibung</th>
						<th scope="col">Teilnehmerliste</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<?php echo "<input type='text' id='eventname' value='$eventName'/>";?>
							<input type="text" name="result" value = "<?php echo '$eventName';?>">
						</td>
						<td>
							<select id="date">
								<option value="">stuff</option>
							</select>
							<br><br>
							<button type="button" class="btn btn-outline-danger" onclick="">Löschen</button>
							<button type="button" class="btn btn-outline-success" onclick="">Hinzufügen</button>
						</td>
						<td><p id="location"></p></td>
						<td> <p id="desc"></p></td>
						<td><p id="people"></p></td>
					</tr>
				</tbody>
			</table>
			<div align="center">
				<button type="submit" name="change" class="btn btn-outline-success" >Änderungen übernehmen</button>
				<button type="submit" name="delete" class="btn btn-outline-danger" >Änderungen übernehmen</button>
			</div>
		</div>
	</body>
</html>