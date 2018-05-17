<?php
	session_start();
	if(!isset($_SESSION['uname'])) {
		die('Bitte zuerst <a href="index.php">einloggen</a>');
	}
	$username = $_SESSION['uname'];
	
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout'])){
		session_start();
		session_destroy();
		header("Location: index.php");
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
     				<h4>Eventteilnahmen an:</h4>
					<table class="table">
						<tr>
							<th>Eventname:</th><th>Datum:</th>
						</tr>
						<tr>
							<?php
								$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
								
								$userid = "SELECT id FROM benutzer WHERE name = '$username';";
								$sql = pg_query($dbconn, $userid); 
								$row = pg_fetch_row($sql);
								echo "<script type='text/javascript'>alert('$row[0]');</script>";
								
								$eventid = "SELECT event FROM teilnehmer WHERE usr = '$row[0]';";
								$sql = pg_query($dbconn, $eventid);
								$row = pg_fetch_row($sql);
								echo "<script type='text/javascript'>alert('$row[0]');</script>";
								echo "<script type='text/javascript'>alert('$row[1]');</script>";
								echo "<script type='text/javascript'>alert('$row[2]');</script>";
								
								$eventname = "SELECT name FROM event WHERE id = '$row[0]';";
								$sql = pg_query($dbconn, $eventname); 
								$row = pg_fetch_row($sql);
								echo "<script type='text/javascript'>alert('$row[0]');</script>";
								
								
								/*if($row[0] > 0) {
									$fehler = true;
									echo "<script type='text/javascript'>alert('Dieser User existiert bereits!');</script>";
								}*/
							?>
							<td>Event A</td><td>Unfixed</td>
						</tr>
					</table>
    			</div>
    			<div class="col-sm border">
      				<h4>Meine Events:</h4>
					<table class="table">
						<tr>
							<th>Eventname:</th><th>Datum:</th>
						</tr>
						<tr>
							<?php?>
							<td>Event A</td><td>Unfixed</td>
						</tr>
					</table>
      				<button type="button" class="btn btn-outline-dark" name="addEvent" onclick="window.location='newEvent.php'">Add Event</button>
    			</div>
    		</div>
		</div>
	</body>
</html>