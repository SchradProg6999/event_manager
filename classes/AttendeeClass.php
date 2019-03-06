<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 5:20 PM
 */

require_once ('../db/DB.class.php');

class AttendeeClass {

    private $name;
    private $db;

    function __construct($name) {
        $this->name = $name;
        $this->db = DB::getInstance();
    }

    function renderEventListAndOptions() {
        foreach($this->getEventTableColumns() as $column => $columnName) {
            echo "<th>$columnName[column_name]</th>";
        }
        foreach($this->getAllEvents() as $event => $eventInfo) {
            echo "<tr><td>$eventInfo[idevent]</td><td>$eventInfo[name]</td><td>$eventInfo[datestart]</td><td>$eventInfo[dateend]</td><td>$eventInfo[numberallowed]</td><td>$eventInfo[venue]</td></tr>";
        }
    }
}