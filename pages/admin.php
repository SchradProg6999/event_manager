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

    session_name('login');
    session_start();

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

// check if admin filled out addUser form
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addUsername']) && isset($_POST['addPassword']) && isset($_POST['addRole'])) {
        // sanitize the data
        $cleanedData = sanitize([$_POST['addUsername'], $_POST['addPassword'], $_POST['addRole']]);
        $admin->addUser($cleanedData);
    }

?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href='../assets/css/main.css'>
</head>
<body>
<h1>Good day, <?php echo $_SESSION['username']?>! </h1>
    <div class="button">
        <a href="../phpScripts/logout.php">Logout</a>
    </div>
    <div>
        <h3>Add User</h3>
        <form action="admin.php" method="post">
            <label>Username: </label><input type="text" name="addUsername"><br>
            <label>Password: </label><input type="password" name="addPassword"><br>
            <label>Role: </label><input type="text" name="addRole"><br>
            <input type="submit" name="addUser">
        </form>
    </div>
</body>
</html>
