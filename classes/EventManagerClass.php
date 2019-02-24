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
        $this->db = new DB();
    }

}