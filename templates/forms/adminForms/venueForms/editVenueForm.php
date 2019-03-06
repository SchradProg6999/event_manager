<form class="data-form" action="" method="post">
    <label class="label-inline">Venue ID: </label><input type="text" name="editVenueID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
    <label class="label-inline">Venue Name: </label><input type="text" name="editVenueName"><br />
    <label class="label-inline">Max Capacity: </label><input type="text" name="editVenueMaxCap" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
    <input class="form-data-submit" type="submit" name="editVenue" value="Edit">
</form>
<div>
    <?php
    if(isset($_POST['editVenue'])) {
        checkDBRecordStatus($editVenueStatus, 'Venue', 'edit');
    }
    ?>
</div>