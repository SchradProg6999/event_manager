<form class="data-form" action="" method="post">
    <label class="label-inline">Event ID: </label><input type="text" name="deleteEventID" required><br />
    <input class="form-data-submit" type="submit" name="deleteEvent" value="Delete">
</form>
<div>
    <?php
    if(isset($_POST['deleteEvent'])) {
        checkDBRecordStatus($eventStatus, 'Event', 'delete');
    }
    ?>
</div>