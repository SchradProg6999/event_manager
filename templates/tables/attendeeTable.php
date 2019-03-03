<div class="col-md-8 main-information-table-wrapper">
    <table border="1" class="main-table-info" id="main-table-info">
        <?php
        var_dump($GLOBALS['event_manager']);

        if(isset($GLOBALS['event_manager']) && !empty($GLOBALS['event_manager'])) {
                $GLOBALS['event_manager']->renderAttendeeListAndOptions();
            }
        ?>
    </table>
</div>
<hr class="col-md-8">
<div class="col-md-8 data-controls">
    <button onclick="replaceData('../templates/forms/addAttendeeForm.php', 'dynamic-form')">Add Attendee</button>
    <button onclick="replaceData('../templates/forms/editAttendeeForm.php', 'dynamic-form')">Edit Attendee</button>
    <button onclick="replaceData('../templates/forms/deleteAttendeeForm.php', 'dynamic-form')">Delete Attendee</button>
</div>
<div class="col-md-8 dynamic-form">
    <form action="" method="post">
        <label class="label-inline">Username: </label><input type="text" name="addUsername" required><br />
        <label class="label-inline">Password: </label><input type="password" name="addPassword" required><br />
        <label class="label-inline">Role: </label><input type="text" name="addRole" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
        <input type="submit" name="addUser" value="Add">
    </form>
</div>
