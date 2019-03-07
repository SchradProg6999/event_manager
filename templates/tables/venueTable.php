<div class="row">
    <div class="col-md-8 main-information-table-wrapper">
        <table border="1" class="main-table-info" id="main-table-info">
            <?php
            session_name('login');
            session_start();
            require_once(dirname(__FILE__) . '/../../classes/AdminClass.php');
            $admin = new AdminClass($_SESSION['admin']);
            require_once (dirname(__FILE__) . '/../../admin/adminSanitization.php');
            $admin->renderVenueListAndOptions();
            ?>
        </table>
    </div>
    <?php require_once (dirname(__FILE__) . '/../displayControls.php') ?>
</div>
<hr class="col-md-8">
<div class="col-md-8 data-controls">
    <button onclick=replaceData('../templates/forms/adminForms/venueForms/addVenueForm.php','dynamic-form')>Add Venue</button>
    <button onclick=replaceData('../templates/forms/adminForms/venueForms/editVenueForm.php','dynamic-form')>Edit Venue</button>
    <button onclick=replaceData('../templates/forms/adminForms/venueForms/deleteVenueForm.php','dynamic-form')>Delete Venue</button>
</div>
<div class="col-md-8 dynamic-form">
    <form class="data-form" action="" method="post">
        <label class="label-inline">User ID: </label><input type="text" name="addUserID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br />
        <label class="label-inline">Event ID: </label><input type="text" name="addEventAssoc" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required> <br />
        <input class="form-data-submit" type="submit" name="addUser" value="Add">
    </form>
    <div class="form-db-error">
        <?php
        if(isset($_POST['addVenue'])) {
            checkDBRecordStatus($venueStatus, 'User', 'add');
        }
        if(isset($_POST['editVenue'])) {
            checkDBRecordStatus($venueStatus, 'User', 'edit');
        }
        if(isset($_POST['deleteVenue'])) {
            checkDBRecordStatus($venueStatus, 'User', 'delete');
        }
        ?>
    </div>
</div>
