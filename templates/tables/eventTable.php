<div class="row">
    <div class="col-md-8 main-information-table-wrapper">
        <table border="1" class="main-table-info" id="main-table-info">
            <?php
                require_once(dirname(__FILE__) . '/../../classes/EventManagerClass.php');
                session_name('login');
                session_start();
                if(isset($_SESSION['event_manager']) && !empty($_SESSION['event_manager'])) {
                    $event_manager = new EventManagerClass($_SESSION['event_manager']);
                    $event_manager->renderEventListAndOptions();
                }
            ?>
        </table>
    </div>
    <?php require_once (dirname(__FILE__) . '/../displayControls.php') ?>
</div>
<hr class="col-md-8">
<div class="col-md-8 data-controls">
    <button onclick="replaceData('../templates/forms/eventForms/addEventForm.php', 'dynamic-form')">Add Event</button>
    <button onclick="replaceData('../templates/forms/eventForms/editEventForm.php', 'dynamic-form')">Edit Event</button>
    <button onclick="replaceData('../templates/forms/eventForms/deleteEventForm.php', 'dynamic-form')">Delete Event</button>
</div>
<div class="col-md-8 dynamic-form">
    <form class="data-form" action="" method="post">
        <label class="label-inline">Event Name: </label><input type="text" name="addEventName" required><br />
        <label class="label-inline">Start Date: </label><input type="text" name="addEventStartDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br />
        <label class="label-inline">End Date: </label><input type="text" name="addEventEndDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br />
        <label class="label-inline">Maximum Capacity: </label><input type="text" name="addEventMaxCap"><br />
        <label class="label-inline">Associated Venue: </label><input type="text" name="addAssocVenue"><br />
        <input class="form-data-submit" type="submit" name="addEvent" value="Add">
    </form>
</div>