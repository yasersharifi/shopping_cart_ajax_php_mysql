<?php
include_once "config.php";
include_once "classes/Users.php";
include_once "library/Validate.php";

$userObject = new Users();
$validateObject = new Validate();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $validateObject->rules($_POST["name"], "full name", "required");
    $validateObject->rules($_POST["email"], "email", "required|validEmail");

    if ($validateObject->run() == true) {
        $data = array(
            "full_name" => $_POST["name"],
            "email" => $_POST["email"],
            "password" => $_POST["password"],
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


