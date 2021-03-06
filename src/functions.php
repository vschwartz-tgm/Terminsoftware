<?php
/**
 * Interface Command
 *
 * @author	Paul Mazzolini
 * @version  05102018
 */
interface Command
{
    public function execute();
}
/**
 * Klasse UserCommand, Funktion die der User ausführen kann
 *
 * @author	Paul Mazzolini
 * @version  05102018
 */
abstract class UserCommand implements Command
{
    public function execute(){}
}
/**
 * Klasse OrganisatorCommand, Funktion die der Organisator ausführen kann
 *
 * @author	Paul Mazzolini
 * @version  05102018
 */
abstract class OrganisatorCommand implements Command
{
    public function execute(){}
}
/**
 * Klasse EventCommand, Funktion die beim Event ausführt werden
 *
 * @author	Paul Mazzolini
 * @version  05102018
 */
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
 * @version  05142018
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

/**
 * Klasse RegisterUser, zum Registrieren neuer User
 *
 * @author	Paul Mazzolini
 * @version  05142018
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
            $m = new SendMailRegister($this->email, $this->uname);
            $m->execute();
            header("Location: login.php");
        }
    }
}

/**
 * Klasse Search, zum Suchen von Events oder Usern
 *
 * @author	Paul Mazzolini
 * @version  05162018
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
        // Suchbebriff vorhanden?
        if ($fehler == false){
            if (strlen($this->text) == 0) {
                $fehler = true;
                echo "<script type='text/javascript'>alert('Leerer Suchbegriff!');</script>";
            }
        }
        // Richtiger Type
        if ($fehler == false){
            if ($this->type == "user" || $this->type == "event"){
                //kein Fehler
            } else {
                $fehler = true;
                echo "<script type='text/javascript'>alert('Ungültiger Typ!');</script>";
            }
        }
        if ($fehler == false){
			// Zum Suchergebnis
			session_start();
			$_SESSION['searchtext'] = $this->text;
			$_SESSION['searchtype'] = $this->type;
			header("Location: searchView.php");
        }
    }
}

/**
 * Klasse ShowEvents, zum alle Events eines Benutzers
 *
 * @author	Paul Mazzolini
 * @version  06112018
 */
class ShowEvents extends UserCommand
{
    private $username;

    function __construct($username){
        $this->username = $username;
    }

    public function execute(){
        $dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
							
		$userid = "SELECT id FROM benutzer WHERE name = '$this->username';";
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
    }
}

/**
 * Klasse Accept, zum Annehmen der Einladungen, entspricht Klasse TakePartEvent
 *
 * @author	Christoph Kern
 * @version  05232018
 */
class Accept extends UserCommand
{
    private $eventId;
    private $uname;

    function __construct($eventId, $username){
        $this->eventId = $eventId;
        $this->uname = $username;
    }

    public function execute(){
        $dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
        $userid = "SELECT id FROM benutzer WHERE name = '$this->uname';";
        $sql = pg_query($dbconn, $userid); 
        $row = pg_fetch_row($sql);
        $i = "UPDATE teilnehmer SET angenommen = true WHERE event = '$this->eventId' AND usr = '$row[0]';";
        $sql = pg_query($dbconn, $i);
        $sql = pg_query($dbconn, $i); 
    }
}

/**
 * Klasse Decline, zum Ablehnen der Einladungen, entspricht Klasse TakePartEvent
 *
 * @author	Christoph Kern
 * @version  05232018
 */
class Decline extends UserCommand
{
    private $eventId;
    private $uname;

    function __construct($eventId, $username){
        $this->eventId = $eventId;
        $this->uname = $username;
    }

    public function execute(){
        $dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
        $userid = "SELECT id FROM benutzer WHERE name = '$this->uname';";
        $sql = pg_query($dbconn, $userid); 
        $row = pg_fetch_row($sql);
        $i = "DELETE FROM teilnehmer WHERE event = '$this->eventId' AND usr = '$row[0]';";
        $sql = pg_query($dbconn, $i);
    }

}
?>


<?php
require './vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
/**
 * Klasse CreateEvent, zum Erstellen eines Events
 *
 * @author	Paul Mazzolini
 * @version  05212018
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

        // Event schon vorhanden?
        $slct = "SELECT COUNT(*) FROM event WHERE name = '".$this->eventName."';"; 
        $sql = pg_query($dbconn, $slct); 
        $row = pg_fetch_row($sql); 
        if($row[0] > 0) { 
            $fehler = true;
            echo "<script type='text/javascript'>alert('Dieses Event existiert bereits!');</script>";
        }

        // Bei keinem Fehler, Account erstellen und auf login Seite ändern
        if ($fehler == false){
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
                $insertUsers = "INSERT INTO teilnehmer VALUES('$uID[0]','$row[0]', false);";
                $iuser = pg_query($dbconn, $insertUsers);
            }
            $m = new SendMailInvitation($this->user, $this->eventName);
            $m->execute();
            header("Location: terminreservierung.php");
        }
    }
}

/**
 * Klasse ChangeEvent, zum Ändern eines Events
 *
 * @author	Paul Mazzolini
 * @version  06012018
 */
class ChangeEvent extends OrganisatorCommand
{
	private $eventId;
    private $ortNew;
	private $descNew;

    function __construct($eventId, $ortNew, $descNew){
        $this->eventId = $eventId;
		$this->ortNew = $ortNew;
        $this->descNew = $descNew;
    }

    public function execute(){
        $dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
        $fehler = false;
		
		$updateEvent = "UPDATE event SET ort = '$this->ortNew' WHERE id = '$this->eventId';";
		$sql = pg_query($dbconn, $updateEvent);
		$updateDescr = "UPDATE event SET descr = '$this->descNew' WHERE id = '$this->eventId';";
		$sql = pg_query($dbconn, $updateDescr);
		
		header("Location: eventView_Ersteller.php");
		
		// Überprüfung, falls Eventname auch geändert werden sollte:
		
		/*// Eventname schon vorhanden?
		try{
			$slct = "SELECT id FROM event WHERE name = '$this->nameNew';"; 
			$sql = pg_query($dbconn, $slct); 
			$row = pg_fetch_row($sql);
			if ($row[0]!=$this->eventId){
				$slct = "SELECT COUNT(*) FROM event WHERE name = '$this->nameNew';"; 
				$sql = pg_query($dbconn, $slct); 
				$row = pg_fetch_row($sql); 
				if($row[0] > 0) { 
					$fehler = true;
					echo "<script type='text/javascript'>alert('Dieser Eventname existiert bereits!');</script>";
				}
			}
		} catch (Exception $e) {
		}
		// Werte updaten
		if ($fehler == false){
			$update = "UPDATE event SET name = '$this->nameNew' WHERE id = '$this->eventId';";
			$sql = pg_query($dbconn, $update);*/
            /*
			$update = "UPDATE event SET ort = '$this->ortNew' WHERE id = '$this->eventId';";
			$sql = pg_query($dbconn, $update);
			$update = "UPDATE event SET descr = '$this->descNew' WHERE id = '$this->eventId';";
			$sql = pg_query($dbconn, $update);
		}*/
    }
}

/**
 * Klasse DeleteEvent, zum Löschen von Events (solange möglich, bis ein User die Einladung angenommen hat)
 *
 * @author	Paul Mazzolini
 * @version  06062018
 */
class DeleteEvent extends OrganisatorCommand
{
    private $event;

    function __construct($event){
        $this->event = $event;
    }

    public function execute(){
        $dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d")     ;	

        $eid = "SELECT id FROM event WHERE name = '$this->event';";
        $sql = pg_query($dbconn, $eid);
        $row = pg_fetch_row($sql);

        $acc = "SELECT count(usr) FROM teilnehmer WHERE angenommen = 'true' AND event ='$row[0]';";
        $sql = pg_query($dbconn, $acc);
        $ang = pg_fetch_row($sql);
        
        if($ang[0] == 0){
            $eid = "SELECT id FROM event WHERE name = '$this->event'; ";
            $sql = pg_query($dbconn, $eid);
            $row = pg_fetch_row($sql);

            $rmT = "DELETE FROM teilnehmer WHERE event = '$row[0]';";
            $sql = pg_query($dbconn, $rmT);

            $rmD = "DELETE FROM datum WHERE eventid = '$row[0]';";
            $sql = pg_query($dbconn, $rmD);

            $rm = "DELETE FROM event WHERE name = '$this->event'; ";
            $sql = pg_query($dbconn, $rm);
			echo "<script type='text/javascript'>alert('Event wurde erfolgreich gelöscht.');</script>";
            header("Location: terminreservierung.php");
        }else{
            echo "<script type='text/javascript'>alert('Event kann nicht gelöscht werden, da Teilnehmer bereits beigetreten sind.');</script>";
        }
    }
}

/**
 * Klasse DeleteEingelander, zum Löschen von Usern von Events, deren Einladung noch unbeantwortet ist, entspricht Klasse DeleteUserFromEvent
 *
 * @author	Paul Mazzolini
 * @version  06062018
 */
class DeleteEingeladener extends OrganisatorCommand
{
    private $eventname;
	private $username;

    function __construct($event, $user){
        $this->eventname = $event;
		$this->username = $user;
    }

    public function execute(){
        $dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
        
        $uid = "SELECT id FROM benutzer WHERE name = '$this->username';";
        $sql = pg_query($dbconn, $uid);
        $row = pg_fetch_row($sql);
        
        $eid = "SELECT id FROM event WHERE name = '$this->eventname';";
        $sql = pg_query($dbconn, $eid);
        $ide = pg_fetch_row($sql);

        $acc = "SELECT angenommen FROM teilnehmer WHERE usr = '$row[0]' AND event ='$ide[0]';";
        $sql = pg_query($dbconn, $acc);
        $ang = pg_fetch_row($sql);
        
        if($ang[0] == 'f'){
			$eventselect = "SELECT id FROM event WHERE name = '$this->eventname';";
			$sql = pg_query($dbconn, $eventselect);
			$eventid = pg_fetch_row($sql);
			
			$userselect = "SELECT id FROM benutzer WHERE name = '$this->username';";
			$sql = pg_query($dbconn, $userselect);
			$userid = pg_fetch_row($sql);
			
			$deletequery = "DELETE FROM teilnehmer WHERE usr = '$userid[0]' AND event = '$eventid[0]' AND angenommen='false';";
			$sql = pg_query($dbconn, $deletequery);
			
			header("Location: eventView_Ersteller.php");
        }else{
            echo "<script type='text/javascript'>alert('User kann nicht gelöscht werden, da er bereits angenommen hat.');</script>";
        }
    }
}

/**
 * Klasse DeleteDate, zum Löschen eines Datums eines Events
 *
 * @author	Paul Mazzolini
 * @version  06072018
 */
class DeleteDate extends OrganisatorCommand
{
    private $eventname;
	private $datename;

    function __construct($event, $datename){
        $this->eventname = $event;
		$this->datename = $datename;
    }

    public function execute(){
        $dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		
		$eventselect = "SELECT id FROM event WHERE name = '$this->eventname';";
		$sql = pg_query($dbconn, $eventselect);
		$eventid = pg_fetch_row($sql);
		
		$deletedate = "DELETE FROM datum WHERE eventid = '$eventid[0]' AND date='$this->datename';";
		$sql = pg_query($dbconn, $deletedate);
		
		header("Location: eventView_Ersteller.php");
    }
}

/**
 * Klasse AddUserToEvent, zum Hinzufügen von einem User zu einem Event
 *
 * @author	Paul Mazzolini
 * @version  06072018
 */
class AddUserToEvent extends OrganisatorCommand
{
    private $eventname;
	private $username;

    function __construct($eventname, $username){
        $this->eventname = $eventname;
		$this->username = $username;
    }

    public function execute(){
        $dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		
		$eventselect = "SELECT id FROM event WHERE name = '$this->eventname';";
		$sql = pg_query($dbconn, $eventselect);
		$eventid = pg_fetch_row($sql);
		
		$userselect = "SELECT id FROM benutzer WHERE name = '$this->username';";
		$sql = pg_query($dbconn, $userselect);
		$userid = pg_fetch_row($sql);
		
		$add = "INSERT INTO teilnehmer VALUES('$userid[0]','$eventid[0]', false);";
		$user = pg_query($dbconn, $add);
		
		header("Location: eventView_Ersteller.php");
    }
}

/**
 * Klasse AddDate, zum Hinzufügen von einem Date zu einem Event
 *
 * @author	Paul Mazzolini
 * @version  06072018
 */
class AddDate extends OrganisatorCommand
{
    private $eventname;
	private $datename;

    function __construct($eventname, $datename){
        $this->eventname = $eventname;
		$this->datename = $datename;
    }

    public function execute(){
        $dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		
		$eventselect = "SELECT id FROM event WHERE name = '$this->eventname';";
		$sql = pg_query($dbconn, $eventselect);
		$eventid = pg_fetch_row($sql);
		
		$add = "INSERT INTO datum VALUES('$eventid[0]','$this->datename');";
		$user = pg_query($dbconn, $add);
		
		header("Location: eventView_Ersteller.php");
    }
}

/**
 * Klasse SetFixedEventDate, zum setzen eines fixen Event Dates eines Events
 *
 * @author	Paul Mazzolini & Michael Wintersperger
 * @version  06072018
 */
class SetFixedEventDate extends OrganisatorCommand
{
    private $event;
	private $datename;

    function __construct($event, $datename){
        $this->event = $event;
		$this->datename = $datename;
    }

    public function execute(){
        $dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		
		// ToDo: Fixen Event Date setzen & alle anderen Event-Dates entfernen
    }
}

/**
 * Klasse DeleteComment, zum Löschen von Event Kommentaren
 *
 * @author	Paul Mazzolini & Michael Wintersperger
 * @version  06132018
 */
class DeleteComment extends OrganisatorCommand
{
    private $commentid;

    function __construct($commentid){
        $this->commentid = $commentid;
    }

    public function execute(){
        $dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		$deleteC = "DELETE FROM kommentar WHERE id = '$this->commentid';";
        $delete = pg_query($dbconn, $deleteC);
		header("Location: eventView_Ersteller.php");
    }
}
?>


<?
/**
 * Klasse CommentEvent, zum Kommentieren eines Events
 *
 * @author	Paul Mazzolini & Vincent Schwartz
 * @version  06072018
 */
class CommentEvent extends EventCommand
{
    private $eventname;
    private $username;
    private $comment;

    public function __construct($eventname, $comment, $username) {
        $this->eventname = $eventname;
        $this->comment = $comment;
        $this->username = $username;
    }

    public function execute() {
        $dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
		
		$eventid = "SELECT id from event where name = '$this->eventname'";
        $sqleventid = pg_query($dbconn, $eventid);
        $evntid = pg_fetch_row($sqleventid);

        $userid = "SELECT id from benutzer where name = '$this->username'";
        $sqluserid = pg_query($dbconn, $userid);
        $usrid = pg_fetch_row($sqluserid);

        $addComment = "insert into kommentar(event, comment, usr) values('$evntid[0]','$this->comment','$usrid[0]')";
        pg_query($dbconn, $addComment);
    }
}

/**
 * Klasse SendMailRegister, zum Versenden der Notifications bei der Registrierung
 *
 * @author	Christoph Kern
 * @version  05152018
 */
class SendMailRegister extends EventCommand
{
    private $uname;
    private $email;

    function __construct($email, $username){
        $this->uname = $username;
        $this->email = $email;
    }

    public function execute(){
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;                                
            $mail->isSMTP();                                     
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;                               
            $mail->Username = 'terminreservierung.teamm@gmail.com';                 
            $mail->Password = 'Admin12$';                          
            $mail->SMTPSecure = 'ssl';                           
            $mail->Port = 465;
            $mail->setFrom('terminreservierung.teamm@gmail.com', 'Terminreservierungsteam');
            $mail->addAddress($this->email);
            $mail->isHTML(true);                                 
            $mail->Subject = 'Anmeldung';
            $mail->Body    = 'Liebe/r ' . $this->uname . '. <br \> Sie haben sich erfolgreich bei unserem Terminreservierungssystem registriert! Sie k&ouml;nnen sich nun <a href="https://terminreservierungssystem.herokuapp.com">hier</a> anmelden';
            $mail->AltBody = 'Liebe/r ' . $this->uname . '. <br \> Sie haben sich erfolgreich bei unserem Terminreservierungssystem registriert! Sie k&ouml;nnen sich nun <a href="https://terminreservierungssystem.herokuapp.com" >hier</a> anmelden';
            $mail->send();
        } catch (Exception $e) {
            echo "<script type='text/javascript'>alert('Could not send Message!');</script>";
        }
        header("Location: login.php");
    }
}

/**
 * Klasse SendMailInvitation, zum Versenden der Notifications bei einer neuen Eventeinladung
 *
 * @author	Christoph Kern
 * @version  05152018
 */
class SendMailInvitation extends EventCommand
{
    private $user;
    private $eventName;

    function __construct($username, $eventName){
        $this->eventName = $eventName;
        $this->user = $username;
    }

    public function execute(){
        $xmail = array();
        $mail = new PHPMailer(true);
        try {
            $dbconn = pg_connect("host=ec2-23-23-247-245.compute-1.amazonaws.com port=5432 dbname=de8h555uj0b1mq user=xokkwplhovrges password=56a064f11b2b07249b0497b9f3e6e4ee306fc72b24fd469618658c0738e23e7d");
            foreach($this->user as $people){
                $userMail = "SELECT email FROM benutzer WHERE name = '$people';";
                $sql = pg_query($dbconn, $userMail); 
                $row = pg_fetch_row($sql);
                $mail->SMTPDebug = 0;                                
                $mail->isSMTP();                                     
                $mail->Host = 'smtp.gmail.com';  
                $mail->SMTPAuth = true;                               
                $mail->Username = 'terminreservierung.teamm@gmail.com';                 
                $mail->Password = 'Admin12$';                          
                $mail->SMTPSecure = 'ssl';                           
                $mail->Port = 465;
                $mail->setFrom('terminreservierung.teamm@gmail.com', 'Terminreservierungsteam');
                $mail->addAddress($row[0]);
                $mail->isHTML(true); 
                $mail->Subject = 'Einladung';
                $mail->Body    = 'Liebe/r ' . $people . '. <br \> Sie wurden zu dem Event ' . $this->eventName . ' eingeladen! <a href="https://terminreservierungssystem.herokuapp.com">Hier</a> k&ouml;nnen Sie auf die Einladung antworten.';
                $mail->AltBody = 'Liebe/r ' . $people . '. <br \> Sie wurden zu dem Event ' . $this->eventName . ' eingeladen! <a href="https://terminreservierungssystem.herokuapp.com">Hier</a> k&ouml;nnen Sie auf die Einladung antworten.';

                echo "<script type='text/javascript'>alert($row[0]);</script>";

                $mail->send();
            }
        } catch (Exception $e) {
			echo "<script type='text/javascript'>alert('Could not send Message!');</script>";
        }
    }
}
?>