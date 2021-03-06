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
        $loginStatus = $db->login($username, $password);
    }
?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Event Manager Login</title>
    <link rel="stylesheet" href='../assets/css/main.css'>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="login-header">Event Manager</h1>
            </div>
            <div class='col-md-12 login-error'>
                <?php
                if(isset($_POST['username']) && isset($_POST['password'])) {
                    if($loginStatus === false) {
                        echo "Invalid Username or Password";
                        echo "<audio controls loop autoplay><source src='../assets/audio/magic_word.ogg' type='audio/mpeg'></audio>";
                    }
                }
                ?>
            </div>
            <div class="col-md-12 login-form">
                <form class="data-form" action="" method="post">
                    <label class="label-inline">Username: </label><input type="text" name="username"><br>
                    <label class="label-inline">Password: </label><input type="password" value="testing" name="password"><br>
                    <input class="form-data-submit" type="submit" name="submit" value="Login">
                </form>
            </div>
        </div>
        <div class='col-md-12 login-error'>
            <?php
            if(isset($_POST['username']) && isset($_POST['password'])) {
                if($loginStatus === false) {
                    echo "<image src='https://media.giphy.com/media/5ftsmLIqktHQA/giphy.gif'>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>