<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/24/2019
 * Time: 5:54 PM
 */

function getUserRole($roleNum) {
    switch($roleNum) {
        case '1':
            return "Admin";
        case '2':
            return "Event Manager";
        case '3':
            return "Attendee";
    }
}