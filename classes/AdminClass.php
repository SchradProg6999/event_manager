<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 1:54 PM
 */

require_once (dirname(__FILE__) . '/../db/DB.class.php');

class AdminClass {

    private $username;
    private $db;

    function __construct($name) {
        $this->username = $name;
        $this->db = DB::getInstance();
    }



    // getting column name functions
    function getAttendeeTableColumns() {
        return $this->db->getAttendeeTableColumns();
    }

    function getEventTableColumns() {
        return $this->db->getEventTableColumns();
    }

    function getSessionTableColumns() {
        return $this->db->getSessionTableColumns();
    }

    function getVenueTableColumns() {
        return $this->db->getVenueTableColumns();
    }



    // rendering data functions
    function renderAttendeeListAndOptions() {
        foreach($this->getAttendeeTableColumns() as $column => $columnName) {
            if($columnName['column_name'] != 'password') {
                echo "<th>$columnName[column_name]</th>";
            }
        }
        foreach($this->getAllUsers() as $attendee => $attendeeInfo) {
            echo "<tr><td>$attendeeInfo[idattendee]</td><td>$attendeeInfo[name]</td><td>$attendeeInfo[role]</td></tr>";
        }
    }


    function renderEventListAndOptions() {
        foreach($this->getEventTableColumns() as $column => $columnName) {
            echo "<th>$columnName[column_name]</th>";
        }
        foreach($this->viewAllEvents() as $event => $eventInfo) {
            echo "<tr><td>$eventInfo[idevent]</td><td>$eventInfo[name]</td><td>$eventInfo[datestart]</td><td>$eventInfo[dateend]</td><td>$eventInfo[numberallowed]</td><td>$eventInfo[venue]</td></tr>";
        }
    }


    function renderSessionListAndOptions() {
        foreach($this->getSessionTableColumns() as $column => $columnName) {
            echo "<th>$columnName[column_name]</th>";
        }
        foreach($this->viewAllSessions() as $session => $sessionInfo) {
            echo "<tr><td>$sessionInfo[idsession]</td><td>$sessionInfo[name]</td><td>$sessionInfo[numberallowed]</td><td>$sessionInfo[event]</td><td>$sessionInfo[startdate]</td><td>$sessionInfo[enddate]</td></tr>";
        }
    }

    function renderVenueListAndOptions() {
        foreach($this->getVenueTableColumns() as $column => $columnName) {
            echo "<th>$columnName[column_name]</th>";
        }
        foreach($this->viewAllVenues() as $venue=> $venueInfo) {
            echo "<tr><td>$venueInfo[idvenue]</td><td>$venueInfo[name]</td><td>$venueInfo[capacity]</td></tr>";
        }
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

    function getAllUsers() {
        return $this->db->getAllUsers();
    }

    // event functions
    function addEvent($data) {
        // check if venue is even existing before we make the event
        // then get the last query of the event table(the one we just created) and use that
        // to link the session that will be generated automatically after the event is generated.

        $venueFound = $this->db->getVenueByID($data['addAssocVenue']);
        $adminFound = $this->db->viewUserById($data['addAdminEvent']);
        $managerFound = $this->db->viewUserById($data['addEventManagerEvent']);

        if($venueFound > 0 && $adminFound['role'] === '1' && $managerFound['role'] === '2') {
            if($this->db->addEvent($data) > 0) {
                $eventID = $this->db->getLastEvent();

                $sessionData = ["addSessionEvent" => $data['addSessionEvent'], "addSessionEventCap" => $data['addSessionEventCap'],
                    "eventID" => $eventID[0], "addSessionStartDateEvent" => $data['addSessionStartDateEvent'],
                    "addSessionEndDateEvent" => $data['addSessionEndDateEvent']];
                $sessionStatus = $this->db->addSession($sessionData);
                if($sessionStatus > 0) {
                    $adminEventData = ["eventID" => $eventID[0], "attendeeID" => $adminFound['idattendee'], "paid" => 0];
                    $managerEventData = ["eventID" => $eventID[0], "attendeeID" => $managerFound['idattendee'], "paid" => 0];
                    $this->db->addAttendeeEventRecord($adminEventData);
                    $this->db->addAttendeeEventRecord($managerEventData);
                    $this->db->addManagerEventRecord(["eventID" => $eventID[0], "managerID" => $managerFound['idattendee']]);
                }
                else {
                    return -1;
                }
            }
        }
        else {
            return -1;
        }
    }

    function editEvent($data) {
        return $this->db->editEvent($data);
    }

    function deleteEvent($data) {
        // upon deletion of an event, the session needs to be deleted as well as any record that had any reference to
        // that event in the associative tables
        if($this->db->deleteEvent($data) > 0) {
            $this->db->deleteAttendeeSessionRecords($data);
        }

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
        // must mean the event exists
        if($this->db->getEventById($data['eventID']) !== false) {
            return $this->db->addSession($data);
        }
        else {
            return -1;
        }
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

} // end of class