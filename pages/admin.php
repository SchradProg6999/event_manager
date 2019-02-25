<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 10:45 AM
 */

    require_once ('../classes/AdminClass.php');
    require_once ('../classes/EventManagerClass.php');
    require_once ('../phpScripts/sanitize.php');
    require_once ('../phpScripts/getuserrole.php');

    session_name('login');
    session_start();

    $recordsFound = [];
    $recordsDeleted = "";

    if($_SESSION['admin'] === true) {
        $admin = new AdminClass($_SESSION['username']);
    }
    else if($_SESSION['event_manager'] === true) {
        $eventManager = new EventManagerClass($_SESSION['username']);
    }
    else { // user tried to directly access admin page without logging in
        $_SESSION['redirected'] = true;
        header('Location: login.php');
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // adding a user
        if(isset($_POST['addUser'])) {
            $requiredFields = array('addUsername', 'addPassword', 'addRole');
            $dirtyData = [];
            foreach($requiredFields as $requiredField) {
                if(!isset($_POST[$requiredField])) {
                    $error = 'One of the required fields is missing';
                }
                else {
                    $dirtyData[] = $_POST[$requiredField];
                }
            }
            // sanitize the data
            $cleanedData = sanitize($dirtyData);

            if($admin->addUser($cleanedData) === false) {
                echo 'query failed';
            }
        }

        // editing a user
        if(isset($_POST['editUser'])) {
            if(!isset($_POST['editID'])) {
                echo 'Must input a User ID!';
                return $error = "Must input a User ID";
            }
            else {
                $dirtyData = [];
                $requiredFields = array('editID', 'editUsername', 'editPassword', 'editRole');
                foreach($requiredFields as $requiredField) {
                    if(isset($_POST[$requiredField])) {
                        $dirtyData[] = $_POST[$requiredField];
                    }
                    else {
                        return;
                    }
                }
                // scrub! scrub! scrub! three toads in a tub!
                $cleanedData = sanitize($dirtyData);
                $editSuccess = $admin->editUser($cleanedData);
            }
        }

        // looking up a user
        if(isset($_POST['findUser'])) {
            $dirtyData = [];
            if(isset($_POST['findUserID'])) {
                $dirtyData[] = $_POST['findUserID'];
                $cleanedData = sanitize($dirtyData);
                $recordsFound = $admin->getUserByName($cleanedData);
            }
        }


        if(isset($_POST['deleteUser'])) {
            $dirtyData = [];
            $dirtyData[] = $_POST['deleteUserByID'];
            $cleanedData = sanitize($dirtyData);
            $recordsDeleted = $admin->deleteUser($cleanedData);
        }

        if(isset($_POST['addEvent'])) {
            $requiredFields = array('addEventName', 'addEventStartDate', 'addEventEndDate', 'addEventMaxCap', 'addAssocVenue');
            $dirtyData = [];
            foreach($requiredFields as $requiredField) {
                if(!isset($_POST[$requiredField])) {
                    exit();
                }

                // for the dates
                if($requiredField == 'addEventStartDate' || $requiredField == 'addEventEndDate') {
                    $newDate = $_POST[$requiredField];
                    $newDate = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $newDate);
                    $dirtyData[] = $newDate;
                }
                else {
                    $dirtyData[] = $_POST[$requiredField];
                }
            }
            // sanitize the data
            $cleanedData = sanitize($dirtyData);

            if($admin->addEvent($cleanedData) === false) {
                echo 'query failed';
            }
        }
    }

?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <link rel="stylesheet" href='../assets/css/main.css'>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="col-md-12">
        <h1>Good day, <?php echo $_SESSION['username']?>! </h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3>Add User</h3>
                <form action="" method="post">
                    <label class="label-inline">Username: </label><input type="text" name="addUsername"><br>
                    <label class="label-inline">Password: </label><input type="password" name="addPassword"><br>
                    <label class="label-inline">Role: </label><input type="text" name="addRole"><br>
                    <input type="submit" name="addUser" value="Add">
                </form>
            </div>
            <div class="col-md-3">
                <h3>Edit User</h3>
                <form action="" method="post">
                    <label class="label-inline">ID: </label><input type="text" name="editID" required><br>
                    <label class="label-inline">Username: </label><input type="text" name="editUsername"><br>
                    <label class="label-inline">Password: </label><input type="password" name="editPassword"><br>
                    <label class="label-inline">Role: </label><input type="text" name="editRole"><br>
                    <input type="submit" name="editUser" value="Edit">
                </form>
            </div>
            <div class="col-md-3">
                <h3>Delete User</h3>
                <form action="" method="post">
                    <label class="label-inline">UserID: </label><input type="text" name="deleteUserByID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br>
                    <input type="submit" name="deleteUser" value="Delete">
                </form>
                <div>
                    <?php
                        if(isset($_POST['deleteUser'])) {
                            if($recordsDeleted > 0) {
                                echo "<p>Record Deleted Successfully!</p>";
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="col-md-3">
                <h3>Find User</h3>
                <form action="" method="post">
                    <label class="label-inline">UserID: </label><input type="text" name="findUserID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" required><br>
                    <input type="submit" name="findUser" value="Search">
                </form>
            </div>
            <div class="records-found">
                <?php
                    if(isset($_POST['findUser'])) {
                        if(sizeof($recordsFound) > 0) {
                            echo "<h4>Record Found!</h4>";
                            foreach($recordsFound as $record) {
                                echo "<p>UserName: <span class='admin-user-lookup-info'>$record[name]</span></p><p>Role: <span class='admin-user-lookup-info'>" . getUserRole($record['role']) . "</span></p>";
                            }
                        }
                        else {
                            echo "<h4>No Records Found!</h4>";
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-3">
            <h3>Add Event</h3>
            <form action="" method="post">
                <label class="label-inline">Event Name: </label><input type="text" name="addEventName" required><br>
                <label class="label-inline">Start Date: </label><input type="text" name="addEventStartDate" placeholder="1999-01-01 21:30:00" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br>
                <label class="label-inline">End Date: </label><input type="text" name="addEventEndDate" pattern="^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$"><br>
                <label class="label-inline">Maximum Capacity: </label><input type="text" name="addEventMaxCap"><br>
                <label class="label-inline">Associated Venue: </label><input type="text" name="addAssocVenue"><br>
                <input type="submit" name="addEvent" value="Add">
            </form>
        </div>
    </div>
    <div class="button col-md-12">
        <a href="../phpScripts/logout.php">Logout</a>
    </div>
</body>
</html>
