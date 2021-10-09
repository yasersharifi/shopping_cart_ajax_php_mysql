<?php
include_once "config.php";
include_once "classes/Users.php";
include_once "library/Validate.php";
include_once "library/Hashing.php";
include_once "library/SendEmail.php";

$userObject = new Users();
$validateObject = new Validate();
$hashObject = new Hashing();
$emailObject = new SendEmail();

// check user is login
if (isset($_SESSION["userInfo"])) {
    if ($_SESSION["userInfo"]["isLogin"] == true) {
        header("Location: index.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $validateObject->rules("email", "email", "required|validEmail");
    $validateObject->rules("password", "password", "required");

    if ($validateObject->run() == true) {
        $email = $validateObject->clean($_POST["email"], true);
        $password = $hashObject->md5($validateObject->clean($_POST["password"], true));

        $userInfo = $userObject->find(array("email" => $email));
        if (! empty($userInfo)) {
            if ($userInfo->password == $password && $userInfo->status == '1') {
                $_SESSION["userInfo"] = array(
                    "isLogin" => true,
                    "userId" => $userInfo->id,
                    "email" => $userInfo->email,
                    "password" => $userInfo->password,
                    "mobile" => $userInfo->mobile
                );

                $_SESSION["msg"] = array(
                    "success",
                    "User Login successfully."
                );
                header("Location: index.php");
                exit();
            }
        }
    }

    $_SESSION["msg"] = array(
        "success",
        "User don't Login."
    );

}

// load view
require_once "views/myAccount/login.php";
?>