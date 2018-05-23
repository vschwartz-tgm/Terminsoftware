<?php
	include ("functions.php");
	session_start();
	if(!isset($_SESSION['uname'])) {
		die('Bitte zuerst <a href="login.php">einloggen</a>');
	}
	$username = $_SESSION['uname'];
	
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout'])){
		session_start();
		session_destroy();
		header("Location: login.php");
	}
	
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
	
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['anmelden'])){
		$id = $_POST['anmelden'];
		echo "<script type='text/javascript'>alert('$id');</script>";
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['loeschen'])){
		$id = $_POST['loeschen'];
		echo "<script type='text/javascript'>alert('$id');</script>";
	}
	
	/*
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['ja'])){
		$a = new invitation($eventName, $username);
		$a->accept;
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['ja'])){
		$a = new invitation($eventName, $username);
		$a->decline;
	}*/

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
				<button type="submit" class="btn btn-outline-light" name="logout">Logout</button>
			</form>
		</nav>
		<br>
		<form method="post">
			<div class="container" align="center">
				<div class="input-group col-md-6">
					<div class="input-group-prepend">
						<div class="input-group-text">&#x1F50D;</div>
					</div>
					<input type="text" class="form-control" name="searchtext" placeholder="search" />
				</div>
				<br>
				<div>
					<label class="radio-inline"><input type="radio" name="optradio" value="event" checked>Event</label>
					&nbsp;&nbsp;
					<label class="radio"><input type="radio" name="optradio" value="user">User</label>
					&nbsp;&nbsp;
					<button type="submit" class="btn btn-outline-dark" name="search">Search</button>
				</div>
			</div>
		</form>
		<br>
		<div class="container">
  			<div class="row">
    			<div class="col-sm border">
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
										<td>$ergname[0]</td>
										<td>
											<button type='submit' class='btn btn-outline-dark' name='anmelden' value='value'>Ja</button>
											<button type='submit' class='btn btn-outline-dark' name='loeschen' value='value'>Nein</button>
										</td>
									</tr>";
							}
							
						?>
					</table>
    			</div>
				<div class="col-sm border">
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
								
								echo "<tr><td>$ergname[0]</td><td>$ergort[0]</td></tr>";
							}
						
						?>
					</table>
    			</div>
    			<div class="col-sm border">
      				<h4>Erstellungen:</h4>
					<table class="table">
						<tr>
							<th>Eventname:</th><th>Ort:</th>
						</tr>
						<tr>
						<?php 
						
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
								
								echo "<tr><td>$ergname[0]</td><td>$ergort[0]</td></tr>";
							}
						
						?>
					</table>
      				<button type="button" class="btn btn-outline-dark" name="addEvent" onclick="window.location='newEvent.php'">Add Event</button>
    			</div>
    		</div>
		</div>
	</body>
</html>