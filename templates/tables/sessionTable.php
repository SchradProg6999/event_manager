<div class="row">
    <div class="col-md-8 main-information-table-wrapper">
        <table border="1" class="main-table-info" id="main-table-info">
            <?php
                session_name('login');
                session_start();
                if(isset($_SESSION['event_manager']) && !empty($_SESSION['event_manager'])) {
                    require_once(dirname(__FILE__) . '/../../classes/EventManagerClass.php');
                    $event_manager = new EventManagerClass($_SESSION['event_manager']);
                    require_once (dirname(__FILE__) . '/../../event_manager/eventManagerSanitization.php');
                    $event_manager->renderSessionListAndOptions();
                }
                else{
                    require_once(dirname(__FILE__) . '/../../classes/AdminClass.php');
                    $admin = new AdminClass($_SESSION['admin']);
                    require_once (dirname(__FILE__) . '/../../admin/adminSanitization.php');
                    $admin->renderSessionListAndOptions();
                }
            ?>
        </table>
    </div>
    <?php require_once (dirname(__FILE__) . '/../displayControls.php') ?>
</div>
<hr class="col-md-8">
<div class="col-md-8 data-controls">
    <?php
        if(isset($_SESSION['event_manager']) && !empty($_SESSION['event_manager'])) {
            echo "<button onclick=replaceData('../templates/forms/sessionForms/addSessionForm.php'," . "'dynamic-form')>Add Session</button>";
            echo "<button onclick=replaceData('../templates/forms/sessionForms/editSessionForm.php'," . "'dynamic-form')>Edit Session</button>";
            echo "<button onclick=replaceData('../templates/forms/sessionForms/deleteSessionForm.php'," . "'dynamic-form')>Delete Session</button>";
        }
        else {
            echo "<button onclick=replaceData('../templates/forms/adminForms/sessionForms/addSessionForm.php'," . "'dynamic-form')>Add Session</button>";
            echo "<button onclick=replaceData('../templates/forms/adminForms/sessionForms/editSessionForm.php'," . "'dynamic-form')>Edit Session</button>";
            echo "<button onclick=replaceData('../templates/forms/adminForms/sessionForms/deleteSessionForm.php'," . "'dynamic-form')>Delete Session</button>";
        }
    ?>
</div>
<div class="col-md-8 dynamic-form">
    <form class="data-form" action="" method="post">
        <label class="label-inline">Session Name: </label><input type="text" name="addSessionEvent" required><br />
        <label class="label-inline">Max Capacity: </label><input type="text" name="addSessionEventCap" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
        <label class="label-inline">Associated Event: </label><input type="text" name="eventID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
        <label class="label-inline">Start Date: </label><input type="text" name="addSessionStartDateEvent" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$" required><br />
        <label class="label-inline">End Date: </label><input type="text" name="addSessionEndDateEvent" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$" required><br />
        <input class="form-data-submit" type="submit" name="addSession" value="Add">
    </form>
</div>
