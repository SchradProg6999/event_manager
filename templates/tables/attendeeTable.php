<div class="row">
    <div class="col-md-8 main-information-table-wrapper">
        <table border="1" class="main-table-info" id="main-table-info">
            <?php
                require_once(dirname(__FILE__) . '/../../classes/EventManagerClass.php');
                require_once (dirname(__FILE__) . '/../../event_manager/eventManagerSanitization.php');
                session_name('login');
                session_start();
                if(isset($_SESSION['event_manager']) && !empty($_SESSION['event_manager'])) {
                    $event_manager = new EventManagerClass($_SESSION['event_manager']);
                    require_once (dirname(__FILE__) . '/../../event_manager/eventManagerSanitization.php');
                    $event_manager->renderAttendeeListAndOptions();
                }
            ?>
        </table>
    </div>
    <?php require_once (dirname(__FILE__) . '/../displayControls.php') ?>
</div>
<hr class="col-md-8">
<div class="col-md-8 data-controls">
    <button onclick="replaceData('../templates/forms/attendeeForms/addAttendeeForm.php', 'dynamic-form')">Add Attendee</button>
    <button onclick="replaceData('../templates/forms/attendeeForms/editAttendeeForm.php', 'dynamic-form')">Edit Attendee</button>
    <button onclick="replaceData('../templates/forms/attendeeForms/deleteAttendeeForm.php', 'dynamic-form')">Delete Attendee</button>
</div>
<div class="col-md-8 dynamic-form">
    <form class="data-form" action="" method="post">
        <label class="label-inline">User ID: </label><input type="text" name="addUserID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
        <label class="label-inline">Event ID: </label><input type="text" name="addEventAssoc" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required> <br />
        <input class="form-data-submit" type="submit" name="addUser" value="Add">
    </form>
    <div class="form-db-error">
        <?php
            if(isset($_POST['addUser'])) {
                checkDBRecordStatus($userStatus, 'User', 'add');
            }
            if(isset($_POST['editUser'])) {
                checkDBRecordStatus($userStatus, 'User', 'edit');
            }
            if(isset($_POST['deleteUser'])) {
                checkDBRecordStatus($userStatus, 'User', 'delete');
            }
        ?>
    </div>
</div>
