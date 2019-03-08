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
                    $event_manager->renderEventListAndOptions();
                }
                else{
                    require_once(dirname(__FILE__) . '/../../classes/AdminClass.php');
                    $admin = new AdminClass($_SESSION['admin']);
                    require_once (dirname(__FILE__) . '/../../admin/adminSanitization.php');
                    $admin->renderEventListAndOptions();
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
            echo "<button onclick=replaceData('../templates/forms/eventForms/addEventForm.php'," . "'dynamic-form')>Add Event</button>";
            echo "<button onclick=replaceData('../templates/forms/eventForms/editEventForm.php'," . "'dynamic-form')>Edit Event</button>";
            echo "<button onclick=replaceData('../templates/forms/eventForms/deleteEventForm.php'," . "'dynamic-form')>Delete Event</button>";
        }
        else {
            echo "<button onclick=replaceData('../templates/forms/adminForms/eventForms/addEventForm.php'," . "'dynamic-form')>Add Event</button>";
            echo "<button onclick=replaceData('../templates/forms/adminForms/eventForms/editEventForm.php'," . "'dynamic-form')>Edit Event</button>";
            echo "<button onclick=replaceData('../templates/forms/adminForms/eventForms/deleteEventForm.php'," . "'dynamic-form')>Delete Event</button>";
        }
    ?>
</div>
<div class="col-md-8 dynamic-form">
    <?php
    if(isset($_SESSION['event_manager']) && !empty($_SESSION['event_manager'])) {
        require_once (dirname(__FILE__) . "/../forms/eventForms/addEventForm.php");
    }
    else {
        require_once (dirname(__FILE__) . "/../forms/adminForms/eventForms/addEventForm.php");
    }
    ?>
    <div class="form-db-error">
        <?php
        if(isset($_POST['addEvent'])) {
            checkDBRecordStatus($eventStatus, 'Event', 'add');
        }
        ?>
    </div>
</div>