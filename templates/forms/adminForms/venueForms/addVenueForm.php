<form class="data-form" action="" method="post">
    <label class="label-inline">Venue Name: </label><input type="text" name="addVenueName" required><br />
    <label class="label-inline">Max Capacity: </label><input type="text" name="addVenueCapacity" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$">
    <input class="form-data-submit" type="submit" name="addVenue" value="Add">
</form>
<div class="venue-added-message">
    <?php
    if(isset($_POST['addVenue'])) {
        checkDBRecordStatus($venueAddStatus, 'Venue', 'add');
    }
    ?>
</div>