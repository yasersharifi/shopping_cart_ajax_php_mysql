<?php
include_once "config.php";
include_once "classes/Users.php";
include_once "library/Validate.php";

$usersObject = new Users();
$validateObject = new Validate();

$code = $validateObject->clean($_GET["code"]);
$userInfo = $usersObject->find(array("validation_code", $code));

if (! empty($userInfo) && $userInfo->status == '0') {
    $where["id"] = $userInfo->id;
    $data["status"] = '1';
    $data["id"] = $userInfo->id;;

    if ($usersObject->update($where, $data)) {
        $_SESSION["msg"] = array(
            "success",
            "Activate User successfully"
        );

    } else {
        $_SESSION["msg"] = array(
            "danger",
            "User don't activate"
        );
    }

    header("Location: login.php");
    exit();

} else {
    $_SESSION["msg"] = array(
        "danger",
        "User don't activate"
    );
}

header("Location: login.php");
exit();


