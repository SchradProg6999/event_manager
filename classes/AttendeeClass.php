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
        $this->db = new DB();
    }
}