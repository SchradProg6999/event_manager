<form class="data-form" action="" method="post">
    <label class="label-inline">UserID: </label><input type="text" name="deleteUserByID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
    <input class="form-data-submit" type="submit" name="deleteUser" value="Delete">
</form>
<div>
    <?php
    if(isset($_POST['deleteUser'])) {
        if($recordsDeleted > 0) {
            echo "<p>Record Deleted Successfully!</p>";
        }
    }
    ?>
</div>