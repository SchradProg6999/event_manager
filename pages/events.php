<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 10:45 AM
 */

    session_name('login');
    session_start();

    if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        $_SESSION['redirected'] = true;
        header('Location: login.php');
    }

    require_once (dirname(__FILE__) . '/../db/DB.class.php');
    require_once ('../templates/globalNav/header.php');

    $db = DB::getInstance();

?>

<div class="container container-block table-data-container">
    <div class="col-md-12 events-page-header">
        <h1>Events</h1>
    </div>
    <div class="row">
        <div class="col-md-12 main-information-table-wrapper">
            <table border="1" class="main-table-info" id="main-table-info">
                <?php
                foreach($db->getEventTableColumns() as $column => $columnName) {
                    echo "<th>$columnName[column_name]</th>";
                }
                foreach($db->viewAllEvents() as $event => $eventInfo) {
                    echo "<tr><td>$eventInfo[idevent]</td><td>$eventInfo[name]</td><td>$eventInfo[datestart]</td><td>$eventInfo[dateend]</td><td>$eventInfo[numberallowed]</td><td>$eventInfo[venue]</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</div>
