<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 12:35 PM
 */
require_once (dirname(__FILE__) . "/../phpScripts/sanitize.php");

class DB {
    private $dbh;
    private static $instance = false;

    function __construct() {
        try {
            $this->dbh = new PDO("mysql:host={$_SERVER['DB_SERVER']};dbname={$_SERVER['DB']}", $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD']);
        } catch (PDOException $e) {
            die("Unable to connect to database");
        }
    }

    // making database a singleton
    public static function getInstance() {
        if(self::$instance === false) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    public function login($username, $password) {

        $userInfo = [];

        // hash password for comparison
        $hashedPassword = hash('sha256', $password);

        $queryString = "select * from attendee where name = :name and password = :password limit 1";
        $stmt = $this->dbh->prepare($queryString);
        $stmt->execute(
            [
                "name"=>$username,
                "password"=> $hashedPassword
            ]
        );

        $userInfo[] = $stmt->fetch();

        // must have received valid username and password
        if($userInfo[0] != "" && count($userInfo) == 1) {
            $_SESSION['username'] = $username;
            $this->checkRoleAndRedirect($userInfo[0]['role']);
        }
        else {
            return false;
        }
    }

    private function checkRoleAndRedirect($role) {
        // check role for admin permissions
        switch($role){
            case '1':
                $_SESSION['admin_loggedin'] = true;
                header('Location: admin.php');
                break;
            case '2':
                $_SESSION['event_manager_loggedin'] = true;
                header('Location: admin.php');
                break;
            case '3':
                // regular user
                $_SESSION['AttendeeClass'] = true;
                //header('Location: events.php');
                echo 'regular attendee';
                break;
            default:
                echo 'regular attendee';
        }
    }

    // user functions
    public function addUser($name, $password, $role) {
        try {
            $queryString = "insert into attendee (name, password, role) values (:name,:password,:role)";
            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute(
                [
                    "name"=>$name,
                    "password"=> $password,
                    "role"=>$role
                ]
            );
            return $stmt->rowCount();
        }
        catch(PDOException $e) {
            echo $e->getMessage(); // TODO: send user a notification saying that something went wrong
            die();
        }
    }

    public function editUser($data) {
        try {
            $queryString = "update attendee set ";

            foreach($data as $field) {
                switch($field) {
                    case "editUsername":
                        $queryString .= "name = :name,";
                        $executeParams["name"] = $_POST[$field];
                        break;
                    case "editUserPassword":
                        $queryString .= "password = :password,";
                        $executeParams["password"] = hash('sha256', $_POST[$field]);
                        break;
                    case "editUserRole":
                        $queryString .= "role = :role,";
                        $executeParams["role"] = $_POST[$field];
                        break;
                }
            }

            $queryString = rtrim($queryString, ",");
            $queryString .= " where idattendee = :id";
            $executeParams['id'] = intval($_POST['editUserID']);
            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute($executeParams);
            return $stmt->rowCount();
        }
        catch(PDOException $e) {
            echo $e->getMessage(); // TODO: send user a notification saying that something went wrong
            die();
        }
    }

    public function deleteUser($id) {
        try {
            $queryString = "delete from attendee where idattendee = :id";
            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute(['id'=>$id]);
            return $stmt->rowCount();
        }
        catch(PDOException $e) {
            echo $e->getMessage(); // TODO: send user a notification saying that something went wrong
            die();
        }
    }

    public function viewUserById($id) {
        try {
            $data = [];
            $queryString = "select * from attendee where idattendee = :id";
            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute(['id'=>(int)$id]);
            while($row = $stmt->fetch()) {
                $data[] = $row;
            }
            return $data;
        }
        catch(PDOException $e) {
            echo $e->getMessage(); // TODO: send user a notification saying that something went wrong
            die();
        }
    }

    // Events functionality
    public function addEvent($data) {
        try {
            $queryString = "insert into event (name, datestart, dateend, numberallowed, venue) values (:name, :datestart, :dateend, :numberallowed, :venue)";
            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute(
                [
                    "name"=> $data[0],
                    "datestart"=> $data[1],
                    "dateend"=>$data[2],
                    "numberallowed"=>$data[3],
                    "venue"=>$data[4]
                ]
            );
            return $stmt->rowCount();
        }
        catch(PDOException $e) {
            exit();
        }
    }

    public function editEvent($data) {
        try {
            $queryString = "update event set ";
            $executeParams = [];

            foreach($data as $field) {
                switch($field) {
                    case "editEventName":
                        $queryString .= "name = :name,";
                        $executeParams["name"] = $_POST[$field];
                        break;
                    case "editEventStartDate":
                        $queryString .= "datestart = :datestart,";
                        $executeParams["datestart"] = $_POST[$field];
                        break;
                    case "editEventEndDate":
                        $queryString .= "dateend = :dateend,";
                        $executeParams["dateend"] = $_POST[$field];
                        break;
                    case "editEventMaxCap":
                        $queryString .= "numberallowed = :numberallowed,";
                        $executeParams["numberallowed"] = $_POST[$field];
                        break;
                    case "editAssocVenue":
                        $queryString .= "venue = :venue,";
                        $executeParams["venue"] = $_POST[$field];
                        break;
                }
            }

            $queryString = rtrim($queryString, ",");

            $queryString .= " where idevent = :id";
            var_dump($queryString);
            $executeParams['id'] = intval($_POST['editEventID']);
            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute($executeParams);
            return $stmt->rowCount();
        }
        catch(PDOException $e) {
            exit();
        }
    }

    public function deleteEvent($data) {
        try {
            $queryString = "delete from event where name = :name";
            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute(['name'=>$data[0]]);
            return $stmt->rowCount();
        }
        catch(PDOException $e) {
            echo $e->getMessage(); // TODO: send user a notification saying that something went wrong
            die();
        }
    }

    public function viewAllEvents() {
        try {
            $data = [];
            $queryString = "select * from event";
            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute();
            while($row = $stmt->fetch()) {
                $data[] = $row;
            }
            return $data;
        }
        catch(PDOException $e) {
            echo $e->getMessage(); // TODO: send user a notification saying that something went wrong
            die();
        }
    }


    // TODO: venue functionality
    public function addVenue($name, $capacity) {
        try {
            $queryString = "insert into venue (name, capacity) values (:name,:capacity)";
            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute(
                [
                    "name"=>$name,
                    "capacity"=>$capacity
                ]
            );
            return $stmt->rowCount();
        }
        catch(PDOException $e) {
            echo $e->getMessage(); // TODO: send user a notification saying that something went wrong
            die();
        }
    }

    public function editVenue($data) {
        try {
            $queryString = "update venue set ";
            $executeParams = [];

            foreach($data as $field) {
                switch($field) {
                    case "editVenueName":
                        $queryString .= "name = :name,";
                        $executeParams["name"] = $_POST[$field];
                        break;
                    case "editVenueMaxCap":
                        $queryString .= "capacity = :capacity,";
                        $executeParams["capacity"] = $_POST[$field];
                        break;
                }
            }

            $queryString = rtrim($queryString, ",");
            $queryString .= " where idvenue = :id";
            $executeParams['id'] = intval($_POST['editVenueID']);
            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute($executeParams);
            return $stmt->rowCount();
        }
        catch(PDOException $e) {
            exit();
        }
    }

    public function deleteVenue($data) {
        try {
            $queryString = "delete from venue where name = :name";
            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute(['name'=>$data[0]]);
            return $stmt->rowCount();
        }
        catch(PDOException $e) {
            echo $e->getMessage(); // TODO: send user a notification saying that something went wrong
            die();
        }
    }

    public function viewAllVenues() {
        $data = [];

        $queryString = "select * from venue";
        $stmt = $this->dbh->prepare($queryString);
        $stmt->execute();

        while($row=$stmt->fetch()) {
            $data[] = $row;
        }
        return $data;
    }

    // TODO: session functionality
    public function addSession($data) {
        try {
            $queryString = "insert into session (name, numberallowed, event, startdate, enddate) values (:name, :numberallowed, :event, :startdate, :enddate)";
            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute(
                [
                    "name"=> $data[0],
                    "numberallowed"=>$data[1],
                    "event"=>$data[2],
                    "startdate"=> $data[3],
                    "enddate"=>$data[4]
                ]
            );
            return $stmt->rowCount();
        }
        catch(PDOException $e) {
            exit();
        }
    }

    public function editSession($data) {
        try {
            $queryString = "update session set ";
            $executeParams = [];

            foreach($data as $field) {
                switch($field) {
                    case "editSessionName":
                        $queryString .= "name = :name,";
                        $executeParams["name"] = $_POST[$field];
                        break;
                    case "editSessionMaxCap":
                        $queryString .= "numberallowed = :numberallowed,";
                        $executeParams["numberallowed"] = $_POST[$field];
                        break;
                    case "editSessionEvent":
                        $queryString .= "event = :event,";
                        $executeParams["event"] = $_POST[$field];
                        break;
                    case "editSessionStartDate":
                        $queryString .= "startdate = :startdate,";
                        $executeParams["startdate"] = $_POST[$field];
                        break;
                    case "editSessionEndDate":
                        $queryString .= "enddate = :enddate,";
                        $executeParams["enddate"] = $_POST[$field];
                        break;
                }
            }

            $queryString = rtrim($queryString, ",");
            $queryString .= " where idsession = :id";
            $executeParams['id'] = intval($_POST['editSessionID']);
            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute($executeParams);
            return $stmt->rowCount();
        }
        catch(PDOException $e) {
            exit();
        }
    }

    public function deleteSession($data) {
        try {
            $queryString = "delete from session where name = :name";
            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute(['name'=>$data[0]]);
            return $stmt->rowCount();
        }
        catch(PDOException $e) {
            echo $e->getMessage(); // TODO: send user a notification saying that something went wrong
            die();
        }
    }

    public function viewAllSessions() {
        $data = [];

        $queryString = "select * from session";
        $stmt = $this->dbh->prepare($queryString);
        $stmt->execute();

        while($row=$stmt->fetch()) {
            $data[] = $row;
        }
        return $data;
    }

    // getting column names
    public function getAttendeeTableColumns() {
        $data = [];

        $queryString = "select column_name from information_schema.columns where table_schema = 'jas6531' and table_name = 'attendee'";
        $stmt = $this->dbh->prepare($queryString);
        $stmt->execute();

        while($row=$stmt->fetch()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getEventTableColumns() {
        $data = [];

        $queryString = "select column_name from information_schema.columns where table_schema = 'jas6531' and table_name = 'event'";
        $stmt = $this->dbh->prepare($queryString);
        $stmt->execute();

        while($row=$stmt->fetch()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getSessionTableColumns() {
        $data = [];

        $queryString = "select column_name from information_schema.columns where table_schema = 'jas6531' and table_name = 'session'";
        $stmt = $this->dbh->prepare($queryString);
        $stmt->execute();

        while($row=$stmt->fetch()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getVenueTableColumns() {
        $data = [];

        $queryString = "select column_name from information_schema.columns where table_schema = 'jas6531' and table_name = 'venue'";
        $stmt = $this->dbh->prepare($queryString);
        $stmt->execute();

        while($row=$stmt->fetch()) {
            $data[] = $row;
        }
        return $data;
    }


    // event manager functions

    public function viewAllManagedAttendees() {
        $data = [];

        $queryString = "select * from attendee";
        $stmt = $this->dbh->prepare($queryString);
        $stmt->execute();

        while($row=$stmt->fetch()) {
            $data[] = $row;
        }
        return $data;
    }

    public function viewAllManagedEvents() {
        $data = [];

        $queryString = "select * from event";
        $stmt = $this->dbh->prepare($queryString);
        $stmt->execute();

        while($row=$stmt->fetch()) {
            $data[] = $row;
        }
        return $data;
    }

    public function viewAllManagedSessions() {
        $data = [];

        $queryString = "select * from session";
        $stmt = $this->dbh->prepare($queryString);
        $stmt->execute();

        while($row=$stmt->fetch()) {
            $data[] = $row;
        }
        return $data;
    }

} // end of class
?>