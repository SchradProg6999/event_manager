<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 6:22 PM
 */

    // gets any data array passed into it super squeaky clean before it heads off to the database
    function sanitize($arrayToClean) {
        $cleanedData = [];

        foreach($arrayToClean as $key => $dataToClean) {
            $cleanedData[] = html_entity_decode(strip_tags(trim($dataToClean)));
        }

        return $cleanedData;
    }