<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 1:54 PM
 */

class User {

    private $username;
    private $role;

    function __construct($name, $role) {
        $this->username = $name;
        $this->role = $role;
    }
} // end of class