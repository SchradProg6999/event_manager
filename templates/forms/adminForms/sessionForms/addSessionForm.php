<form class="data-form" action="" method="post">
    <label class="label-inline">Session Name: </label><input type="text" name="addSessionEvent" required><br />
    <label class="label-inline">Max Capacity: </label><input type="text" name="addSessionEventCap" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
    <label class="label-inline">Associated Event: </label><input type="text" name="eventID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
    <label class="label-inline">Start Date: </label><input type="text" name="addSessionStartDateEvent" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$" required><br />
    <label class="label-inline">End Date: </label><input type="text" name="addSessionEndDateEvent" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$" required><br />
    <input class="form-data-submit" type="submit" name="addSession" value="Add">
</form>
<div class="session-added-message">
    <?php
    if(isset($_POST['addSession'])) {
        checkDBRecordStatus($addSessionStatus, 'Session', 'add');
    }
    ?>
</div>