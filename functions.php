<?php
interface Command
{
	public function execute();
}
?>

<?php
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
?>

<?php
class LoginUser extends UserCommand
{
	private $uname;
	private $psw;
	
	function __construct($un, $pw){
		$uname = $un;
		$psw = $pw;
	}
	
	public function execute(){
		echo "<script type='text/javascript'>alert('In Funktion!');</script>";
		$dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		$fehler = false; 
		// Gibt es diesen User?
		$slct = "SELECT COUNT(*) FROM users WHERE uname = '".$uname."';"; 
		$sql = pg_query($dbconn, $slct); 
		$row = pg_fetch_row($sql); 
		if($row[0] <= 0) {
			$fehler = true;
		}
		// Ist das Passwort richtig für den Benutzer?
		if ($fehler == false){
			$pwdselect = "SELECT passwd FROM users WHERE uname = '".$uname."';"; 
			$sql = pg_query($dbconn, $pwdselect); 
			$row = pg_fetch_row($sql); 
			if ($psw != $row[0]){
				$fehler = true;
			}
		}
		// Fehler?
		if ($fehler == true){
			echo "<script type='text/javascript'>alert('Benutzername oder Passwort ist falsch!');</script>";
		}else{
			// Zur nächsten Seite
			session_start();
			$_SESSION['uname'] = $uname; // Eigentlich die ID
			header("Location: terminreservierung.php");
		}
	}
}
?>