<form class="data-form" action="" method="post">
    <label class="label-inline">ID: </label><input type="text" name="editUserID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
    <label class="label-inline">Username: </label><input type="text" name="editUsername"><br />
    <label class="label-inline">Password: </label><input type="password" name="editUserPassword"><br />
    <label class="label-inline">Role: </label><input type="text" name="editUserRole" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
    <input class="form-data-submit" type="submit" name="editUser" value="Edit">
</form>