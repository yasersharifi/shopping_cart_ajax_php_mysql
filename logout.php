<?php
include_once "config.php";

if (isset($_SESSION["userInfo"])) {
    unset($_SESSION["userInfo"]);
    session_destroy();
}

header("Location: login.php");
exit();
