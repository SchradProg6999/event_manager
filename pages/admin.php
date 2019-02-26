<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 10:45 AM
 */

    require_once ('../classes/AdminClass.php');
    require_once ('../classes/EventManagerClass.php');
    require_once ('../phpScripts/sanitize.php');
    require_once ('../phpScripts/getuserrole.php');

    session_name('login');
    session_start();

    $recordsFound = [];
    $recordsDeleted = "";

    if($_SESSION['admin'] === true) {
        $admin = new AdminClass($_SESSION['username']);
    }
    else if($_SESSION['event_manager'] === true) {
        $eventManager = new EventManagerClass($_SESSION['username']);
    }
    else { // user tried to directly access admin page without logging in
        $_SESSION['redirected'] = true;
        header('Location: login.php');
    }

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

            $admin->addEvent($cleanedData);
        }

        if(isset($_POST['addEvent'])) {
            $dirtyData = [];
            foreach($requiredFields as $requiredField) {
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

            $admin->editEvent($cleanedData);
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
                $admin->editEvent($editData);
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
            $venueAdded = $admin->addVenue($cleanedData);
        }

        if(isset($_POST['editVenue'])) {
            $possibleFields = ['venueID', 'editVenueName', 'editVenueMaxCap'];
            $editData = [];

            if(isset($_POST['venueID']) && !empty($_POST['venueID'])) {
                foreach($possibleFields as $possibleField) {
                    if(!empty($_POST[$possibleField])) {
                        $editData[] = $possibleField;
                    }
                }
                $editVenueSuccess = $admin->editVenue($editData);
            }
        }

        if(isset($_POST['deleteVenue'])) {
            $dirtyData = [];
            $dirtyData[] = $_POST['deleteVenueName'];
            $cleanedData = sanitize($dirtyData);
            $venuesDeleted = $admin->deleteVenue($cleanedData);
        }
    }

?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <link rel="stylesheet" href='../assets/css/main.css'>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="col-md-12">
        <h1>Good day, <?php echo $_SESSION['username']?>! </h1>
    </div>
    <!--  USER OPTIONS  -->
    <div class="container container-block">
        <h2 class="admin-control-header">User Options</h2>
        <div class="row">
            <div class="col-md-3">
                <h3>Add User</h3>
                <form action="" method="post">
                    <label class="label-inline">Username: </label><input type="text" name="addUsername"><br>
                    <label class="label-inline">Password: </label><input type="password" name="addPassword"><br>
                    <label class="label-inline">Role: </label><input type="text" name="addRole"><br>
                    <input type="submit" name="addUser" value="Add">
                </form>
            </div>
            <div class="col-md-3">
                <h3>Edit User</h3>
                <form action="" method="post">
                    <label class="label-inline">ID: </label><input type="text" name="editID" required><br>
                    <label class="label-inline">Username: </label><input type="text" name="editUsername"><br>
                    <label class="label-inline">Password: </label><input type="password" name="editPassword"><br>
                    <label class="label-inline">Role: </label><input type="text" name="editRole"><br>
                    <input type="submit" name="editUser" value="Edit">
                </form>
            </div>
            <div class="col-md-3">
                <h3>Delete User</h3>
                <form action="" method="post">
                    <label class="label-inline">UserID: </label><input type="text" name="deleteUserByID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br>
                    <input type="submit" name="deleteUser" value="Delete">
                </form>
                <div>
                    <?php
                        if(isset($_POST['deleteUser'])) {
                            if($recordsDeleted > 0) {
                                echo "<p>Record Deleted Successfully!</p>";
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="col-md-3">
                <h3>Find User</h3>
                <form action="" method="post">
                    <label class="label-inline">UserID: </label><input type="text" name="findUserID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br>
                    <input type="submit" name="findUser" value="Search">
                </form>
            </div>
            <div class="records-found">
                <?php
                    if(isset($_POST['findUser'])) {
                        if(sizeof($recordsFound) > 0) {
                            echo "<h4>Record Found!</h4>";
                            foreach($recordsFound as $record) {
                                echo "<p>UserName: <span class='admin-user-lookup-info'>$record[name]</span></p><p>Role: <span class='admin-user-lookup-info'>" . getUserRole($record['role']) . "</span></p>";
                            }
                        }
                        else {
                            echo "<h4>No Records Found!</h4>";
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <!--  EVENT OPTIONS  -->
    <div class="container container-block">
        <h2 class="admin-control-header">Event Options</h2>
        <div class="row">
            <div class="col-md-3">
                <h3>Add Event</h3>
                <form action="" method="post">
                    <label class="label-inline">Event Name: </label><input type="text" name="addEventName" required><br>
                    <label class="label-inline">Start Date: </label><input type="text" name="addEventStartDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br>
                    <label class="label-inline">End Date: </label><input type="text" name="addEventEndDate" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br>
                    <label class="label-inline">Maximum Capacity: </label><input type="text" name="addEventMaxCap"><br>
                    <label class="label-inline">Associated Venue: </label><input type="text" name="addAssocVenue"><br>
                    <input type="submit" name="addEvent" value="Add">
                </form>
            </div>
            <div class="col-md-3">
                <h3>Edit Event</h3>
                <form action="" method="post">
                    <label class="label-inline">Event ID: </label><input type="text" name="editEventID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br>
                    <label class="label-inline">Event Name: </label><input type="text" name="editEventName"><br>
                    <label class="label-inline">Start Date: </label><input type="text" name="editEventStartDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br>
                    <label class="label-inline">End Date: </label><input type="text" name="editEventEndDate" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br>
                    <label class="label-inline">Maximum Capacity: </label><input type="text" name="editEventMaxCap"><br>
                    <label class="label-inline">Associated Venue: </label><input type="text" name="editAssocVenue"><br>
                    <input type="submit" name="editEvent" value="Edit">
                </form>
            </div>
            <div class="col-md-3">
                <h3>Delete Event</h3>
                <form action="" method="post">
                    <label class="label-inline">Event Name: </label><input type="text" name="deleteEventName" required><br>
                    <input type="submit" name="deleteEvent" value="Delete">
                </form>
                <div>
                    <?php
                        if(isset($_POST['deleteEvent'])) {
                            if($eventsDeleted > 0) {
                                echo "<p>Event Deleted Successfully!</p>";
                            }
                            else {
                                echo "<p>No Event Found</p>";
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="col-md-3">
                <h3>Events List</h3>
                <div class="events-list">
                    <?php
                        if(isset($admin) && !empty($admin)) {
                            foreach($admin->viewAllEvents() as $event) {
                                echo "<p class='admin-block-info'>
                                        <span class='event-row-header'>Name:</span> $event[name]<br />
                                        <span class='event-row-header'>Start Date:</span> $event[datestart]<br />
                                        <span class='event-row-header'>Max Capacity:</span> $event[numberallowed]<br />
                                        <span class='event-row-header'>End Date:</span> $event[dateend]<br />
                                        <span class='event-row-header'>Venue Number:</span> $event[venue]
                                      </p>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!--  VENUE OPTIONS  -->
    <div class="container container-block">
        <h2 class="admin-control-header">Venue Options</h2>
        <div class="row">
            <div class="col-md-3">
                <h3>Add Venue</h3>
                <form action="" method="post">
                    <label class="label-inline">Venue Name: </label><input type="text" name="addVenueName" required><br>
                    <label class="label-inline">Max Capacity: </label><input type="text" name="addVenueCapacity">
                    <input type="submit" name="addVenue" value="Add">
                </form>
                <div class="venue-added-message">
                    <?php
                    if(isset($_POST['addVenue'])) {
                        if($venueAdded > 0) {
                            echo "<p>Venue Added Successfully!</p>";
                        }
                        else {
                            echo "<p>Something went wrong...Please try again</p>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-3">
                <h3>Edit Venue</h3>
                <form action="" method="post">
                    <label class="label-inline">Venue ID: </label><input type="text" name="venueID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br>
                    <label class="label-inline">Venue Name: </label><input type="text" name="editVenueName"><br>
                    <label class="label-inline">Max Capacity: </label><input type="text" name="editVenueMaxCap"><br>
                    <input type="submit" name="editVenue" value="Edit">
                </form>
                <?php
                if(isset($_POST['editVenue'])) {
                    if($editVenueSuccess > 0) {
                        echo "<p>Venue Edited Successfully!</p>";
                    }
                    else {
                        echo "<p>Something went wrong...Please try again</p>";
                    }
                }
                ?>
            </div>
            <div class="col-md-3">
                <h3>Delete Venue</h3>
                <form action="" method="post">
                    <label class="label-inline">Venue Name: </label><input type="text" name="deleteVenueName" required><br>
                    <input type="submit" name="deleteVenue" value="Delete">
                </form>
                <div>
                    <?php
                    if(isset($_POST['deleteVenue'])) {
                        if($venuesDeleted > 0) {
                            echo "<p>Venue Deleted Successfully!</p>";
                        }
                        else {
                            echo "<p>No Venue Found</p>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-3">
                <h3>Venues List</h3>
                <div class="venues-list">
                    <?php
                        if(isset($admin) && !empty($admin)) {
                            foreach($admin->viewAllVenues() as $venue) {
                                echo "<p class='admin-block-info'>
                                            <span class='event-row-header'>Name:</span> $venue[name]<br />
                                            <span class='event-row-header'>Capacity:</span> $venue[capacity]<br />
                                          </p>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="button col-md-12">
        <a href="../phpScripts/logout.php">Logout</a>
    </div>
</body>
</html>
