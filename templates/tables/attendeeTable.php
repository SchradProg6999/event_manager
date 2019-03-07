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
                    $event_manager->renderAttendeeListAndOptions();
                }
                else{
                    require_once(dirname(__FILE__) . '/../../classes/AdminClass.php');
                    $admin = new AdminClass($_SESSION['admin']);
                    require_once (dirname(__FILE__) . '/../../admin/adminSanitization.php');
                    $admin->renderAttendeeListAndOptions();
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
            echo "<button onclick=replaceData('../templates/forms/attendeeForms/addAttendeeForm.php'," . "'dynamic-form')>Add Attendee</button>";
            echo "<button onclick=replaceData('../templates/forms/attendeeForms/editAttendeeForm.php'," . "'dynamic-form')>Edit Attendee</button>";
            echo "<button onclick=replaceData('../templates/forms/attendeeForms/deleteAttendeeForm.php'," . "'dynamic-form')>Delete Attendee</button>";
        }
        else {
            echo "<button onclick=replaceData('../templates/forms/adminForms/attendeeForms/addAttendeeForm.php'," . "'dynamic-form')>Add Attendee</button>";
            echo "<button onclick=replaceData('../templates/forms/adminForms/attendeeForms/editAttendeeForm.php'," . "'dynamic-form')>Edit Attendee</button>";
            echo "<button onclick=replaceData('../templates/forms/adminForms/attendeeForms/deleteAttendeeForm.php'," . "'dynamic-form')>Delete Attendee</button>";
        }
    ?>
</div>
<div class="col-md-8 dynamic-form">
    <?php
        if(isset($_SESSION['event_manager']) && !empty($_SESSION['event_manager'])) {
            require_once (dirname(__FILE__) . "/../forms/attendeeForms/addAttendeeForm.php");
        }
        else {
            require_once (dirname(__FILE__) . "/../forms/adminForms/attendeeForms/addAttendeeForm.php");
        }
    ?>
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
