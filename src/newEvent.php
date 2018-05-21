<?php
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
	
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])){
		$dates = $_POST['date'];
        $user = $_POST['people'];
		$eventName = $_POST['eventName'];
		$ort = $_POST['location'];
		$desc = $_POST['desc'];
		
		
		$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		$fehler = false;
		
		$userid = "SELECT id FROM benutzer WHERE name = '$username';";
		$sql = pg_query($dbconn, $userid); 
		$row = pg_fetch_row($sql);
		echo "<script type='text/javascript'>alert('$row[0]');</script>";
		// Event hinzufügen
		$insert = "INSERT INTO event(name, ort, descr,usr) VALUES('$eventName', '$ort', '$desc', '$row[0]');";
		$i = pg_query($dbconn, $insert);
		// ID von hinzugefügtem Event 
		$eventId = "SELECT id FROM event WHERE name = '$eventName');";
		$sql = pg_query($dbconn, $eventId); 
		$row = pg_fetch_row($sql);
		
		foreach($dates as $date){
			$insertDates = "INSERT INTO datum VALUES('$row[0]','$date');";
			$idates = pg_query($dbconn, $insertDates);
			echo "<script type='text/javascript'>alert('$row[0]');</script>";
			echo "<script type='text/javascript'>alert('$date');</script>";
		}
/*

		$userId = "SELECT id FROM benutzer WHERE name = '$this->user');";




		foreach($this->user as $people){
			$userId = "SELECT id FROM benutzer WHERE name = '$this->user');";
			$insertUsers = "INSERT INTO teilnehmer VALUES('$userId','$this->eventId');";
			$iuser = pg_query($dbconn, $insertUsers);
			echo "<script type='text/javascript'>alert('".$people."');</script>";
		}*/
		
		/*
		$e = new CreateEvent($eventName, $user, $dates, $ort, $desc, $username);
		$e->execute();*/
	}
?>

<html>
	<head>
		<meta charset="utf-8">
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<link href="terminreservierung_CSS.css" rel="stylesheet">
		<link rel="icon" href="kalender.jpg">
		<link href="newEvent_CSS.css" rel="stylesheet">
		<script src="/node_modules/angular/angular.js"></script>
		<title>Terminreservierung</title>
	</head>
	<body>
		<nav class="navbar navbar-right navbar-dark bg-dark rounded">
			<div class="navbar-text">
				<h2>Terminreservierung / Neues Event</h2>
			</div>
			<form class="nav navbar-right" method="post">
				<div class="navbar-text px-sm-2 pt-sm-3">
					<p id="usr"><?php echo "Hallo, $username"; ?></p>
				</div>
				<button type="submit" class="btn btn-outline-light" name="logout">Logout</button>
			</form>
		</nav>
	<body>
		<br>
		<form method="post">
			<div class="container border">
				<label for="eventName"><b>Eventname</b></label>
    			<input type="text" placeholder="Gib den Eventnamen ein" name="eventName" id="eventName" required />
				<div id="wrapperDate">
    				<label for="date"><b>Datum & Uhrzeit</b></label>
    				<button type="button" class="btn btn-outline-success" onclick="addDate()" onclick="getDates()" style="float: right;">+</button>
    				<input type="datetime-local" name="date[]" id="date">
				</div>
    			<label for="location"><b>Ort</b></label>
    			<input type="text" placeholder="Gib den Ort ein" name="location" id="location" required />
			
				<label for="desc"><b>Beschreibung</b></label>
				<input type="text" placeholder="Füge eine Beschreibung hinzu" name="desc" id="desc" />
				<div id="wrapperPeople">
					<label for="people"><b>Teilnehmer</b></label>
					<button type="button" class="btn btn-outline-success" onclick="addPeople()" style="float: right;">+</button>
					<input type="text" placeholder="Benutzername" name="people[]" id="people[]" />
				</div>
				<div class="clearfix">
      				<button type="button" class="cancelbtn" onclick ="window.location = 'terminreservierung.php'">Abbrechen</button>
      				<button type="submit" name="submit" id="submit" class="addbtn">Hinzufügen</button>
    			</div>
    		</div>
		</form>

		<script>
			//Adds new input with incrementing id and name
			var count_date = 1;
			var count_people = 1;
			var i;
			function addDate(){
				var dates = [];
				var dummy = '<input type="datetime-local" name="date[]" id="date'+count_date+'">\r\n';
				document.getElementById('wrapperDate').innerHTML += dummy;
				count_date++;
				var test = '<input type="datetime-local" name="date" id="date">\r\n';
				dates.push(date);
				for(i = 1; i < count_date; i++){
					dates.push(date+i);
				}
				alert(document.getElementById('wrapperDate').innerHTML += dates);		
				alert(dummy);
				document.getElementById('wrapperDate').innerHTML += dates;
			}
			
			function addPeople(){
				var dummy = '<input type="text" placeholder="Benutzername" name="people[]" id="people'+count_people+'">\r\n';
				document.getElementById('wrapperPeople').innerHTML += dummy;
				count_people ++;
			}
			
			
		</script>
	</body>
</html>


<?php 
	/*
	function addEvent($eventName, $users, $dates, $ort, $desc){
		$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		$fehler = false;
		
		// Bei keinem Fehler, Account erstellen und auf login Seite ändern
		if ($fehler == false){
			// Event hinzufügen
			$insert = "INSERT INTO users(name,teilnehmer,dates, place, descr,usr) VALUES('$eventName','$users',{'$dates'}, '$ort', '$desc', {'$uname'});";
			$i = pg_query($dbconn, $insert);
		}
	}*/
?>