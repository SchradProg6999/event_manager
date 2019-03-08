<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 5:18 PM
 */

require_once (dirname(__FILE__) . '/../db/DB.class.php');

class EventManagerClass {

    private $username;
    private $db;

    function __construct($name) {
        $this->username = $name;
        $this->db = DB::getInstance();
    }

    // attendees data
    function getAllAttendees() {
        $records = $this->db->viewAllManagedAttendees($_SESSION['managerID']);
        return $records;
    }

    function getAttendeeEventTableColumns() {
        return $this->db->getAttendeeEventTableColumns();
    }

    function getAttendeeTableColumns() {
        return $this->db->getAttendeeTableColumns();
    }

    // events data
    function getAllEvents() {
        $records = $this->db->viewAllManagedEvents($_SESSION['managerID']);
        return $records;
    }

    function getEventTableColumns() {
        return $this->db->getEventTableColumns();
    }

    // sessions data
    function getAllSessions() {
        $records = $this->db->viewAllManagedSessions($_SESSION['managerID']);
        return $records;
    }

    function getSessionTableColumns() {
        return $this->db->getSessionTableColumns();
    }


    // render functions
    function renderAttendeeListAndOptions() {
        echo "<th>Attendee ID</th><th>Attendee</th><th>Event ID</th><th>Event</th><th>Money Paid</th><th>Start Date</th><th>End Date</th>";
        foreach($this->getAllAttendees() as $attendee => $attendeeInfo) {
            echo "<tr><td>$attendeeInfo[idattendee]</td><td>$attendeeInfo[name]</td><td>$attendeeInfo[idevent]</td><td>$attendeeInfo[0]</td><td>$$attendeeInfo[paid]</td><td>$attendeeInfo[dateStart]</td><td>$attendeeInfo[dateEnd]</td></tr>";
        }
    }


    function renderEventListAndOptions() {
        foreach($this->getEventTableColumns() as $column => $columnName) {
            echo "<th>$columnName[column_name]</th>";
        }
        foreach($this->getAllEvents() as $event => $eventInfo) {
            echo "<tr><td>$eventInfo[idevent]</td><td>$eventInfo[name]</td><td>$eventInfo[datestart]</td><td>$eventInfo[dateend]</td><td>$eventInfo[numberallowed]</td><td>$eventInfo[venue]</td></tr>";
        }
    }


    function renderSessionListAndOptions() {
        foreach($this->getSessionTableColumns() as $column => $columnName) {
            echo "<th>$columnName[column_name]</th>";
        }
        foreach($this->getAllSessions() as $session => $sessionInfo) {
            echo "<tr><td>$sessionInfo[idsession]</td><td>$sessionInfo[name]</td><td>$sessionInfo[numberallowed]</td><td>$sessionInfo[event]</td><td>$sessionInfo[startdate]</td><td>$sessionInfo[enddate]</td></tr>";
        }
    }



    // attendee functions
    function addUserToEvent($data) {
        // check to make sure they are the event manager for the event
        $validManager = ["managerID" => $_SESSION['managerID'], "eventID" => $data['addEventAssoc']];
        if($this->db->getEventByManagerID($validManager) > 0) {
            $this->db->addAttendeeToEvent($data);
        }
        else {
            return -1;
        }
    }

    function editUserEvent($data) {
        // check to make sure they are the event manager for the event
        $validManager = ["managerID" => $_SESSION['managerID'], "eventID" => $data['editOldEventAssoc']];
        if($this->db->getEventByManagerID($validManager) > 0) {
            $this->db->moveAttendeeToEvent($data);
        }
        else {
            return -1;
        }
    }

    function deleteUserEvent($data) {
        // check to make sure they are the event manager for the event
        $validManager = ["managerID" => $_SESSION['managerID'], "eventID" => $data['deleteEventAssoc']];
        if($this->db->getEventByManagerID($validManager) > 0) {
            $this->db->deleteAttendeeFromEvent(["ID" => $data['deleteUserByID'], "eventID" => $data['deleteEventAssoc']]);
        }
        else {
            return -1;
        }
    }



    // event functions
    function addEvent($data) {
        // check if venue is even existing before we make the event
        // then get the last query of the event table(the one we just created) and use that
        // to link the session that will be generated automatically after the event is generated.

        $venueFound = $this->db->getVenueByID($data['addAssocVenue']);
        $adminFound = $this->db->viewUserById($data['addAdminEvent']);

        if($venueFound > 0 && $adminFound['role'] === '1') {
            if($this->db->addEvent($data) > 0) {
                $eventID = $this->db->getLastEvent();

                $sessionData = ["addSessionEvent" => $data['addSessionEvent'], "addSessionEventCap" => $data['addSessionEventCap'],
                    "eventID" => $eventID[0], "addSessionStartDateEvent" => $data['addSessionStartDateEvent'],
                    "addSessionEndDateEvent" => $data['addSessionEndDateEvent']];
                $sessionStatus = $this->db->addSession($sessionData);
                if($sessionStatus > 0) {
                    $adminEventData = ["eventID" => $eventID[0], "attendeeID" => $adminFound['idattendee'], "paid" => 0];
                    $managerEventData = ["eventID" => $eventID[0], "attendeeID" => $_SESSION['managerID'], "paid" => 0];
                    $this->db->addAttendeeEventRecord($adminEventData);
                    $this->db->addAttendeeEventRecord($managerEventData);
                    $this->db->addManagerEventRecord(["eventID" => $eventID[0], "managerID" => $_SESSION['managerID']]);
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
        // check to make sure they are the event manager for the event
        $validManager = ["managerID" => $_SESSION['managerID'], "eventID" => $_POST[$data[0]]];
        if ($this->db->getEventByManagerID($validManager) > 0) {
            $this->db->editEvent($data);
        }
        else {
            return -1;
        }
    }

    function deleteEvent($data) {
        // check to make sure they are the event manager for the event
        $validManager = ["managerID" => $_SESSION['managerID'], "eventID" => $data['deleteEventID']];
        if ($this->db->getEventByManagerID($validManager) > 0) {
            $this->db->deleteEvent($data);
        }
        else {
            return -1;
        }
    }



    // session functions
    function addSession($data) {
        // check to make sure they are the event manager for the event
        $validManager = ["managerID" => $_SESSION['managerID'], "eventID" => $data['eventID']];
        if ($this->db->getEventByManagerID($validManager) > 0) {
            $this->db->addSession($data);
        }
        else {
            return -1;
        }
    }

    function editSession($data) {
        // check to make sure they are the event manager for the event
        $validManager = ["managerID" => $_SESSION['managerID'], "eventID" => $_POST[$data[0]]];
        if ($this->db->getEventByManagerID($validManager) > 0) {
            // there exists the session in the event they were looking for
            if($this->db->checkSessionInEvent(["eventID" => $_POST[$data[0]], "sessionID" => $_POST[$data[1]]]) > 0) {
                $this->db->editSession($data);
            }
            else {
                return -1;
            }
        }
        else {
            return -1;
        }
    }

    function deleteSession($data) {
        $validManager = ["managerID" => $_SESSION['managerID'], "eventID" => $data['deleteSessionEventID']];
        if ($this->db->getEventByManagerID($validManager) > 0) {
            // there exists the session in the event they were looking to delete
            if($this->db->checkSessionInEvent(["eventID" => $data['deleteSessionEventID'], "sessionID" => $data['deleteSessionID']]) > 0) {
                $this->db->deleteSession(["deleteSessionID" => $data['deleteSessionID']]);
            }
            else {
                return -1;
            }
        }
        else {
            return -1;
        }
    }
}