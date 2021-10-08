<?php
include_once "config.php";
include_once "classes/Users.php";
include_once "library/Validate.php";
include_once "library/Hashing.php";

$userObject = new Users();
$validateObject = new Validate();
$hashObject = new Hashing();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $validateObject->rules("name", "full name", "required");
    $validateObject->rules("email", "email", "required|validEmail");
    $validateObject->rules("password", "password", "required");
    $validateObject->rules("confPassword", "confirm password", "required|match", "confPassword");


    if ($validateObject->run() == true) {
        $data = array(
            "full_name" => $validateObject->clean($_POST["name"], true),
            "email" => $validateObject->clean($_POST["email"], true),
            "password" => $hashObject->md5($validateObject->clean($_POST["password"], true)),
        );

        if ($userObject->insert($data) == true) {
            $_SESSION["msg"] = array(
                "success",
                "Register User successfully"
            );
            header("Location: login.php");
            exit();

        } else {
            $_SESSION["msg"] = array(
                "danger",
                "User don't register"
            );
        }
    }

}

// load view
require_once "views/myAccount/register.php";
?>


