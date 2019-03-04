<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 5:18 PM
 */

require_once ('../db/DB.class.php');

class EventManagerClass {

    private $username;
    private $db;

    function __construct($name) {
        $this->username = $name;
        $this->db = DB::getInstance();
    }

    // attendees data
    function getAllAttendees() {
        $records = $this->db->viewAllManagedAttendees();
        return $records;
    }

    function getAttendeeTableColumns() {
        return $this->db->getAttendeeTableColumns();
    }

    // events data
    function getAllEvents() {
        $records = $this->db->viewAllManagedEvents();
        return $records;
    }

    function getEventTableColumns() {
        return $this->db->getEventTableColumns();
    }

    // events data
    function getAllSessions() {
        $records = $this->db->viewAllManagedSessions();
        return $records;
    }

    function getSessionTableColumns() {
        return $this->db->getSessionTableColumns();
    }


    // render functions
    function renderAttendeeListAndOptions() {
        foreach($this->getAttendeeTableColumns() as $column => $columnName) {
            if($columnName['column_name'] != 'password') {
                echo "<th>$columnName[column_name]</th>";
            }
        }
        foreach($this->getAllAttendees() as $attendee => $attendeeInfo) {
            echo "<tr><td>$attendeeInfo[idattendee]</td><td>$attendeeInfo[name]</td><td>$attendeeInfo[role]</td></tr>";
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
}