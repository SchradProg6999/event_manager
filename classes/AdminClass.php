<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 1:54 PM
 */

require_once ('../db/DB.class.php');

class AdminClass {

    private $username;
    private $db;

    function __construct($name) {
        $this->username = $name;
        $this->db = DB::getInstance();
    }

    function addUser($data) {
        if(count($data) === 3) {
            $name = $data[0];
            $password = hash('sha256', $data[1]);

            // for determining role
            switch($data[2]) {
                case 'admin':
                case '1':
                    $role = 1;
                    break;
                case 'event manager':
                case '2':
                    $role = 2;
                    break;
                case 'attendee':
                case '3':
                    $role = 3;
                    break;
                default:
                    $role = 3;
                    break;
            }

            $this->db->addUser($name, $password, $role);
        }
        else {
            return false;
        }
    }

    function getUserByName($data) {
        $records = [];
        $names = $this->db->viewUserById($data[0]);

        foreach($names as $name) {
            $records[] = $name;
        }

        return $records;
    }

    function editUser($data) {
        $hashedPass = hash('sha256', $data[2]);
        $numRowsEffected = $this->db->editUser($data[0], $data[1], $hashedPass, $data[3]);
        return $numRowsEffected;
    }
} // end of class