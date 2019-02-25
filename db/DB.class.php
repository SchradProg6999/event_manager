<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 12:35 PM
 */

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
        print("<pre>".print_r($userInfo,true)."</pre>");

        // must have received valid username and password
        if($userInfo[0] != "" && count($userInfo) == 1) {
            $_SESSION['username'] = $username;
            $this->checkRoleAndRedirect($userInfo[0]['role']);
        }
        else {
            //$_SESSION['login_error'] = true;
            die();
        }
    }

    private function checkRoleAndRedirect($role) {
        // check role for admin permissions
        switch($role){
            case '1':
                $_SESSION['admin'] = true;
                header('Location: admin.php');
                echo 'admin permissions';
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

    public function deleteUser() {

    }

    public function viewAllUsers() {

    }

    public function viewUserById($id) {
        try {
            $data = [];
            $queryString = "select * from attendee where idattendee = :id";
            $stmt = $this->dbh->prepare($queryString);
            $stmt->execute(['id'=>$id]);
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

} // end of class
?>