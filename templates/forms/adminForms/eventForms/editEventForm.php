<form class="data-form" action="" method="post">
    <label class="label-inline">Event ID: </label><input type="text" name="editEventID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
    <label class="label-inline">Event Name: </label><input type="text" name="editEventName"><br />
    <label class="label-inline">Start Date: </label><input type="text" name="editEventStartDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br />
    <label class="label-inline">End Date: </label><input type="text" name="editEventEndDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br />
    <label class="label-inline">Maximum Capacity: </label><input type="text" name="editEventMaxCap" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
    <input class="form-data-submit" type="submit" name="editEvent" value="Edit">
</form>
<div>
    <?php
    if(isset($_POST['editEvent'])) {
        checkDBRecordStatus($eventStatus, 'Event', 'edit');
    }
    ?>
</div>