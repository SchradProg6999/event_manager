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
            $dirtyData[] = $_POST['findUserID'];
            $cleanedData = sanitize($dirtyData);
            $recordsFound = $admin->getUserByName($cleanedData);
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
            </div>
            <div class="col-md-3">
                <h3>Find User</h3>
                <form action="" method="post">
                    <label class="label-inline">UserID: </label><input type="text" name="findUserID" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$"><br>
                    <input type="submit" name="findUser" value="Search">
                </form>
            </div>
            <div class="records-found">
                <?php
                    if(!empty($recordsFound) && isset($_POST['findUser'])) {
                        echo "<h4>Record Found!</h4>";
                        foreach($recordsFound as $record) {
                            echo "<p>UserName: <span class='admin-user-lookup-info'>$record[name]</span></p><p>Role: <span class='admin-user-lookup-info'>" . getUserRole($record['role']) . "</span></p>";
                        }
                    }
                    else {
                        //echo "<h4>No Records Found!</h4>";
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="button col-md-12">
        <a href="../phpScripts/logout.php">Logout</a>
    </div>
</body>
</html>
