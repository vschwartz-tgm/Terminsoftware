<?php
	include ("functions.php");
	
	// Ist ein Benuter angemeldet?
	session_start();
	if(!isset($_SESSION['uname'])) {
		die('Bitte zuerst <a href="login.php">einloggen</a>');
	}
	$username = $_SESSION['uname'];
	
	// Wurde ein Event angeklickt?
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout'])){
		session_start();
		session_destroy();
		header("Location: login.php");
	}
	
	// Event erstellen
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])){
		$eventName = $_POST['eventName'];
		$user = $_POST['people'];
		$dates = $_POST['date'];
		$ort = $_POST['location'];
		$desc = $_POST['desc'];

		$e = new CreateEvent($eventName, $user, $dates, $ort, $desc, $username);
		$e->execute();
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
    				<button type="button" class="btn btn-outline-danger" onclick="removeDate('date'+count_date)" style="float: right; margin-left: 2px;">-</button>
    				<button type="button" class="btn btn-outline-success" onclick="addDate()" onclick="getDates()" style="float: right;">+</button>
    				<input type="datetime-local" name="date[]" id="date">
				</div>
    			<label for="location"><b>Ort</b></label>
    			<input type="text" placeholder="Gib den Ort ein" name="location" id="location" required />
			
				<label for="desc"><b>Beschreibung</b></label>
				<input type="text" placeholder="Füge eine Beschreibung hinzu" name="desc" id="desc" />
				<div id="wrapperPeople">
					<label for="people"><b>Teilnehmer</b></label>
					<button type="button" class="btn btn-outline-danger" onclick="removePeople('people'+count_people)" onclick="" style="float: right; margin-left: 2px;">-</button>
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
			var dates = [];
			var count_people = 1;
			var all_people = [];
			
			function addElement(parentId, elementTag, elementId, html) {
    			// Adds an element to the document
    			var p = document.getElementById(parentId);
    			var newElement = document.createElement(elementTag);
    			newElement.setAttribute('id', elementId);
    			newElement.innerHTML = html;
    			p.appendChild(newElement);
			}

			function removeDate(elementId) {
   				// Removes an element from the document
   				var element = document.getElementById(elementId);
    			element.parentNode.removeChild(element);
    			count_date--;
			}

			function removePeople(elementId) {
   				// Removes an element from the document
   				var element = document.getElementById(elementId);
    			element.parentNode.removeChild(element);
    			count_people--;
			}

			function addDate() {
				count_date++;
				var html = '<input type="datetime-local" name="date[]" required />';
				addElement('wrapperDate', 'datetime-local', 'date'+count_date, html);
			}

			function addPeople(){
				count_people++;
				var html = '<input type="text" placeholder="Benutzername" name="people[]" required />';
				addElement('wrapperPeople', 'text', 'people'+count_people, html);
			}
			
		</script>
	</body>
</html>