<form class="data-form" action="" method="post">
    <label class="label-inline">Session Name: </label><input type="text" name="deleteSessionName" required><br />
    <input class="form-data-submit" type="submit" name="deleteSession" value="Delete">
</form>
<div>
    <?php
    if(isset($_POST['deleteSession'])) {
        checkDBRecordStatus($deleteSessionStatus, 'Session', 'delete');
    }
    ?>
</div>