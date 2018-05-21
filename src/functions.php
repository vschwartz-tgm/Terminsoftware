<?php
interface Command
{
	public function execute();
}

abstract class UserCommand implements Command
{
	public function execute(){}
}

abstract class OrganisatorCommand implements Command
{
	public function execute(){}
}

abstract class EventCommand implements Command
{
	public function execute(){}
}
?>


<?php
/**
* Klasse LoginUser, zum Einloggen des Users
*
* @author	Paul Mazzolini
* @version  1.0
*/
class LoginUser extends UserCommand
{
	private $uname;
	private $psw;
	
	function __construct($un, $pw){
		$this->uname = $un;
		$this->psw = $pw;
	}
	
	public function execute(){
		$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		$fehler = false;
		// Gibt es diesen User?
		$slct = "SELECT count(*) FROM benutzer WHERE name = '".$this->uname."';"; 
		$sql = pg_query($dbconn, $slct); 
		$row = pg_fetch_row($sql); 
		if($row[0] <= 0) {
			$fehler = true;
		}
		// Ist das Passwort richtig für den Benutzer?
		if ($fehler == false){
			$pwdselect = "SELECT pw FROM benutzer WHERE name = '".$this->uname."';"; 
			$sql = pg_query($dbconn, $pwdselect);
			$row = pg_fetch_row($sql); 
			if ($this->psw != $row[0]){
				$fehler = true;
			}
		}
		// Fehler?
		if ($fehler == true){
			echo "<script type='text/javascript'>alert('Benutzername oder Passwort ist falsch!');</script>";
		}else{
			// Zur nächsten Seite
			session_start();
			$_SESSION['uname'] = $this->uname; // Eigentlich die ID
			header("Location: terminreservierung.php");
		}
	}
}
?>


<?php
/**
* Klasse RegisterUser, zum Registrieren neuer User
*
* @author	Paul Mazzolini
* @version  1.0
*/
class RegisterUser extends UserCommand
{
	private $uname;
	private $email;
	private $psw;
	private $pswrepeat;
	
	function __construct($uname, $email, $psw, $pswrepeat){
		$this->uname = $uname;
		$this->email = $email;
		$this->psw = $psw;
		$this->pswrepeat = $pswrepeat;
	}
	
	public function execute(){
		$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		$fehler = false; 
		// Uname schon vorhanden?
		$slct = "SELECT COUNT(*) FROM benutzer WHERE name = '".$this->uname."';"; 
		$sql = pg_query($dbconn, $slct); 
		$row = pg_fetch_row($sql); 
		if($row[0] > 0) { 
			$fehler = true;
			echo "<script type='text/javascript'>alert('Dieser User existiert bereits!');</script>";
		}
		// Email schon vorhanden?
		if ($fehler == false){
			$sql = "SELECT COUNT(*) FROM benutzer WHERE email = '".$this->email."';"; 
			$sql = pg_query($dbconn, $sql);
			$row = pg_fetch_row($sql);
			if($row[0] > 0) { 
				$fehler = true;
				echo "<script type='text/javascript'>alert('Diese Email hat bereits einen Account!');</script>";
			}
		}
		// Email möglich?
		if ($fehler == false){
			if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
				// Kein Fehler
			} else {
				$fehler = true;
				echo "<script type='text/javascript'>alert('Ungültige Emailadresse!');</script>";
			}
		}
		// Passwörter gleich?
		if ($fehler == false){
			if ($this->psw != $this->pswrepeat){
				echo "<script type='text/javascript'>alert('Passwörter stimmen nicht überein!');</script>";
				$fehler = true; 
			}
		}
		// Bei keinem Fehler, Account erstellen und auf login Seite ändern
		if ($fehler == false){
			$insert = "INSERT INTO benutzer(name,email,pw) VALUES('$this->uname','$this->email','$this->psw');";
			$i = pg_query($dbconn, $insert);
			header("Location: index.php");
		}
	}
}
?>


<?php
/**
* Klasse Search, zum Suchen von Events oder User
*
* @author	Paul Mazzolini
* @version  1.0
*/
class Search extends UserCommand
{
	private $text;
	private $type;
	
	function __construct($text, $type){
		$this->text = $text;
		$this->type = $type;
	}
	
	public function execute(){
		$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		$fehler = false; 
		
		//ToDo
	}
}
?>


<?php
/**
* Klasse CreateEvent, zum Erstellen eines Events
*
* @author	Paul Mazzolini
* @version  1.0
*/
class CreateEvent extends OrganisatorCommand
{
	private $eventName;
	private $user;
	private $dates;
	private $ort;
	private $desc;
	private $uname;
	
	
	
	
	function __construct($eventName, $user, $dates, $ort, $desc, $username){
		$this->eventName = $eventName;
		$this->user = $user;
		$this->dates = $dates;
		$this->ort = $ort;
		$this->desc = $desc;
		$this->uname = $username;

	}
	
	public function execute(){
		$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		$fehler = false;
		
		//ToDo
		// Bei keinem Fehler, Account erstellen und auf login Seite ändern
		if ($fehler == false){
			
		
			$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
			$fehler = false;
			$userid = "SELECT id FROM benutzer WHERE name = '$this->uname';";
			$sql = pg_query($dbconn, $userid); 
			$row = pg_fetch_row($sql);
			// Event hinzufügen
			$insert = "INSERT INTO event(name, ort, descr,usr) VALUES('$this->eventName', '$this->ort', '$this->desc', '$row[0]');";
			$i = pg_query($dbconn, $insert);
			// ID von hinzugefügtem Event 
			$eventId = "SELECT id FROM event WHERE name = '$this->eventName';";
			$sql = pg_query($dbconn, $eventId); 
			$row = pg_fetch_row($sql);

			foreach($this->dates as $date){
				$insertDates = "INSERT INTO datum VALUES('$row[0]','$date');";
				$idates = pg_query($dbconn, $insertDates);
			}


			foreach($this->user as $people){
				$userId = "SELECT id FROM benutzer WHERE name = '$people';";
				$userID = pg_query($dbconn, $userId); 
				$uID = pg_fetch_row($userID);
				echo "<script type='text/javascript'>alert('$uID[0]');</script>";
				$insertUsers = "INSERT INTO teilnehmer VALUES('$uID[0]','$row[0]');";
				$iuser = pg_query($dbconn, $insertUsers);
				echo "<script type='text/javascript'>alert('$row[0]');</script>";
				echo "<script type='text/javascript'>alert('$people');</script>";
			}
		}
	}
}
?>