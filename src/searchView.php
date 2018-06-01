<?php
	include ("functions.php");
	
	// Ist ein Benuter angemeldet?
	session_start();
	if(!isset($_SESSION['uname'])&&!isset($_SESSION['searchtext'])) {
		die('Bitte zuerst <a href="login.php">einloggen</a>');
	}
	$username = $_SESSION['uname'];
	
	// Suchwerte aus den Sessions holen
	$searchtext = $_SESSION['searchtext'];
	$searchtype = $_SESSION['searchtype'];
	
	// Logout-Funktionalität
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout'])){
		session_start();
		session_destroy();
		header("Location: login.php");
	}
	
	// Zurückbutton-Funktionalität
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['back'])){
		header("Location: terminreservierung.php");
	}
	
	// Link zur Eventanzeige (Einladung)
	if (isset($_GET["einlEvent"])){
		session_start();
		$_SESSION['einladungsEvent'] = $_GET["einlEvent"];
		header("Location: eventView_Einladung.php");
	}
?>

<html>
	<head>
		<meta charset="utf-8">
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<link href="terminreservierung_CSS.css" rel="stylesheet">
		<link rel="icon" href="kalender.jpg">
		<link href="searchView_CSS.css" rel="stylesheet">
		<script src="/node_modules/angular/angular.js"></script>
		<title>Terminreservierung</title>
	</head>
	<body>
		<nav class="navbar navbar-right navbar-dark bg-dark rounded">
			<div class="navbar-text">
				<h2>Terminreservierung / <?php echo "Suchergebnisse: $searchtext"; ?></h2>
			</div>
			<form class="nav navbar-right" method="post">
				<div class="navbar-text px-sm-2 pt-sm-3">
					<p id="usr"><?php echo "Hallo, $username"; ?></p>
				</div>
				<button type="submit" class="btn btn-outline-light" name="logout">Logout</button>
			</form>
		</nav>
		<br />
		<div class="container">
  			<div class="row">
    			<div class="col-sm border scroll">
     				<h4>Suchergebnisse für "<?php echo "$searchtext"; ?>" in <?php echo "$searchtype"; ?></h4>
					<table class="table">
						<?php
							$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
							
							if ($searchtype == "event"){
								//Eventsuche
								echo "<tr>
										<th>Eventname:</th>
									</tr>";
								$searcherg = "SELECT name FROM event WHERE name LIKE '%$searchtext%' OR name LIKE '$searchtext';";
								$sql = pg_query($dbconn, $searcherg);
								while ($row = pg_fetch_row($sql)) {
									echo "<tr>
											<td><a href ='searchView.php?einlEvent=$row[0]'> $row[0] </a></td>
										</tr>";
								}
								
							} else {
								//Usersuche
								echo "<tr>
										<th>Username:</th>
									</tr>";
								$searcherg = "SELECT name FROM benutzer WHERE name LIKE '%$searchtext%' OR name LIKE '$searchtext';";
								$sql = pg_query($dbconn, $searcherg);
								while ($row = pg_fetch_row($sql)) {
									echo "<tr>
											<td><a href ='searchView.php?einlEvent=$row[0]'> $row[0] </a></td>
										</tr>";
								}
								
							}
						?>
					</table>
    			</div>
			</div>
			<br />
			<div class="row">
				<form action="" method="post">
					<input type="submit" name="back" class="btn btn-outline-dark" value="Zurück" />
				</form>
			</div>
		</div>
	</body>
</html>