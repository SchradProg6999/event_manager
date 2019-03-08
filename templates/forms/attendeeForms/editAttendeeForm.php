<form class="data-form" action="" method="post">
    <label class="label-inline">User ID: </label><input type="text" name="editUserID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
    <label class="label-inline">Old Event ID: </label><input type="text" name="editOldEventAssoc" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
    <label class="label-inline">New Event ID: </label><input type="text" name="editNewEventAssoc" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
    <input class="form-data-submit" type="submit" name="editUser" value="Edit">
</form>