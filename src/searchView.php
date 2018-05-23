<?php
	session_start();
	if(!isset($_SESSION['uname'])&&!isset($_SESSION['eventName'])) {
		die('Bitte zuerst <a href="index.php">einloggen</a>');
	}
	$username = $_SESSION['uname'];
	$eventName = $_SESSION['eventName'];
	
	<!--ToDo: teilnehmer und datum des events rauslesen und in table <p> reinschreiben-->
	
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
		<link href="searchView_CSS.css" rel="stylesheet">
		<script src="/node_modules/angular/angular.js"></script>
		<title>Terminreservierung</title>
	</head>
	<body>
		<nav class="navbar navbar-right navbar-dark bg-dark rounded">
			<div class="navbar-text">
				<h2>Terminreservierung / <?php echo $eventname; ?></h2>
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
					<?php
						if (strlen($username) == 0) {
							//events
							echo "<tr><th scope='col'>Name</th><th scope='col'>Ort</th><th scope='col'>Beschreibung</th></tr>";
						}elseif(strlen($eventName) == 0){
							//users
							echo "<tr><th scope='col'>Name</th><th scope='col'>email</th></tr>";
						}
					?>
				</thead>
				<tbody>
					<?php
						$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
						
						// entscheiden ob nach event oder user gesucht wird
						if (strlen($username) == 0) {
							//events
							$eventid = "SELECT id FROM event WHERE name = '%$eventName%';";
							$sql = pg_query($dbconn, $eventid); 
							$row = pg_fetch_row($sql);
							
							while ($row = pg_fetch_row($sql)) {
								$eventname = "SELECT name FROM benutzer WHERE id = '$row[0]';";
								$sqleventname = pg_query($dbconn, $eventname); 
								$erdeventname = pg_fetch_row($sqleventname);
								
								$eventlocation = "SELECT ort FROM event WHERE id = '$row[0]';";
								$sqleventlocation = pg_query($dbconn, $eventlocation); 
								$erdeventlocation = pg_fetch_row($sqleventlocation);
								
								$eventdescription = "SELECT descr FROM event WHERE id = '$row[0]';";
								$sqleventdescription = pg_query($dbconn, $eventdescription); 
								$erdeventdescription = pg_fetch_row($sqleventdescription);
								
						//		$eventpeople = "SELECT descr FROM event WHERE id = '$row[0]';";
						//		$sqleventpeople = pg_query($dbconn, $eventpeople); 
						//		$erdeventpeople = pg_fetch_row($sqleventpeople);
								
						//		$eventdate = "SELECT descr FROM event WHERE id = '$row[0]';";
						//		$sqleventdate = pg_query($dbconn, $eventdate); 
						//		$erdeventdate = pg_fetch_row($sqleventdate);
								
								echo "<td>$erdeventname[0]</td></tr><tr><td>$erdeventlocation[0]</td><tr><td>$erdeventdescription[0]</td>";	
							}
						}elseif(strlen($eventName) == 0){
							//user
							$userid = "SELECT id FROM benutzer WHERE name = '%$username%';";
							$sql = pg_query($dbconn, $userid); 
							$row = pg_fetch_row($sql);
							
							while ($row = pg_fetch_row($sql)) {
								$username = "SELECT name FROM benutzer WHERE id = '$row[0]';";
								$sqlusername = pg_query($dbconn, $username); 
								$erdusername = pg_fetch_row($sqlusername);
								
								$useremail = "SELECT email FROM benutzer WHERE id = '$row[0]';";
								$sqluseremail = pg_query($dbconn, $useremail); 
								$erduseremail = pg_fetch_row($sqluseremail);
								
								echo "<td>$erdusername[0]</td></tr><tr><td>$erduseremail[0]</td>";	
							}
						}
						?>
				</tbody>
			</table>
		</div>
	</body>
</html>