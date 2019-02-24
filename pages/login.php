<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 10:45 AM
 */

    require_once ('../db/DB.class.php');

    session_name('login');
    session_start();

    $db = DB::getInstance();

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
        $username = html_entity_decode(strip_tags(trim($_POST['username'])));
        $password = html_entity_decode(strip_tags(trim($_POST['password'])));
        $db->login($username, $password);
    }
?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Event Manager Login</title>
    <link rel="stylesheet" href='../assets/css/main.css'>
</head>
<body>
    <h1>Event Manager</h1>
    <div class='login-error'>
        <?php //echo $_SESSION['login_error'] ? "Invalid Username or Password" : "" ?>
    </div>
    <form action="" method="post">
        <label>Username: </label><input type="text" name="username"><br>
        <label>Password: </label><input type="password" name="password"><br>
        <input type="submit" name="submit">
    </form>
</body>
</html>