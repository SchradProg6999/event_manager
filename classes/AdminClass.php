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

            return $this->db->addUser($name, $password, $role);
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
        return $this->db->editUser($data);
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

    // session functions
    function addSession($data) {
        return $this->db->addSession($data);
    }

    function editSession($data) {
        return $this->db->editSession($data);
    }

    function deleteSession($data) {
        return $this->db->deleteSession($data);
    }

    function viewAllSessions() {
        return $this->db->viewAllSessions();
    }

    function renderEventListAndOptions() {
        foreach($this->getEventTableColumns() as $column => $columnName) {
            echo "<th>$columnName[column_name]</th>";
        }
        foreach($this->getAllEvents() as $event => $eventInfo) {
            echo "<tr><td>$eventInfo[idevent]</td><td>$eventInfo[name]</td><td>$eventInfo[datestart]</td><td>$eventInfo[dateend]</td><td>$eventInfo[numberallowed]</td><td>$eventInfo[venue]</td></tr>";
        }
    }
} // end of class