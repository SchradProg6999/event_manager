<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 10:45 AM
 */

    require_once ('../classes/AdminClass.php');
    require_once ('../classes/EventManagerClass.php');
    require_once ('../phpScripts/getuserrole.php');
    require_once ('../phpScripts/checkDBRecordStatus.php');

    session_name('login');
    session_start();

    if(isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
        $title = "Admin (admin)";
        $admin = new AdminClass($_SESSION['username']);
        require_once ('../templates/globalNav/header.php');
        require_once ('../admin/adminSanitization.php');
        require_once('../admin/adminHTML.php');
    }
    else if(isset($_SESSION['event_manager']) && $_SESSION['event_manager'] === true) {
        $title = "Admin (Event Manager)";
        $GLOBALS['event_manager'] = new EventManagerClass($_SESSION['username']);
        require_once ('../templates/globalNav/header.php');
        require_once ('../event_manager/eventManagerSanitization.php');
        require_once('../event_manager/eventManagerHTML.php');
    }
    else { // user tried to directly access admin page without logging in... or it's just a burglar trying to hack our data!
        $_SESSION['redirected'] = true;
        header('Location: login.php');
    }
?>
