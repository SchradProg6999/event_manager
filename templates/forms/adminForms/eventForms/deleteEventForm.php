<form class="data-form" action="" method="post">
    <label class="label-inline">Event Name: </label><input type="text" name="deleteEventName" required><br />
    <input class="form-data-submit" type="submit" name="deleteEvent" value="Delete">
</form>
<div>
    <?php
    if(isset($_POST['deleteEvent'])) {
        checkDBRecordStatus($eventsDeleted, 'Event', 'delete');
    }
    ?>
</div>