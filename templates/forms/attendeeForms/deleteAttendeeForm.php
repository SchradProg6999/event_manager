<form class="data-form" action="" method="post">
    <label class="label-inline">User ID: </label><input type="text" name="deleteUserByID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
    <label class="label-inline">Event ID: </label><input type="text" name="deleteEventAssoc" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
    <input class="form-data-submit" type="submit" name="deleteUser" value="Delete">
</form>