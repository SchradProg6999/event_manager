<form action="" method="post">
    <label class="label-inline">Event Name: </label><input type="text" name="addEventName" required><br />
    <label class="label-inline">Start Date: </label><input type="text" name="addEventStartDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br />
    <label class="label-inline">End Date: </label><input type="text" name="addEventEndDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br />
    <label class="label-inline">Maximum Capacity: </label><input type="text" name="addEventMaxCap"><br />
    <label class="label-inline">Associated Venue: </label><input type="text" name="addAssocVenue"><br />
    <input type="submit" name="addEvent" value="Add">
</form>