<div class="col-md-2 info-display-controls-wrapper">
    <button class="info-display-controls" onclick="replaceData('../templates/tables/eventTable.php', 'table-data-container')">View Events</button>
    <button class="info-display-controls" onclick="replaceData('../templates/tables/sessionTable.php', 'table-data-container')">View Sessions</button>
    <button class="info-display-controls" onclick="replaceData('../templates/tables/attendeeTable.php', 'table-data-container')">View Attendees</button>
    <?php
        if(isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] === true) {
            echo "<button class='info-display-controls' onclick=replaceData('../templates/tables/venueTable.php'," . "'table-data-container')>View Venues</button>";
        }
    ?>
</div>