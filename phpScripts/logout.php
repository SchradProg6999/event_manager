<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 2/23/2019
 * Time: 4:46 PM
 */

    session_name('login');
    session_start();
    unset($_SESSION);
    session_destroy();
    header('Location: ../pages/login.php');

