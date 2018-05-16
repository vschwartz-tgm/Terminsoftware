<?php
/*
interface Command
{
	public function execute();
}

abstract class UserCommand implements Command
{
	public function execute();
}

abstract class OrganisatorCommand implements Command
{
	public function execute();
}

abstract class EventCommand implements Command
{
	public function execute();
}
*/
?>

<?php
//class LoginUser extends UserCommand
class LoginUser
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
		$slct = "SELECT count(*) FROM users WHERE name = '".$this->uname."';"; 
		$sql = pg_query($dbconn, $slct); 
		$row = pg_fetch_row($sql); 
		if($row[0] <= 0) {
			echo "<script type='text/javascript'>alert('USER');</script>";
			$fehler = true;
		}
		// Ist das Passwort richtig für den Benutzer?
		if ($fehler == false){
			$pwdselect = "SELECT pw FROM users WHERE name = '".$this->uname."';"; 
			$sql = pg_query($dbconn, $pwdselect);
			$row = pg_fetch_row($sql); 
			if ($this->psw != $row[0]){
				echo "<script type='text/javascript'>alert('PW');</script>";
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


class createEvent
{
	private $eventName;
	private $host;
	private $users;
	private $dates;
	
	
	function __construct($evN, $host, $usrs, $dates){
		$this->eventName = $evN;
		$this->host = $host;
		$this->users = $usrs;
		$this->dates = $dates;
	}
	
	public function execute(){
		$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		$fehler = false;
/*
		// ist etwas eingetragen
		if ($fehler == false){
			$pwdselect = "SELECT pw FROM users WHERE name = '".$this->uname."';"; 
			$sql = pg_query($dbconn, $pwdselect);
			$row = pg_fetch_row($sql); 
			if ($this->psw != $row[0]){
				echo "<script type='text/javascript'>alert('PW');</script>";
				$fehler = true;
			}
		}
*/
		// Fehler?
		if ($fehler == true){
			echo "<script type='text/javascript'>alert('Benutzername oder Passwort ist falsch!');</script>";
		}else{
			// Event hinzufügen
			$insert = "INSERT INTO users(name,teilnehmer,usr,dates) VALUES('$this->eventName','$this->users','$this->host, $this->dates');";
			$i = pg_query($dbconn, $insert);
		}
	}
}


class searchEvent
{
	private $eventName;
	private $host;
	private $users;
	private $dates;
	
	
	function __construct($evN, $host, $usrs, $dates){
		$this->eventName = $evN;
		$this->host = $host;
		$this->users = $usrs;
		$this->dates = $dates;
	}
	
	public function execute(){
		$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		$fehler = false;
/*
		// ist etwas eingetragen
		if ($fehler == false){
			$pwdselect = "SELECT pw FROM users WHERE name = '".$this->uname."';"; 
			$sql = pg_query($dbconn, $pwdselect);
			$row = pg_fetch_row($sql); 
			if ($this->psw != $row[0]){
				echo "<script type='text/javascript'>alert('PW');</script>";
				$fehler = true;
			}
		}
*/
		// Fehler?
		if ($fehler == true){
			echo "<script type='text/javascript'>alert('Benutzername oder Passwort ist falsch!');</script>";
		}else{
			// Event hinzufügen
			$insert = "INSERT INTO users(name,teilnehmer,usr,dates) VALUES('$this->eventName','$this->users','$this->host, $this->dates');";
			$i = pg_query($dbconn, $insert);
		}
	}
}
?>