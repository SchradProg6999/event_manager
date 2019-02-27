<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/27/2019
 * Time: 11:30 AM
 */

require_once ('../phpScripts/sanitize.php');

$recordsFound = [];
$recordsDeleted = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // adding a user
    if(isset($_POST['addUser'])) {
        $requiredFields = array('addUsername', 'addPassword', 'addRole');
        $dirtyData = [];
        foreach($requiredFields as $requiredField) {
            if(!isset($_POST[$requiredField])) {
                $error = 'One of the required fields is missing';
            }
            else {
                $dirtyData[] = $_POST[$requiredField];
            }
        }
        // sanitize the data
        $cleanedData = sanitize($dirtyData);

        $admin->addUser($cleanedData);
    }

    // editing a user
    if(isset($_POST['editUser'])) {
        if(!isset($_POST['editID'])) {
            echo 'Must input a User ID!';
            return $error = "Must input a User ID";
        }
        else {
            $dirtyData = [];
            $requiredFields = array('editID', 'editUsername', 'editPassword', 'editRole');
            foreach($requiredFields as $requiredField) {
                if(isset($_POST[$requiredField])) {
                    $dirtyData[] = $_POST[$requiredField];
                }
                else {
                    return;
                }
            }
            // scrub! scrub! scrub! three toads in a tub!
            $cleanedData = sanitize($dirtyData);
            $editSuccess = $admin->editUser($cleanedData);
        }
    }

    // looking up a user
    if(isset($_POST['findUser'])) {
        $dirtyData = [];
        if(isset($_POST['findUserID'])) {
            $dirtyData[] = $_POST['findUserID'];
            $cleanedData = sanitize($dirtyData);
            $recordsFound = $admin->getUserByName($cleanedData);
        }
    }


    if(isset($_POST['deleteUser'])) {
        $dirtyData = [];
        $dirtyData[] = $_POST['deleteUserByID'];
        $cleanedData = sanitize($dirtyData);
        $recordsDeleted = $admin->deleteUser($cleanedData);
    }

    if(isset($_POST['addEvent'])) {
        $requiredFields = array('addEventName', 'addEventStartDate', 'addEventEndDate', 'addEventMaxCap', 'addAssocVenue');
        $dirtyData = [];
        foreach($requiredFields as $requiredField) {
            if(!isset($_POST[$requiredField]) || empty($_POST[$requiredField])) {
                exit("Query Could not be performed");
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

        $eventAddStatus = $admin->addEvent($cleanedData);
    }

    if(isset($_POST['editEvent'])) {
        $possibleFields = ['editEventID', 'editEventName', 'editEventStartDate', 'editEventEndDate', 'editEventMaxCap', 'editAssocVenue'];
        $editData = [];

        if(isset($_POST['editEventID']) && !empty($_POST['editEventID'])) {
            foreach($possibleFields as $possibleField) {
                //TODO: figure this out
                //var_dump($possibleField);
                // for the dates
//                    if(($possibleField == 'editEventStartDate' || $possibleField == 'editEventEndDate') && !empty($possibleField)) {
//                        $newDate = $_POST[$possibleField];
//                        $newDate = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $newDate);
//                        $dirtyData[] = $newDate;
//                    }
                if(!empty($_POST[$possibleField])) {
                    $editData[] = $possibleField;
                }
            }
            $eventEditStatus = $admin->editEvent($editData);
        }
    }

    if(isset($_POST['deleteEvent'])) {
        $dirtyData = [];
        $dirtyData[] = $_POST['deleteEventName'];
        $cleanedData = sanitize($dirtyData);
        $eventsDeleted = $admin->deleteEvent($cleanedData);
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

        if(isset($_POST['venueID']) && !empty($_POST['venueID'])) {
            foreach($possibleFields as $possibleField) {
                if(!empty($_POST[$possibleField])) {
                    $editData[] = $possibleField;
                }
            }
            $editVenueStatus = $admin->editVenue($editData);
        }
    }


    // delete venue
    if(isset($_POST['deleteVenue'])) {
        $dirtyData = [];
        $dirtyData[] = $_POST['deleteVenueName'];
        $cleanedData = sanitize($dirtyData);
        $venueDeleteStatus = $admin->deleteVenue($cleanedData);
    }


    // add session
    if(isset($_POST['addSession'])) {
        $requiredFields = array('addSessionName', 'addSessionCapacity', 'addAssocEvent', 'addSessionStartDate', 'addSessionEndDate');
        $dirtyData = [];
        foreach($requiredFields as $requiredField) {
            if(isset($_POST[$requiredField])) {
                $dirtyData[] = $_POST[$requiredField];
            }
        }
        // sanitize the data
        $cleanedData = sanitize($dirtyData);
        $addSessionStatus = $admin->addSession($cleanedData);
    }


    // edit session
    if(isset($_POST['editSession'])) {
        $possibleFields = ['venueID', 'editVenueName', 'editVenueMaxCap'];
        $editData = [];

        if(isset($_POST['venueID']) && !empty($_POST['venueID'])) {
            foreach($possibleFields as $possibleField) {
                if(!empty($_POST[$possibleField])) {
                    $editData[] = $possibleField;
                }
            }
            $editSessionStatus = $admin->editSession($editData);
        }
    }


    // delete session
    if(isset($_POST['deleteSession'])) {
        $dirtyData = [];
        $dirtyData[] = $_POST['deleteVenueName'];
        $cleanedData = sanitize($dirtyData);
        $deleteSessionStatus = $admin->deleteSession($cleanedData);
    }

}