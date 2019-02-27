<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/27/2019
 * Time: 10:48 AM
 */

    function checkDBRecordStatus($varToCheck, $tableName, $actionPerformed) {

        switch($actionPerformed) {
            case 'add':
                $action = "Added";
                break;
            case 'edit':
                $action = "Edited";
                break;
            case 'delete':
                $action = "Deleted";
                break;
            case 'find':
                $action = "Found";
                break;
        }

        if($varToCheck > 0) {
            echo "<p>{$tableName} {$action} Successfully!</p>";
        }
        else {
            echo "<p>Something went wrong... Please try again</p>";
        }
    }