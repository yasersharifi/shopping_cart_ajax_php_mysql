<?php
include_once "./../../Products.php";
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
    //request is ajax
    $productsObject = new Products();
    if (isset($_POST["action"]) && $_POST["action"] == "addToCart") {
        $productId = $_POST["productId"];
        $productInfo = $productsObject->getById($productId);
    }

    echo json_encode(array($productInfo));
}