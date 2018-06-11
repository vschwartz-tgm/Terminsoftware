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
	if(!isset($_SESSION['erstellerEvent'])) {
		die('Bitte zuerst <a href="terminreservierung.php">Event auswählen</a>');
	}
	$eventname = $_SESSION['erstellerEvent'];
	
	// Werte des Events herauslesen
	$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
	$ortQuery = "SELECT ort FROM event WHERE name = '$eventname';";
	$sql = pg_query($dbconn, $ortQuery); 
	$row = pg_fetch_row($sql);
	$ort = $row[0];
	$descQuery = "SELECT descr FROM event WHERE name = '$eventname';";
	$sql = pg_query($dbconn, $descQuery); 
	$row = pg_fetch_row($sql);
	$desc = $row[0];
	
	// Logout
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout'])){
		session_start();
		session_destroy();
		header("Location: index.php");
	}
	
	// Löschbutton-Funktionalität
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['delete'])){
		$d = new DeleteEvent($eventname);
		$d->execute();
	}
	
	// UserAddbutton-Funktionalität
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['addUser'])){
		$a = new AddUserToEvent($eventname, $_POST['newUser']);
		$a->execute();
	}
	
	// DateAddbutton-Funktionalität
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['addDate'])){
		$a = new AddDate($eventname, $_POST['newDate']);
		$a->execute();
	}
	
	// Änderungsbutton-Funktionalität
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['change'])){
		$eventidselect = "SELECT id FROM event WHERE name = '$eventname';";
		$sql = pg_query($dbconn, $eventidselect); 
		$eventid = pg_fetch_row($sql);
		$c = new ChangeEvent($eventid[0], $_POST['newOrt'], $_POST['newDesc']);
		$c->execute();
	}
	
	// Zurückbutton-Funktionalität
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['back'])){
		header("Location: terminreservierung.php");
	}
	
	// Funktionen für EingeladeneDeleteButtons vorbereiten
	$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
	$eventid = "SELECT id FROM event WHERE name = '$eventname';";
	$sql = pg_query($dbconn, $eventid);
	$id = pg_fetch_row($sql);
	$userid = "SELECT usr FROM teilnehmer WHERE event = '$id[0]';";
	$sql = pg_query($dbconn, $userid); 
	while ($row = pg_fetch_row($sql)) {
		$usernameselect = "SELECT name FROM benutzer WHERE id = '$row[0]';";
		$sqlname = pg_query($dbconn, $usernameselect); 
		$nameteiln = pg_fetch_row($sqlname);
		if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["deleteTeiln$nameteiln[0]"])){
			// echo "<script type='text/javascript'>alert('Delete Button gedrückt!');</script>";
			$d = new DeleteEingeladener($eventname, $nameteiln[0]);
			$d->execute();
		}
	}
	
	// Funktionen für DateDeleteButtons vorbereiten
	$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
	$eventid = "SELECT id FROM event WHERE name = '$eventname';";
	$sql = pg_query($dbconn, $eventid);
	$id = pg_fetch_row($sql);
	
	$userid = "SELECT date FROM datum WHERE eventid = '$id[0]';";
	$sql = pg_query($dbconn, $userid);
	$d = 0;
	while ($row = pg_fetch_row($sql)) {
		if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["deleteDate$d"])){
			$d = new DeleteDate($eventname, $row[0]);
			$d->execute();
		}
		$d = $d + 1;
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
		<form action="" method="post">
			<div class="container">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th scope="col">Eventname</th>
							<th scope="col">Datum & Uhrzeit</th>
							<th scope="col">Ort</th>
							<th scope="col">Beschreibung</th>
							<th scope="col">Eingeladene User</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<p><?php echo $eventname; ?></p>
								<!--<input name="newName" value="" />-->
							</td>
							<td>
								<?php
									// Dates in die Tabelle schreiben
									$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
									$eventid = "SELECT id FROM event WHERE name = '$eventname';";
									$sql = pg_query($dbconn, $eventid);
									$id = pg_fetch_row($sql);
									
									$userid = "SELECT date FROM datum WHERE eventid = '$id[0]';";
									$sql = pg_query($dbconn, $userid);
									$i = 0;
									while ($row = pg_fetch_row($sql)) {
										echo "$row[0]";
										echo "  ";
										echo "<input type='submit' class='btn btn-outline-dark' name='deleteDate$i' value='Entfernen' />";
										echo "<br />";
										$i = $i + 1;
									}
								?>
								<br />
								<input type="datetime-local" name="newDate" id="newDate" value="" />
								<input type="submit" name="addDate" id="addDate" class="btn btn-outline-dark" value="Termin hinzufügen" />
							</td>
							<td>
								<input name="newOrt" id="newOrt" value="<?php echo $ort; ?>" />
							</td>
							<td>
								<input name="newDesc" id="newDesc" value="<?php echo $desc; ?>" />
							</td>
							<td>
								<?php
									// Teilnehmer in die Tabelle schreiben
									$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
									$eventid = "SELECT id FROM event WHERE name = '$eventname';";
									$sql = pg_query($dbconn, $eventid);
									$id = pg_fetch_row($sql);
									
									$userid = "SELECT usr FROM teilnehmer WHERE event = '$id[0]';";
									$sql = pg_query($dbconn, $userid); 
									while ($row = pg_fetch_row($sql)) {
										$username = "SELECT name FROM benutzer WHERE id = '$row[0]';";
										$sqlname = pg_query($dbconn, $username); 
										$name = pg_fetch_row($sqlname);
										
										echo "$name[0]";
										echo " ";
										echo "<input type='submit' class='btn btn-outline-dark' name='deleteTeiln$name[0]' value='Entfernen' />";
										echo "<br />";
									}
								?>
								<br />
								<input name="newUser" id="newUser" value="" />
								<input type="submit" name="addUser" id="addUser" class="btn btn-outline-dark" value="Benutzer einladen" />
							</td>
						</tr>
					</tbody>
				</table>
				<div align="center">
					<input type="submit" name="change" class="btn btn-outline-success" value="Änderungen übernehmen" />
					<input type="submit" name="delete" class="btn btn-outline-danger" value="Event löschen" />
				</div>
				<br />
				<div class="row">
					<input type="submit" name="back" class="btn btn-outline-dark" value="Zurück" />
				</div>
			</div>
		</form>
		<div class="container">
			<form method="post">
				<div class="form-group">
					<input type="text" placeholder="Kommentar" name="commentField" class="form-control" id="commentField" name="commentField" />
					<button type="submit" class="btn btn-outline-dark form-control" onclick="" name="commentBtn" id="commentBtn style="float: right;">Posten</button>
				</div>
				<table class="table scroll">
					<thead>
						<tr>
							<th scope="col">User</th>
							<th scope="col">Schrieb:</th>
						</tr>
					</thead>
					<tbody>
						<td>Paul</td>
						<td>Tolles Event!</td>
					</tbody>
				</table>
			</form>
		</div>
	</body>
</html>
