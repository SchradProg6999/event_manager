<!--  USER OPTIONS  -->
<div class="container container-block">
    <h2 class="admin-control-header">User Options</h2>
    <div class="row">
        <div class="col-md-3">
            <h3>Add User</h3>
            <form action="" method="post">
                <label class="label-inline">Username: </label><input type="text" name="addUsername" required><br />
                <label class="label-inline">Password: </label><input type="password" name="addPassword" required><br />
                <label class="label-inline">Role: </label><input type="text" name="addRole" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
                <input type="submit" name="addUser" value="Add">
            </form>
            <div>
                <?php
                if(isset($_POST['addUser'])) {
                    checkDBRecordStatus($addUserStatus, 'User', 'add');
                }
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <h3>Edit User</h3>
            <form action="" method="post">
                <label class="label-inline">ID: </label><input type="text" name="editUserID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
                <label class="label-inline">Username: </label><input type="text" name="editUsername"><br />
                <label class="label-inline">Password: </label><input type="password" name="editUserPassword"><br />
                <label class="label-inline">Role: </label><input type="text" name="editUserRole" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
                <input type="submit" name="editUser" value="Edit">
            </form>
            <div>
                <?php
                if(isset($_POST['editUser'])) {
                    checkDBRecordStatus($editUserStatus, 'User', 'edit');
                }
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <h3>Delete User</h3>
            <form action="" method="post">
                <label class="label-inline">UserID: </label><input type="text" name="deleteUserByID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
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
                <label class="label-inline">UserID: </label><input type="text" name="findUserID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
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
        <div class="col-md-4">
            <h3>Add Event</h3>
            <form action="" method="post">
                <label class="label-inline">Event Name: </label><input type="text" name="addEventName" required><br />
                <label class="label-inline">Start Date: </label><input type="text" name="addEventStartDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br />
                <label class="label-inline">End Date: </label><input type="text" name="addEventEndDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br />
                <label class="label-inline">Maximum Capacity: </label><input type="text" name="addEventMaxCap"><br />
                <label class="label-inline">Associated Venue: </label><input type="text" name="addAssocVenue"><br />
                <input type="submit" name="addEvent" value="Add">
            </form>
            <div>
                <?php
                if(isset($_POST['addEvent'])) {
                    checkDBRecordStatus($eventAddStatus, 'Event', 'add');
                }
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <h3>Edit Event</h3>
            <form action="" method="post">
                <label class="label-inline">Event ID: </label><input type="text" name="editEventID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
                <label class="label-inline">Event Name: </label><input type="text" name="editEventName"><br />
                <label class="label-inline">Start Date: </label><input type="text" name="editEventStartDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br />
                <label class="label-inline">End Date: </label><input type="text" name="editEventEndDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br />
                <label class="label-inline">Maximum Capacity: </label><input type="text" name="editEventMaxCap" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
                <label class="label-inline">Associated Venue: </label><input type="text" name="editAssocVenue" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
                <input type="submit" name="editEvent" value="Edit">
            </form>
            <div>
                <?php
                if(isset($_POST['editEvent'])) {
                    checkDBRecordStatus($eventEditStatus, 'Event', 'edit');
                }
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <h3>Delete Event</h3>
            <form action="" method="post">
                <label class="label-inline">Event Name: </label><input type="text" name="deleteEventName" required><br />
                <input type="submit" name="deleteEvent" value="Delete">
            </form>
            <div>
                <?php
                if(isset($_POST['deleteEvent'])) {
                    checkDBRecordStatus($eventsDeleted, 'Event', 'delete');
                }
                ?>
            </div>
        </div>
        <div class="col-md-12">
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
        <div class="col-md-4">
            <h3>Add Venue</h3>
            <form action="" method="post">
                <label class="label-inline">Venue Name: </label><input type="text" name="addVenueName" required><br />
                <label class="label-inline">Max Capacity: </label><input type="text" name="addVenueCapacity" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$">
                <input type="submit" name="addVenue" value="Add">
            </form>
            <div class="venue-added-message">
                <?php
                if(isset($_POST['addVenue'])) {
                    checkDBRecordStatus($venueAddStatus, 'Venue', 'add');
                }
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <h3>Edit Venue</h3>
            <form action="" method="post">
                <label class="label-inline">Venue ID: </label><input type="text" name="editVenueID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
                <label class="label-inline">Venue Name: </label><input type="text" name="editVenueName"><br />
                <label class="label-inline">Max Capacity: </label><input type="text" name="editVenueMaxCap" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
                <input type="submit" name="editVenue" value="Edit">
            </form>
            <div>
                <?php
                if(isset($_POST['editVenue'])) {
                    checkDBRecordStatus($editVenueStatus, 'Venue', 'edit');
                }
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <h3>Delete Venue</h3>
            <form action="" method="post">
                <label class="label-inline">Venue Name: </label><input type="text" name="deleteVenueName" required><br />
                <input type="submit" name="deleteVenue" value="Delete">
            </form>
            <?php
            if(isset($_POST['deleteVenue'])) {
                checkDBRecordStatus($venueDeleteStatus, 'Venue', 'delete');
            }
            ?>
        </div>
    </div>
    <div class="col-md-12">
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

<!--  SESSION OPTIONS  -->
<div class="container container-block">
    <h2 class="admin-control-header">Session Options</h2>
    <div class="row">
        <div class="col-md-4">
            <h3>Add Session</h3>
            <form action="" method="post">
                <label class="label-inline">Session Name: </label><input type="text" name="addSessionName" required><br />
                <label class="label-inline">Max Capacity: </label><input type="text" name="addSessionCapacity" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
                <label class="label-inline">Associated Event: </label><input type="text" name="addAssocEvent" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
                <label class="label-inline">Start Date: </label><input type="text" name="addSessionStartDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$" required><br />
                <label class="label-inline">End Date: </label><input type="text" name="addSessionEndDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$" required><br />
                <input type="submit" name="addSession" value="Add">
            </form>
            <div class="session-added-message">
                <?php
                if(isset($_POST['addSession'])) {
                    checkDBRecordStatus($addSessionStatus, 'Session', 'add');
                }
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <h3>Edit Session</h3>
            <form action="" method="post">
                <label class="label-inline">Session ID: </label><input type="text" name="editSessionID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
                <label class="label-inline">Session Name: </label><input type="text" name="editSessionName"><br />
                <label class="label-inline">Max Capacity: </label><input type="text" name="editSessionMaxCap" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
                <label class="label-inline">Session's Event: </label><input type="text" name="editSessionEvent" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
                <label class="label-inline">Start Date: </label><input type="text" name="editSessionStartDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br />
                <label class="label-inline">End Date: </label><input type="text" name="editSessionEndDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br />
                <input type="submit" name="editSession" value="Edit">
            </form>
            <div>
                <?php
                if(isset($_POST['editSession'])) {
                    checkDBRecordStatus($editSessionStatus, 'Session', 'edit');
                }
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <h3>Delete Session</h3>
            <form action="" method="post">
                <label class="label-inline">Session Name: </label><input type="text" name="deleteSessionName" required><br />
                <input type="submit" name="deleteSession" value="Delete">
            </form>
            <div>
                <?php
                if(isset($_POST['deleteSession'])) {
                    checkDBRecordStatus($deleteSessionStatus, 'Session', 'delete');
                }
                ?>
            </div>
        </div>
        <div class="col-md-12">
            <h3>Sessions List</h3>
            <div class="sessions-list">
                <?php
                if(isset($admin) && !empty($admin)) {
                    foreach($admin->viewAllSessions() as $session) {
                        echo "<p class='admin-block-info'>
                                                <span class='event-row-header'>Name:</span> $session[name]<br />
                                                <span class='event-row-header'>Capacity:</span> $session[numberallowed]<br />
                                                <span class='event-row-header'>Event:</span> $session[event]<br />
                                                <span class='event-row-header'>Start Date:</span> $session[startdate]<br />
                                                <span class='event-row-header'>End Date:</span> $session[enddate]<br />
                                              </p>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
