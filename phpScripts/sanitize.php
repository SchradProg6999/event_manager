<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 6:22 PM
 */

    function sanitize($arrayToClean) {
        $cleanedData = [];

        foreach($arrayToClean as $key => $dataToClean) {
            $cleanedData[] = html_entity_decode(strip_tags(trim($dataToClean)));
        }

        return $cleanedData;
    }