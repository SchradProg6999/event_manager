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

    // user functions
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

    function deleteUser($data) {
        $recordsDeleted = $this->db->deleteUser($data[0]);
        return $recordsDeleted;
    }

    // event functions
    function addEvent($data) {
        return $this->db->addEvent($data);
    }

    function editEvent($data) {
        return $this->db->editEvent($data);
    }

    function deleteEvent($data) {
        return $this->db->deleteEvent($data);
    }

    function viewAllEvents() {
        return $this->db->viewAllEvents();
    }

    // venue functions
    function addVenue($data) {
        $name = $data[0];
        $cap = $data[1];
        return $this->db->addVenue($name, $cap);
    }

    function editVenue($data) {
        return $this->db->editVenue($data);
    }

    function deleteVenue($data) {
        return $this->db->deleteVenue($data);
    }

    function viewAllVenues() {
        return $this->db->viewAllVenues();
    }
} // end of class