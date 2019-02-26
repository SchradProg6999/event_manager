<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 12:35 PM
 */

require_once ("../phpScripts/sanitize.php");

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
                $_SESSION['admin'] = true;
                header('Location: admin.php');
                break;
            case '2':
                $_SESSION['event_manager'] = true;
                // header('Location: admin.php')
                echo 'event manager permissions';
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

    public function editUser($id, $name, $password, $role) {
        try {

            $queryString = "update attendee set name = :name, password = :password, role = :role where idattendee = :id";

            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute(
                [
                    "id" => $id,
                    "name" => $name,
                    "password" => $password,
                    "role" => $role
                ]
            );
            return $stmt->rowCount();

            // user only put in an id so dont even try the query
//            if(count($fields) == 1) {
//                exit();
//            }

//            foreach($fields as $field) {
//                switch($field) {
//                    case "name":
//                        $queryString .= "name = :name,";
//                        break;
//                    case "password":
//                        $queryString .= "password = :password,";
//                        break;
//                    case "role":
//                        $queryString .= "role = :role";
//                        break;
//                }
//            }
            //$queryString .= "where idattendee = :id";

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
                        var_dump($_POST[$field]);
                        break;
                    case "editVenueMaxCap":
                        $queryString .= "capacity = :capacity,";
                        $executeParams["capacity"] = $_POST[$field];
                        break;
                }
            }

            $queryString = rtrim($queryString, ",");
            $queryString .= " where idvenue = :id";
            $executeParams['id'] = intval($_POST['venueID']);
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
    public function addSession() {

    }

    public function editSession() {

    }

    public function deleteSession() {

    }

    public function viewAllSessions() {

    }

} // end of class
?>