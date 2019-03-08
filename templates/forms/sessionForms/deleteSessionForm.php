<form class="data-form" action="" method="post">
    <label class="label-inline">Session ID: </label><input type="text" name="deleteSessionID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
    <label class="label-inline">Event ID: </label><input type="text" name="deleteSessionEventID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
    <input class="form-data-submit" type="submit" name="deleteSession" value="Delete">
</form>