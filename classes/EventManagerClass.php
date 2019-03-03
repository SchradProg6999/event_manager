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

    function getAllAttendees() {
        $records = $this->db->viewAllManagedAttendees();
        return $records;
    }

    function getAttendeeTableColumns() {
        return $this->db->getAttendeeTableColumns();
    }

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
}