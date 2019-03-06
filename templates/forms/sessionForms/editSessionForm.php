<form class="data-form" action="" method="post">
    <label class="label-inline">Event ID: </label><input type="text" name="editSessionEventID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
    <label class="label-inline">Session ID: </label><input type="text" name="editSessionID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
    <label class="label-inline">Session Name: </label><input type="text" name="editSessionName"><br />
    <label class="label-inline">Max Capacity: </label><input type="text" name="editSessionMaxCap" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
    <label class="label-inline">Session's Event: </label><input type="text" name="editSessionEvent" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
    <label class="label-inline">Start Date: </label><input type="text" name="editSessionStartDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br />
    <label class="label-inline">End Date: </label><input type="text" name="editSessionEndDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br />
    <input class="form-data-submit" type="submit" name="editSession" value="Edit">
</form>