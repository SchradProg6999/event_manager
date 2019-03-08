<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 10:45 AM
 */

session_name('login');
session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    $_SESSION['redirected'] = true;
    header('Location: login.php');
}

require_once (dirname(__FILE__) . '/../db/DB.class.php');
require_once ('../templates/globalNav/header.php');

$db = DB::getInstance();

?>

<div class="container container-block table-data-container">
    <div class="col-md-12 registration-page-header">
        <h1>Registrations Information</h1>
    </div>
    <div class="row registration-table-wrapper">
        <div class="col-md-6 main-information-table-wrapper">
            <h3>Events</h3>
            <table border="1" class="main-table-info" id="main-table-info">
                <?php
                    foreach($db->getEventTableColumns() as $column => $columnName) {
                        echo "<th>$columnName[column_name]</th>";
                    }
                    foreach($db->viewAllEvents() as $event => $eventInfo) {
                        echo "<tr><td>$eventInfo[idevent]</td><td>$eventInfo[name]</td><td>$eventInfo[datestart]</td><td>$eventInfo[dateend]</td><td>$eventInfo[numberallowed]</td><td>$eventInfo[venue]</td></tr>";
                    }
                ?>
            </table>
        </div>
        <div class="col-md-6 main-information-table-wrapper">
            <h3>Sessions</h3>
            <table border="1" class="main-table-info" id="main-table-info">
                <?php
                foreach($db->getSessionTableColumns() as $column => $columnName) {
                    echo "<th>$columnName[column_name]</th>";
                }
                foreach($db->viewAllSessions() as $session => $sessionInfo) {
                    echo "<tr><td>$sessionInfo[idsession]</td><td>$sessionInfo[name]</td><td>$sessionInfo[numberallowed]</td><td>$sessionInfo[event]</td><td>$sessionInfo[startdate]</td><td>$sessionInfo[enddate]</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
    <div class="row register-forms">
        <div class="col-md-6">
            <h4>Register for an event!</h4>
            <form class="data-form" action="" method="post">
                <label class="label-inline">Event ID: </label><input type="text" name="registerEventID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
                <label class="label-inline">Event Name: </label><input type="text" name="registerEventName" required> <br />
                <label class="label-inline">Payment: </label><input type="text" name="registerEventPayment" required> <br />
                <input class="form-data-submit" type="submit" name="registerForEvent" value="Add">
            </form>
        </div>
        <div class="col-md-6">
            <h4>Sign Up for a Session!</h4>
            <p>(Disclaimer) You must already be registered for the event!</p>
            <form class="data-form" action="" method="post">
                <label class="label-inline">Event ID: </label><input type="text" name="addUserID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
                <label class="label-inline">Session ID: </label><input type="text" name="addEventAssoc" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required> <br />
                <input class="form-data-submit" type="submit" name="addUser" value="Add">
            </form>
        </div>
    </div>

    <div class="attendee-registration-information">
        <div class="col-md-12 registration-page-header">
            <h1>Your Registrations</h1>
        </div>
        <div class="row registration-table-wrapper">
            <div class="col-md-6 main-information-table-wrapper">
                <h3>Events</h3>
                <table border="1" class="main-table-info" id="main-table-info">
                    <?php
                        if(empty($db->getEventsByUserID($_SESSION['userID']))) {
                            echo "<p class='no-registered-events-msg'>Whoops! It looks like you aren't registered to any events!!!  :(</p>";
                        }
                        else {
                            echo "<th>Venue Name</th><th>Event Name</th><th>Event StartDate</th><th>Event EndDate</th><th>Money Paid</th>";
                            foreach($db->getEventsByUserID($_SESSION['userID']) as $event => $eventInfo) {
                                echo "<tr><td>$eventInfo[0]</td><td>$eventInfo[name]</td><td>$eventInfo[datestart]</td><td>$eventInfo[dateend]</td><td>$$eventInfo[paid]</td></tr>";
                            }
                        }
                    ?>
                </table>
            </div>
            <div class="col-md-6 main-information-table-wrapper">
                <h3>Sessions</h3>
                <table border="1" class="main-table-info" id="main-table-info">
                    <?php
                        if(empty($db->getSessionsByUserID($_SESSION['userID']))) {
                            echo "<p class='no-registered-events-msg'>Whoops! It looks like you aren't signed up for any sessions!!!  :(</p>";
                        }
                        else {
                            echo "<th>Session Name</th><th>Event ID</th><th>Session StartDate</th><th>Session EndDate</th>";
                            foreach($db->getSessionsByUserID($_SESSION['userID']) as $session => $sessionInfo) {
                                echo "<tr><td>$sessionInfo[name]</td><td>$sessionInfo[event]</td><td>$sessionInfo[startdate]</td><td>$sessionInfo[enddate]</td></tr>";
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>