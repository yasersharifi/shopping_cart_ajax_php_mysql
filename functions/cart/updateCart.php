<?php
include_once "./../../config.php";
include_once "./../../classes/Products.php";
include_once "./../../classes/Cart.php";
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
    //request is ajax
    $productsObject = new Products();
    $cartObject = new Cart();

    $response = [];

    if (isset($_POST["action"]) && $_POST["action"] == "updateCart") {
        $data = $_POST["data"];
        $cookie_id = md5(session_id());
        if ($cartObject->updateBatch($data, $cookie_id)) {
            $response = array(
                "status" => "ok",
                "message" => "Updated cart successfully.",
            );
        } else {
            $response = array(
                "status" => "error",
                "message" => "Don't cart Updated.",
            );
        }

    } else {
        $response = array(
            "status" => "error",
            "message" => "Don't cart Updated."
        );
    }
    echo json_encode($response);
}