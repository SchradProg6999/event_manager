<form action="" method="post">
    <label class="label-inline">Username: </label><input type="text" name="addUsername" required><br />
    <label class="label-inline">Password: </label><input type="password" name="addPassword" required><br />
    <label class="label-inline">Role: </label><input type="text" name="addRole" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
    <input type="submit" name="addUser" value="Add">
</form>