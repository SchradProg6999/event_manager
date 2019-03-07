<form class="data-form" action="" method="post">
    <label class="label-inline">Session ID: </label><input type="text" name="deleteSessionID" required><br />
    <input class="form-data-submit" type="submit" name="deleteSession" value="Delete">
</form>
<div>
    <?php
    if(isset($_POST['deleteSession'])) {
        checkDBRecordStatus($sessionStatus, 'Session', 'delete');
    }
    ?>
</div>