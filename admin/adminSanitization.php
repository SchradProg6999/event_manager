<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/27/2019
 * Time: 11:30 AM
 */

require_once (dirname(__FILE__) . '/../phpScripts/sanitize.php');

$recordsFound = [];
$recordsDeleted = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // adding a user
    if(isset($_POST['addUser'])) {
        $requiredFields = array('addUsername', 'addPassword', 'addRole');
        $dirtyData = [];
        foreach($requiredFields as $requiredField) {
            if(!isset($_POST[$requiredField])) {
                return $addUserStatus = 'One of the required fields is missing';
            }
            else {
                $dirtyData[] = $_POST[$requiredField];
            }
        }
        // sanitize the data
        $cleanedData = sanitize($dirtyData);

        $addUserStatus = $admin->addUser($cleanedData);
    }

    // editing a user
    if(isset($_POST['editUser'])) {
        $dirtyData = [];
        if(isset($_POST['editUserID']) && !empty($_POST['editUserID']) && is_numeric($_POST['editUserID'])) {
            $possibleFields = array('editUserID', 'editUsername', 'editUserPassword', 'editUserRole');
            foreach($possibleFields as $possibleField) {
                if(!empty($_POST[$possibleField])) {
                    if($possibleField == 'editUserRole') {
                        if(intval($_POST[$possibleField]) > 3 || intval($_POST[$possibleField]) < 1) {
                            $_POST[$possibleField] = 3;
                            $dirtyData[] = $possibleField;
                        }
                        else {
                            $dirtyData[] = $possibleField;
                        }
                    }
                    else {
                        $dirtyData[] = $possibleField;
                    }
                }
            }
            // scrub! scrub! scrub! three toads in a tub!
            $cleanedData = sanitize($dirtyData);
            $editUserStatus = $admin->editUser($cleanedData);
        }
        else {
            return $editUserStatus = "Something went wrong... Please Try Again";
        }
    }

    // looking up a user
    if(isset($_POST['findUser'])) {
        $dirtyData = [];
        if(isset($_POST['findUserID']) && !empty($_POST['findUserID']) && is_numeric($_POST['findUserID'])) {
            $dirtyData[] = $_POST['findUserID'];
            $cleanedData = sanitize($dirtyData);
            $recordsFound = $admin->getUserByName($cleanedData);
        }
        else {
            $findUserStatus = "Could not find user";
        }
    }


    if(isset($_POST['deleteUser'])) {
        $dirtyData = [];
        if(isset($_POST['deleteUserByID']) && !empty($_POST['deleteUserByID']) && is_numeric($_POST['deleteUserByID'])) {
            $dirtyData[] = $_POST['deleteUserByID'];
            $cleanedData = sanitize($dirtyData);
            $recordsDeleted = $admin->deleteUser($cleanedData);
        }
        else {
            $recordsDeleted = "Record could not be deleted";
        }
    }

    if(isset($_POST['addEvent'])) {
        $requiredFields = array('addEventName', 'addEventStartDate', 'addEventEndDate', 'addEventMaxCap', 'addAssocVenue',
            'addEventManagerEvent', 'addAdminEvent', 'addSessionEvent', 'addSessionEventCap', 'addSessionStartDateEvent', 'addSessionEndDateEvent');
        $dirtyData = [];
        foreach($requiredFields as $requiredField) {
            if(!isset($_POST[$requiredField]) || empty($_POST[$requiredField])) {
                return $eventStatus = "One of the required fields is missing";
            }

            // for the dates
            if($requiredField == 'addEventStartDate' || $requiredField == 'addEventEndDate' || $requiredField == 'addSessionStartDateEvent' || $requiredField == 'addSessionEndDateEvent') {
                $newDate = $_POST[$requiredField];
                $newDate = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $newDate);
                $dirtyData[$requiredField] = $newDate;
            }
            else {
                $dirtyData[$requiredField] = $_POST[$requiredField];
            }
        }
        // sanitize the data
        $cleanedData = sanitize($dirtyData);

        $eventStatus = $admin->addEvent($cleanedData);
    }

    if(isset($_POST['editEvent'])) {
        $possibleFields = ['editEventID', 'editEventName', 'editEventStartDate', 'editEventEndDate', 'editEventMaxCap'];
        $editData = [];
        if(isset($_POST['editEventID']) && !empty($_POST['editEventID'] && is_numeric($_POST['editEventID']))) {
            foreach($possibleFields as $possibleField) {
                if(!empty($_POST[$possibleField])) {
                    $editData[] = $possibleField;
                }
            }
            $eventStatus = $admin->editEvent($editData);
        }
        else {
            return $eventStatus = "Check the ID. Must be a number.";
        }
    }

    if(isset($_POST['deleteEvent'])) {
        $dirtyData = [];
        if(isset($_POST['deleteEventID']) && !empty($_POST['deleteEventID']) && is_numeric($_POST['deleteEventID'])) {
            $dirtyData['deleteEventID'] = $_POST['deleteEventID'];
            $cleanedData = sanitize($dirtyData);
            $eventsDeleted = $admin->deleteEvent($cleanedData);
        }
        else {
            return $eventStatus = "The ID is required";
        }
    }


    // add venue
    if(isset($_POST['addVenue'])) {
        $requiredFields = array('addVenueName', 'addVenueCapacity');
        $dirtyData = [];
        foreach($requiredFields as $requiredField) {
            if(isset($_POST[$requiredField])) {
                $dirtyData[] = $_POST[$requiredField];
            }
        }
        // sanitize the data
        $cleanedData = sanitize($dirtyData);
        $venueAddStatus = $admin->addVenue($cleanedData);
    }


    // edit venue
    if(isset($_POST['editVenue'])) {
        $possibleFields = ['venueID', 'editVenueName', 'editVenueMaxCap'];
        $editData = [];
        if(isset($_POST['editVenueID']) && !empty($_POST['editVenueID'])) {
            foreach($possibleFields as $possibleField) {
                if(!empty($_POST[$possibleField])) {
                    $editData[] = $possibleField;
                }
            }
            $venueStatus = $admin->editVenue($editData);
        }
    }


    // delete venue
    if(isset($_POST['deleteVenue'])) {
        $dirtyData = [];
        if(isset($_POST['deleteVenueID']) && !empty($_POST['deleteVenueID']) && is_numeric($_POST['deleteVenueID'])) {
            $dirtyData[] = $_POST['deleteVenueID'];
            $cleanedData = sanitize($dirtyData);
            $venueDeleteStatus = $admin->deleteVenue($cleanedData);
        }
        else {
            return $venueStatus = "The ID is required";
        }
    }


    // add session
    if(isset($_POST['addSession'])) {
        $requiredFields = array('addSessionEvent', 'addSessionEventCap', 'eventID', 'addSessionStartDateEvent', 'addSessionEndDateEvent');
        $dirtyData = [];
        foreach($requiredFields as $requiredField) {
            if(isset($_POST[$requiredField])) {
                $dirtyData[$requiredField] = $_POST[$requiredField];
            }
            else {
                return $sessionStatus = "One of the required fields is missing";
            }
        }
        // sanitize the data
        $cleanedData = sanitize($dirtyData);
        $sessionStatus = $admin->addSession($cleanedData);
    }


    // edit session
    if(isset($_POST['editSession'])) {
        $possibleFields = ['editSessionID', 'editSessionName', 'editSessionMaxCap', 'editSessionEvent', 'editSessionStartDate', 'editSessionEndDate'];
        $editData = [];

        if(isset($_POST['editSessionID']) && !empty($_POST['editSessionID'] && is_numeric($_POST['editSessionID']))) {
            foreach($possibleFields as $possibleField) {
                if(!empty($_POST[$possibleField])) {
                    $editData[] = $possibleField;
                }
            }
            $sessionStatus = $admin->editSession($editData);
        }
        else {
            $sessionStatus = "Check the ID. It needs to be a number and not empty.";
        }
    }


    // delete session
    if(isset($_POST['deleteSession'])) {
        $dirtyData = [];
        if(isset($_POST['deleteSessionID']) && !empty($_POST['deleteSessionID']) && is_numeric($_POST['deleteSessionID'])) {
            $dirtyData[] = $_POST['deleteSessionID'];
            $cleanedData = sanitize($dirtyData);
            $sessionStatus = $admin->deleteSession($cleanedData);
        }
        else {
            return $sessionStatus = "The ID is required";
        }
    }

}