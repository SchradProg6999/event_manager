<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 12:35 PM
 */

class DB {
    private $dbh;

    function __construct() {
        try {
            $this->dbh = new PDO("mysql:host={$_SERVER['DB_SERVER']};dbname={$_SERVER['DB']}", $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD']);
        } catch (PDOException $e) {
            die("Pdo Exception thrown");
        }
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
        }
    }

    private function checkRoleAndRedirect($role) {
        // check role for admin permissions
        switch($role){
            case '1':
                $_SESSION['admin'] = true;
                //header('Location: admin.php');
                echo 'admin permissions';
                break;
            case '2':
                $_SESSION['event_manager'] = true;
                // header('Location: admin.php')
                echo 'event manager permissions';
                break;
            case '3':
                // regular user
                $_SESSION['attendee'] = true;
                //header('Location: events.php');
                echo 'regular attendee';
                break;
            default:
                echo 'regular attendee';
        }
    }
} // end of class
?>