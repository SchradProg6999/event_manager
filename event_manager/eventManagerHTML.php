
<?php
var_dump($GLOBALS['event_manager']);
?>

<div class="container container-block table-data-container"></div>
<div class="info-display-controls">
    <button onclick="replaceData('../templates/tables/eventTable.php', 'table-data-container')">View Events</button>
    <button onclick="replaceData('../templates/tables/sessionTable.php', 'table-data-container')">View Sessions</button>
    <button onclick="replaceData('../templates/tables/attendeeTable.php', 'table-data-container')">View Attendees</button>
</div>