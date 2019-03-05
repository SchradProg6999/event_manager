<div class="row">
    <div class="col-md-8 main-information-table-wrapper">
        <table border="1" class="main-table-info" id="main-table-info">
            <?php
                require_once(dirname(__FILE__) . '/../../classes/EventManagerClass.php');
                session_name('login');
                session_start();
                if(isset($_SESSION['event_manager']) && !empty($_SESSION['event_manager'])) {
                    $event_manager = new EventManagerClass($_SESSION['event_manager']);
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
        <label class="label-inline">Username: </label><input type="text" name="addUsername" required><br />
        <label class="label-inline">Password: </label><input type="password" name="addPassword" required><br />
        <label class="label-inline">Role: </label><input type="text" name="addRole" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br />
        <input class="form-data-submit" type="submit" name="addUser" value="Add">
    </form>
</div>
