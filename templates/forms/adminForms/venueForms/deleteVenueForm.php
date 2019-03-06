<form class="data-form" action="" method="post">
    <label class="label-inline">Venue ID: </label><input type="text" name="deleteVenueID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
    <input class="form-data-submit" type="submit" name="deleteVenue" value="Delete">
</form>
<div>
    <?php
    if(isset($_POST['deleteVenue'])) {
        checkDBRecordStatus($venueDeleteStatus, 'Venue', 'delete');
    }
    ?>
</div>