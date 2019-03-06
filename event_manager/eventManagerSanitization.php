<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/27/2019
 * Time: 11:30 AM
 */

require_once (dirname(__FILE__) . '/../phpScripts/sanitize.php');

$recordsDeleted = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // adding a user
    if(isset($_POST['addUser'])) {
        $requiredFields = array('addUserID', 'addEventAssoc');
        $dirtyData = [];
        foreach($requiredFields as $requiredField) {
            if(!isset($_POST[$requiredField]) || empty($_POST[$requiredField])) {
                return $userStatus = 'One of the required fields is missing';
            }
            else {
                $dirtyData[] = $_POST[$requiredField];
            }
        }
        // sanitize the data
        $cleanedData = sanitize($dirtyData);
        $userStatus = $event_manager->addUserToEvent($cleanedData);
    }

    // editing a user
    if(isset($_POST['editUser'])) {
        $requiredFields = array('editUserID', 'editEventAssoc');
        $dirtyData = [];
        foreach ($requiredFields as $requiredField) {
            if (!isset($_POST[$requiredField]) || empty($_POST[$requiredField])) {
                return $userStatus = 'One of the required fields is missing';
            } else {
                $dirtyData[] = $_POST[$requiredField];
            }
        }
        // sanitize the data
        $cleanedData = sanitize($dirtyData);

        $userStatus = $event_manager->editUserEvent($cleanedData);
    }


    if(isset($_POST['deleteUser'])) {
        $requiredFields = array('deleteUserByID', 'deleteEventAssoc');
        $dirtyData = [];
        if(isset($_POST['deleteUserByID']) && !empty($_POST['deleteUserByID']) && is_numeric($_POST['deleteUserByID'])) {
            $dirtyData = [];
            foreach ($requiredFields as $requiredField) {
                if (!isset($_POST[$requiredField])) {
                    return $userStatus = 'One of the required fields is missing';
                } else {
                    $dirtyData[] = $_POST[$requiredField];
                }
            }
        }
            // sanitize the data
            $cleanedData = sanitize($dirtyData);

            $userStatus = $event_manager->deleteUserEvent($cleanedData);
    }

    if(isset($_POST['addEvent'])) {
        $requiredFields = array('addEventName', 'addEventStartDate', 'addEventEndDate', 'addEventMaxCap', 'addAssocVenue');
        $dirtyData = [];
        foreach($requiredFields as $requiredField) {
            if(!isset($_POST[$requiredField]) || empty($_POST[$requiredField])) {
                return $eventStatus = 'One of the required fields is missing';
            }

            // for the dates
            if($requiredField == 'addEventStartDate' || $requiredField == 'addEventEndDate') {
                $newDate = $_POST[$requiredField];
                $newDate = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $newDate);
                $dirtyData[] = $newDate;
            }
            else {
                $dirtyData[] = $_POST[$requiredField];
            }
        }
        // sanitize the data
        $cleanedData = sanitize($dirtyData);

        $eventStatus = $event_manager->addEvent($cleanedData);
    }

    if(isset($_POST['editEvent'])) {
        $possibleFields = ['editEventID', 'editEventName', 'editEventStartDate', 'editEventEndDate', 'editEventMaxCap', 'editAssocVenue'];
        $editData = [];
        if(isset($_POST['editEventID']) && !empty($_POST['editEventID'] && is_numeric($_POST['editEventID']))) {
            foreach($possibleFields as $possibleField) {
                if(!empty($_POST[$possibleField])) {
                    $editData[] = $possibleField;
                }
            }
            $eventStatus = $event_manager->editEvent($editData);
        }
        else {
            return $eventStatus = "Check the ID. Must be a number.";
        }
    }

    if(isset($_POST['deleteEvent'])) {
        $dirtyData = [];
        $dirtyData[] = $_POST['deleteEventID'];
        $cleanedData = sanitize($dirtyData);
        $eventStatus = $event_manager->deleteEvent($cleanedData);
    }


    // add session
    if(isset($_POST['addSession'])) {
        $requiredFields = array('addSessionEventID', 'addSessionName', 'addSessionCapacity', 'addAssocEvent', 'addSessionStartDate', 'addSessionEndDate');
        $dirtyData = [];
        foreach($requiredFields as $requiredField) {
            if(!isset($_POST[$requiredField]) || empty($_POST[$requiredField])) {
                return $sessionStatus = 'One of the required fields is missing';
            }
            else {
                $dirtyData[] = $_POST[$requiredField];
            }
        }
        // sanitize the data
        $cleanedData = sanitize($dirtyData);
        $sessionStatus = $event_manager->addSession($cleanedData);
    }


    // edit session
    if(isset($_POST['editSession'])) {
        $possibleFields = ['editSessionEventID', 'editSessionID', 'editSessionName', 'editSessionMaxCap', 'editSessionEvent', 'editSessionStartDate', 'editSessionEndDate'];
        $editData = [];

        if(isset($_POST['editSessionID']) && !empty($_POST['editSessionID'] && is_numeric($_POST['editSessionID']))) {
            foreach($possibleFields as $possibleField) {
                if(!empty($_POST[$possibleField])) {
                    $editData[] = $possibleField;
                }
            }
            $sessionStatus = $event_manager->editSession($editData);
        }
        else {
            $sessionStatus = "Check the IDs. They need to be numbers and not empty.";
        }
    }


    // delete session
    if(isset($_POST['deleteSession'])) {
        $dirtyData = [];

        if(isset($_POST['deleteUserByID']) && !empty($_POST['deleteUserByID']) && is_numeric($_POST['deleteUserByID'])) {
            $dirtyData[] = $_POST['deleteSessionName'];
            $cleanedData = sanitize($dirtyData);
            $sessionStatus = $event_manager->deleteSession($cleanedData);
        }
        else {
            return $sessionStatus = "The ID needs to be a number";
        }
    }

}
