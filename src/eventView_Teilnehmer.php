<?php
	include ("functions.php");
	
	// Ist ein Benuter angemeldet?
	session_start();
	if(!isset($_SESSION['uname'])) {
		die('Bitte zuerst <a href="login.php">einloggen</a>');
	}
	$username = $_SESSION['uname'];
	
	// Wurde ein Event angeclickt?
	session_start();
	if(!isset($_SESSION['teilnehmerEvent'])) {
		die('Bitte zuerst <a href="terminreservierung.php">Event auswählen</a>');
	}
	$eventname = $_SESSION['teilnehmerEvent'];

	if(isset($_POST['submit'])){
	    $commentContent = $_POST['commentField'];
    }

    $eventid = "SELECT id from event where name = '$eventname'";
	$userid = "SELECT id from usr where name = '$username'";
	$c = new createComment($eventid, $commentContent, $userid);

	
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
		<script type="text/javascript">
		function poll() {
			setTimeout(function(){location.reload();},20000);
		}
			
		poll();
		</script>
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
						<th scope="col">Datum & Uhrzeit</th>
						<th scope="col">Ort</th>
						<th scope="col">Beschreibung</th>
						<th scope="col">Eingeladene User</th>
						<th scope="col">Ersteller</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<?php
								// Dates in die Tabelle schreiben
								$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
								$eventid = "SELECT id FROM event WHERE name = '$eventname';";
								$sql = pg_query($dbconn, $eventid);
								$id = pg_fetch_row($sql);
								
								$userid = "SELECT date FROM datum WHERE eventid = '$id[0]';";
								$sql = pg_query($dbconn, $userid); 
								echo "<p>Wählen Sie ihren Wunschtermin:</p>";
								while ($row = pg_fetch_row($sql)) {
									echo "$row[0]";
									echo "  ";
									echo "<input type='radio' name='date' value='$row[0]'>";
									echo "<br />";
								}
							?>
							<br />
							<div align="center">
								<form action="" method="post">
									<input type="submit" name="save" class="btn btn-outline-dark" value="Auswahl speichern" />
								</form>
							</div>
						</td>
						<td>
							<?php
								// Ort in die Tabelle schreiben
								$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
								$ort = "SELECT ort FROM event WHERE name = '$eventname';";
								$sql = pg_query($dbconn, $ort); 
								$row = pg_fetch_row($sql);
								echo "$row[0]";
							?>
						</td>
						<td>
							<?php
								// Description in die Tabelle schreiben
								$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
								$descr = "SELECT descr FROM event WHERE name = '$eventname';";
								$sql = pg_query($dbconn, $descr); 
								$row = pg_fetch_row($sql);
								echo "$row[0]";
							?>
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
									echo "<br />";
								}
							?>
						</td>
						<td>
							<?php
								// Ersteller in die Tabelle schreiben
								$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
								$descr = "SELECT usr FROM event WHERE name = '$eventname';";
								$sql = pg_query($dbconn, $descr); 
								$row = pg_fetch_row($sql);
								
								$username = "SELECT name FROM benutzer WHERE id = '$row[0]';";
								$sqlname = pg_query($dbconn, $username); 
								$name = pg_fetch_row($sqlname);
								
								echo "$name[0]";
							?>
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
		<div class="container">
			<form method="post">
				<div class="form-group">
					<input type="text" placeholder="Kommentar" name="commentField" class="form-control" id="commentField" />
					<button type="submit" class="btn btn-outline-dark form-control" onclick="<?php $c->execute() ?>" name="commentBtn" id="commentBtn" style="float: right;">Posten</button>
				</div>
				<table class="table scroll">
					<thead>
						<tr>
							<th scope="col">User</th>
							<th scope="col">Schrieb:</th>
						</tr>
					</thead>
					<tbody>
						<td>paul</td>
						<td>cool</td>
					</tbody>
				</table>
			</form>
		</div>
	</body>
</html>