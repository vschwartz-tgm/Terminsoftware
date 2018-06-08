<?php
	include ("functions.php");
	
	// Ist ein Benuter angemeldet?
	session_start();
	if(!isset($_SESSION['uname'])) {
		die('Bitte zuerst <a href="login.php">einloggen</a>');
	}
	$username = $_SESSION['uname'];
	
	// Logout-Funktionalität
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout'])){
		session_start();
		session_destroy();
		header("Location: login.php");
	}
	
	// Suchfunktionalität
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['search'])){
		$searchtext = $_POST['searchtext'];
		if ($searchtext == ''){
			echo "<script type='text/javascript'>alert('Bitte geben Sie einen Suchbegriff ein!');</script>";
		}else{
			if ($_POST['optradio']) { 
				$type = $_POST['optradio'];
				
				$s = new Search($searchtext, $type);
				$s->execute();
			}
		}
	}
	
	// Funktionen für Einladungsbuttons vorbereiten
	$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");				
	$userid = "SELECT id FROM benutzer WHERE name = '$username';";
	$sql = pg_query($dbconn, $userid); 
	$row = pg_fetch_row($sql);
	$eventid = "SELECT event FROM teilnehmer WHERE usr = '$row[0]' AND angenommen='false';";
	$sql = pg_query($dbconn, $eventid);
	while ($row = pg_fetch_row($sql)) {
		if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["anmelden$row[0]"])){
			$a = new Accept($row[0], $username);
			$a->execute();
		}
		if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["loeschen$row[0]"])){
			$d = new Decline($row[0], $username);
			$d->execute();
		}
	}
	
	// Link zur Eventanzeige (Einladung)
	if (isset($_GET["einlEvent"])){
		session_start();
		$_SESSION['einladungsEvent'] = $_GET["einlEvent"];
		header("Location: eventView_Einladung.php");
	}
	
	// Link zur Eventanzeige (Teilnehmer)
	if (isset($_GET["teilnEvent"])){
		// echo "<script type='text/javascript'>alert(\"".$_GET["teilnEvent"]."\");</script>";
		session_start();
		$_SESSION['teilnehmerEvent'] = $_GET["teilnEvent"];
		header("Location: eventView_Teilnehmer.php");
	}
	
	// Link zur Eventanzeige (Ersteller)
	if (isset($_GET["erstEvent"])){
		session_start();
		$_SESSION['erstellerEvent'] = $_GET["erstEvent"];
		header("Location: eventView_Ersteller.php");
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
		
		
		<script type="text/javascript">
			setInterval('Window.location.reload()',3000);
		</script>

		<nav class="navbar navbar-right navbar-dark bg-dark rounded">
			<div class="navbar-text">
				<h2>Terminreservierung</h2>
			</div>
			<form class="nav navbar-right" method="post">
				<div class="navbar-text px-sm-2 pt-sm-3">
					<p id="usr"><?php echo "Hallo, $username"; ?></p>
				</div>
				<button type="submit" class="btn btn-outline-light" name="logout">Logout</button>
			</form>
		</nav>
		<br />
		<form method="post">
			<div class="container" align="center">
				<div class="input-group col-md-6">
					<div class="input-group-prepend">
						<div class="input-group-text">&#x1F50D;</div>
					</div>
					<input type="text" class="form-control" name="searchtext" placeholder="search" />
				</div>
				<br />
				<div>
					<label class="radio-inline"><input type="radio" name="optradio" value="event" checked>Event</label>
					&nbsp;&nbsp;
					<label class="radio"><input type="radio" name="optradio" value="user">User</label>
					&nbsp;&nbsp;
					<button type="submit" class="btn btn-outline-dark" name="search">Search</button>
				</div>
			</div>
		</form>
		<br />
		<div class="container">
  			<div class="row">
    			<div class="col-sm border scroll">
     				<h4>Einladungen:</h4>
					<table class="table">
						<tr>
							<th>Eventname:</th><th>Annehmen?</th>
						</tr>
						<?php
							// Vom aktuellen Benutzer alle Einladungen in die Tabelle schreiben
							
							$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
							
							$userid = "SELECT id FROM benutzer WHERE name = '$username';";
							$sql = pg_query($dbconn, $userid); 
							$row = pg_fetch_row($sql);
							
							$eventid = "SELECT event FROM teilnehmer WHERE usr = '$row[0]' AND angenommen='false';";
							$sql = pg_query($dbconn, $eventid);
							
							while ($row = pg_fetch_row($sql)) {
								$eventname = "SELECT name FROM event WHERE id = '$row[0]';";
								$sqlname = pg_query($dbconn, $eventname); 
								$ergname = pg_fetch_row($sqlname);
								
								$eventort = "SELECT ort FROM event WHERE id = '$row[0]';";
								$sqlort = pg_query($dbconn, $eventort); 
								$ergort = pg_fetch_row($sqlort);
								
								echo "<tr>
										<td><a href ='terminreservierung.php?einlEvent=$ergname[0]'> $ergname[0] </a></td>
										<td>
											<form action='' method='post'>
												<input type='submit' class='btn btn-outline-dark' name='anmelden$row[0]' value='Ja' />
												<input type='submit' class='btn btn-outline-dark' name='loeschen$row[0]' value='Nein' />
											</form>
										</td>
									</tr>";
							}
							
						?>
					</table>
    			</div>
				<div class="col-sm border scroll">
     				<h4>Teilnahmen:</h4>
					<table class="table">
						<tr>
							<th>Eventname:</th><th>Ort:</th>
						</tr>
						<?php
							// Vom aktuellen Benutzer alle Events auslesen, an denen dieser Teilnimmt, und in die Tabelle schreiben
							
							$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
							
							$userid = "SELECT id FROM benutzer WHERE name = '$username';";
							$sql = pg_query($dbconn, $userid); 
							$row = pg_fetch_row($sql);
							
							$eventid = "SELECT event FROM teilnehmer WHERE usr = '$row[0]' AND angenommen='true';;";
							$sql = pg_query($dbconn, $eventid);
							
							while ($row = pg_fetch_row($sql)) {
								$eventname = "SELECT name FROM event WHERE id = '$row[0]';";
								$sqlname = pg_query($dbconn, $eventname); 
								$ergname = pg_fetch_row($sqlname);
								
								$eventort = "SELECT ort FROM event WHERE id = '$row[0]';";
								$sqlort = pg_query($dbconn, $eventort); 
								$ergort = pg_fetch_row($sqlort);
								
								echo "<tr><td><a href ='terminreservierung.php?teilnEvent=$ergname[0]'> $ergname[0] </a></td><td>$ergort[0]</td></tr>";
							}
						
						?>
					</table>
    			</div>
    			<div class="col-sm border">
    				<div class="scroll2">
      				<h4>Erstellungen:</h4>
					<table class="table">
						<tr>
							<th>Eventname:</th><th>Ort:</th>
						</tr>
						<?php 
							// Alle vom User erstellten Events anzeigen
							
							$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
							
							$userid = "SELECT id FROM benutzer WHERE name = '$username';";
							$sql = pg_query($dbconn, $userid); 
							$row = pg_fetch_row($sql);
							
							$eventid = "SELECT id from event where usr ='$row[0]';";
							$sql = pg_query($dbconn, $eventid);
							
							while ($row = pg_fetch_row($sql)) {
								$eventname = "SELECT name FROM event WHERE id = '$row[0]';";
								$sqlname = pg_query($dbconn, $eventname); 
								$ergname = pg_fetch_row($sqlname);
								
								$eventort = "SELECT ort FROM event WHERE id = '$row[0]';";
								$sqlort = pg_query($dbconn, $eventort); 
								$ergort = pg_fetch_row($sqlort);
								
								echo "<tr><td><a href ='terminreservierung.php?erstEvent=$ergname[0]'> $ergname[0] </a></td><td>$ergort[0]</td></tr>";
							}
						
						?>
					</table>
					</div>
					<div>
						<button type="button" class="btn btn-outline-dark" name="addEvent" onclick="window.location='newEvent.php'">Add Event</button>
    				</div>
    			</div>
    		</div>
		</div>
	</body>
</html>